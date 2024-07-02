<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;

class VendorPembayaranController extends Controller
{
    public function index()
    {
        $invoices = Pembayaran::all();
        return view('vendor.pembayarans.index', compact('invoices'));
    }
}
