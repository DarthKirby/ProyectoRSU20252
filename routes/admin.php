<?php
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\BrandController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AdminController::class, 'index']);
Route::resource('brands', BrandController::class)->names('admin.brands');