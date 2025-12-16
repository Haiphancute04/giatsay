<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index() {
        $banners = Banner::orderBy('order', 'asc')->latest()->paginate(10);
        return view('admin.banners.index', compact('banners'));
    }

    public function create() {
        return view('admin.banners.create');
    }

    public function store(Request $request) {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10248',
            'title_vi' => 'nullable|string|max:255', 
            'title_en' => 'nullable|string|max:255', 
            'order' => 'integer'
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            $file = $request->file('image'); 
            $filename = $file->getClientOriginalName(); 
            $data['image'] = $file->storeAs('banners', $filename, 'public');
        }
        $data['is_active'] = $request->has('is_active'); 

        Banner::create($data);
        return redirect()->route('admin.banners.index')->with('success', __('Banner added successfully!'));
    }

    public function edit(Banner $banner) {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner) {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10248',
            'title_vi' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'order' => 'integer'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($banner->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($banner->image)) {
                 \Illuminate\Support\Facades\Storage::disk('public')->delete($banner->image);
            }
            $file = $request->file('image'); 
            $filename = $file->getClientOriginalName(); 
            $data['image'] = $file->storeAs('banners', $filename, 'public');
        }
        
        $data['is_active'] = $request->has('is_active');

        $banner->update($data);
        return redirect()->route('admin.banners.index')->with('success', __('Cập nhật banner thành công!'));
    }

    public function destroy(Banner $banner) {
        if ($banner->image) Storage::disk('public')->delete($banner->image);
        $banner->delete();
        return back()->with('success', __('Banner deleted!'));
    }
}