<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brandmodel;
use App\Models\Brand;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class BrandmodelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $models = Brandmodel::select(
            'brandmodels.id',
            'brandmodels.name as name',
            'b.name as brandname',
            'brandmodels.description',
            'brandmodels.created_at',
            'brandmodels.updated_at'
        )
            ->join('brands as b', 'brandmodels.brand_id', '=', 'b.id');

        if ($request->ajax()) {
            return DataTables::of($models)
                ->addColumn("edit", function ($model){
                    return '<button class="btn btn-warning btn-sm btnEditar" id="'.$model->id.'"><i class="fas fa-pen"></i></button>';
                })
                ->addColumn("delete", function ($model){
                    return '<form action="'.route('admin.models.destroy', $model).'" method="POST" class="frmDelete">'.csrf_field().method_field('DELETE').'<button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></form>';
                })
                ->rawColumns(['edit','delete'])
                ->make(true);
        } else {
            return view('admin.models.index', compact('models'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::all()->pluck('name', 'id');
        return view('admin.models.create', compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Brandmodel::create($request->all());
            return response()->json(["message" => "Modelo registrado correctamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Error al registrar el modelo"], 500);
        }
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
        $model = Brandmodel::find($id);
        $brands = Brand::all()->pluck('name', 'id');
        return view('admin.models.edit', compact('model', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $model = Brandmodel::find($id);
            $model->update($request->all());
            return response()->json(["message" => "Modelo actualizado correctamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Error al actualizar el modelo"], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $model = Brandmodel::find($id);
            $model->delete();
            return response()->json(["message" => "Modelo eliminado correctamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Error al eliminar el modelo"], 500);
        }
    }
}
