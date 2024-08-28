<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\TandaTanganVendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VendorTandaTanganController extends Controller
{
    public function index()
    {
        $vendorTandaTangan = TandaTanganVendor::where('id_vendor', auth()->user()->vendor->id)
                            ->paginate(10);
        
        return view('vendor.tanda-tangan.index', compact('vendorTandaTangan'));
    }

    public function create()
    {
        return view('vendor.tanda-tangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ttd_name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        $image = $request->file('image');
    
        $safeName = preg_replace('/[^A-Za-z0-9\-]/', '_', $request->ttd_name);
        
        $uniqueSuffix = uniqid();
        $imageName = $safeName . '_' . $uniqueSuffix . '.' . $image->extension();
        $imagePath = 'public/tanda-tangan-vendor/' . $imageName;
    
        Storage::put($imagePath, file_get_contents($image->getRealPath()));
    
        TandaTanganVendor::create([
            'id_vendor' => auth()->user()->vendor->id,
            'ttd_name' => $request->ttd_name,
            'image_url' => Storage::url($imagePath),
        ]);
    
        return redirect()->route('vendor.tanda-tangan.index')->with('success', 'Tanda tangan berhasil ditambahkan.');
    }
    

    public function destroy($id)
    {
        $vendorTandaTangan = TandaTanganVendor::findOrFail($id);
    
        $imagePath = str_replace('/storage/', 'public/', $vendorTandaTangan->image_url);
    
        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }
    
        $vendorTandaTangan->delete();
    
        return redirect()->route('vendor.tanda-tangan.index')->with('success', 'Tanda tangan berhasil dihapus.');
    }
}