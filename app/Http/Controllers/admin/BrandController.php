<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::all();
        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Brand::create($request->all());
        $logo = "";
        $request->validate([
            "name" => "unique:brands"
        ]);
        if ($request->logo != "") {
            $image = $request->file("logo")->store("public/brand_logo");
            $logo = Storage::url($image);
        }
        Brand::create([
            "name" => $request->name,
            "logo" => $logo,
            "description" => $request->description
        ]);
        return redirect()->route('admin.brands.index')->with('action', 'Marca registrada');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brand = Brand::find($id);
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $brand = Brand::find($id);
        // $brand->update($request->all());
        $logo = "";
        $request->validate([
            "name" => "unique:brands,name," . $id
        ]);
        if ($request->logo != "") {
            $image = $request->file("logo")->store("public/brand_logo");
            $logo = Storage::url($image);
            $brand->update([
                "name" => $request->name,
                "logo" => $logo,
                "description" => $request->description
            ]);
        } else {
            $brand->update([
                "name" => $request->name,
                "description" => $request->description
            ]);
        }
        return redirect()->route('admin.brands.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::find($id);
        $brand->delete();
        return redirect()->route('admin.brands.index')->with('action', 'Marca eliminada');
    }
}
