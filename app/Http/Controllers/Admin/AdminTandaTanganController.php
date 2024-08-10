<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TandaTangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminTandaTanganController extends Controller
{
    public function index()
    {
        $tandaTangan = TandaTangan::paginate(10);
        
        return view('admin.tanda-tangan.index', compact('tandaTangan'));
    }

    public function create()
    {
        return view('admin.tanda-tangan.create');
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
        $imagePath = 'public/tanda-tangan/' . $imageName;
    
        Storage::put($imagePath, file_get_contents($image->getRealPath()));
    
        TandaTangan::create([
            'ttd_name' => $request->ttd_name,
            'image_url' => Storage::url($imagePath),
        ]);
    
        return redirect()->route('admin.tanda-tangan.index')->with('success', 'Tanda tangan berhasil ditambahkan.');
    }
    

    public function destroy($id)
    {
        $tandaTangan = TandaTangan::findOrFail($id);
    
        $imagePath = str_replace('/storage/', 'public/', $tandaTangan->image_url);
    
        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }
    
        $tandaTangan->delete();
    
        return redirect()->route('admin.tanda-tangan.index')->with('success', 'Tanda tangan berhasil dihapus.');
    }
}