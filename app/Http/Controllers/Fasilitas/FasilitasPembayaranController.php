<?php

namespace App\Http\Controllers\Fasilitas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class FasilitasPembayaranController extends Controller
{
    public function index()
    {
        $tagihan = Tagihan::with(['penyewaan'])
                        ->where('status', 'Approved by Administrasi')
                        ->whereNotIn('status', ['Riwayat'])
                        ->paginate(10);

        return view('fasilitas.pembayaran.index', compact('tagihan'));
    }

    public function show($id)
    {
        $tagihan = Tagihan::with(['penyewaan'])
                        ->where('status', 'Approved by Administrasi')
                        ->whereNotIn('status', ['Riwayat'])
                        ->findOrFail($id);

        return view('fasilitas.pembayaran.show', compact('tagihan'));
    }

    public function showPdf($id)
    {
        $tagihan = Tagihan::with(['penyewaan'])->findOrFail($id);
                            
        $path = str_replace('storage/', 'app/public/', $tagihan->link_pdf);

        $pdfPath = storage_path($path);

        if (!$pdfPath) {
            abort(404, 'PDF tidak ditemukan');
        }

        return response()->file($pdfPath);
    }

    public function decline(Request $request, $id)
    {
        $tagihan = Tagihan::with(['penyewaan'])
                        ->where('status', 'Approved by Administrasi')
                        ->findOrFail($id);
        
        $tagihan->status = 'Rejected by Fasilitas';
        $tagihan->reject_notes = $request->reject_notes;
        
        $tagihan->save();

        return redirect()->route('fasilitas.sewa-kendaraan.index')->with('success', 'Pengajuan berhasil disetujui.');
    }
    
    public function approve($id)
    {
        $tagihan = Tagihan::with(['penyewaan'])
                        ->where('status', 'Approved by Administrasi')
                        ->findOrFail($id);

        if ($tagihan->link_pembayaran != null) {
            return redirect()->away($tagihan->link_pembayaran);
        }
    
        try {
            $xenditApiKey = env('XENDIT_API_KEY');
            $external_id = 'TAGIHAN_' . $tagihan->id;
            $baseurl = env('APP_URL');
            $tagihan_id = encrypt($tagihan->id);
    
            $invoice_data = [
                'external_id' => $external_id,
                'amount' => $tagihan->total_tagihan,
                'payer_email' => auth()->user()->email,
                'success_redirect_url' => "$baseurl/pembayaran-success-$tagihan_id",
                'failure_redirect_url' => "$baseurl/pembayaran-failed-$tagihan_id",
            ];
    
            $response = Http::withBasicAuth($xenditApiKey, '')
                ->post('https://api.xendit.co/v2/invoices', $invoice_data);
    
            if ($response->successful()) {
                $invoice = $response->json();
                $invoiceUrl = $invoice['invoice_url'];
    
                $tagihan->link_pembayaran = $invoiceUrl;
                $tagihan->save();

                return redirect()->away($invoiceUrl);
            } else {
                
                return redirect()->back()->with('error', 'Gagal memulai proses pembayaran.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pembayaran.');
        }
    }

    public function success($id)
    {
        $tagihan = Tagihan::with(['penyewaan'])
                        ->where('status', 'Approved by Administrasi')
                        ->findOrFail($id);

        $pembayaran = Pembayaran::create([
            'id' => Str::uuid(),
            'id_vendor' => $tagihan->id_vendor,
            'id_tagihan' => $tagihan->id,
            'jumlah' => $tagihan->total_tagihan,
            'tanggal_pembayaran' => now(),
            'metode_pembayaran' => 'Xendit',
        ]);

        $riwayat = RiwayatSuratJalan::create([
            'id' => Str::uuid(),
            'id_vendor' => $tagihan->id_vendor,
            'id_surat_jalan' => SuratJalan::where('id_penyewaan', $tagihan->penyewaan->id)->first()->id,
            'tanggal' => now(),
            'sudah_dicetak' => false,
        ]);

        $tagihan->status = 'Pembayaran';
        $tagihan->save();

        $suratJalan = SuratJalan::where('id_penyewaan', $tagihan->penyewaan->id)->first();
        $suratJalan->status = 'Pembayaran';
        $suratJalan->save();

        $penyewaan = Penyewaan::where('id', $tagihan->penyewaan->id)->first();
        $penyewaan->status = 'Pembayaran';
        $penyewaan->save();

        return redirect()->route('fasilitas.sewa-kendaraan.index')->with('success', 'Pembayaran berhasil dilakukan.');
    }

    public function failed($id)
    {
        $tagihan = Tagihan::with(['penyewaan'])
                        ->where('status', 'Approved by Administrasi')
                        ->findOrFail($id);

        $tagihan->status = 'Approved by Administrasi';
        $tagihan->save();

        return redirect()->route('fasilitas.sewa-kendaraan.index')->with('error', 'Pembayaran gagal dilakukan.');
    }
}
