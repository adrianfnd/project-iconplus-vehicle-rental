<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;

class AdminPembayaranController extends Controller
{
    public function index()
    {
        $invoices = Pembayaran::all();
        return view('admin.pembayarans.index', compact('invoices'));
    }

    public function approve($id)
    {
        $invoice = Pembayaran::find($id);
        $invoice->status = 'approved';
        $invoice->save();

        return redirect()->route('admin.pembayarans.index')
            ->with('success', 'Pembayaran invoice berhasil disetujui.');
    }
}
