<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopifyController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ShopifyController::class, 'choose_product']);

Route::post('/save-metaobject', [ShopifyController::class, 'updateMetaobject'])->name('save-metaobject');

Route::get('/metaobjects', [ShopifyController::class, 'getMetaobjects']);

Route::get('/price', [ShopifyController::class, 'updatePriceToZero']);
