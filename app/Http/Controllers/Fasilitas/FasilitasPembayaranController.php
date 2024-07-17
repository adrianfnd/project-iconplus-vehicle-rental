<?php

namespace App\Http\Controllers\Fasilitas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Models\SuratJalan;
use App\Models\RiwayatSuratJalan;
use App\Models\Penyewaan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class FasilitasPembayaranController extends Controller
{
    public function index()
    {
        $tagihan = Tagihan::with(['penyewaan'])
                        ->whereIn('status', [
                            'Approved by Administrasi'
                        ])
                        ->whereNotIn('status', ['Lunas'])
                        ->paginate(10);

        return view('fasilitas.pembayaran.index', compact('tagihan'));
    }

    public function show($id)
    {
        $tagihan = Tagihan::with(['penyewaan'])
                        ->whereIn('status', [
                            'Approved by Administrasi'
                        ])
                        ->whereNotIn('status', ['Lunas'])
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

        return redirect()->route('fasilitas.pembayaran.index')->with('success', 'Pengajuan pembayaran berhasil ditolak.');
    }
    
    public function approve($id)
    {
        $tagihan = Tagihan::with(['penyewaan'])
                        ->where('status', 'Approved by Administrasi')
                        ->findOrFail($id);

        $xenditApiKey = env('XENDIT_API_KEY');
        $external_id = 'TAGIHAN_' . $tagihan->id;
        $baseurl = env('APP_URL');
        $tagihan_id = Crypt::encrypt($tagihan->id);

        $invoice_data = [
            'external_id' => $external_id,
            'amount' => $tagihan->total_tagihan,
            'payer_email' => auth()->user()->email,
            'success_redirect_url' => "$baseurl/fasilitas/pembayaran-success/$tagihan_id",
            'failure_redirect_url' => "$baseurl/fasilitas/pembayaran-failed/$tagihan_id",
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
    }

    public function success($encrypted_id)
    {
        $id = Crypt::decrypt($encrypted_id);
        $tagihan = Tagihan::with(['penyewaan'])
                        ->where('status', 'Approved by Administrasi')
                        ->findOrFail($id);

        Pembayaran::create([
            'id' => Str::uuid(),
            'id_vendor' => $tagihan->id_vendor,
            'id_tagihan' => $tagihan->id,
            'jumlah' => $tagihan->total_tagihan,
            'tanggal_pembayaran' => now(),
            'metode_pembayaran' => 'Xendit',
        ]);

        RiwayatSuratJalan::create([
            'id' => Str::uuid(),
            'id_vendor' => $tagihan->id_vendor,
            'id_surat_jalan' => SuratJalan::where('id_penyewaan', $tagihan->penyewaan->id)->first()->id,
            'sudah_dicetak' => false,
        ]);

        $tagihan->status = 'Lunas';
        $tagihan->save();

        $suratJalan = SuratJalan::where('id_penyewaan', $tagihan->penyewaan->id)->first();
        $suratJalan->status = 'Lunas';
        $suratJalan->save();

        $penyewaan = Penyewaan::where('id', $tagihan->penyewaan->id)->first();
        $penyewaan->status = 'Lunas';
        $penyewaan->save();

        return redirect()->route('fasilitas.pembayaran.index')->with('success', 'Pembayaran berhasil dilakukan.');
    }

    public function failed($encrypted_id)
    {
        $id = Crypt::decrypt($encrypted_id);
        $tagihan = Tagihan::with(['penyewaan'])
                        ->where('status', 'Approved by Administrasi')
                        ->findOrFail($id);

        $tagihan->status = 'Approved by Administrasi';
        $tagihan->save();

        return redirect()->route('fasilitas.pembayaran.index')->with('error', 'Pembayaran gagal dilakukan.');
    }
}
