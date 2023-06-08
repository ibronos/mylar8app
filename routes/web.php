<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Role_C;
use App\Http\Controllers\User_C;
use App\Http\Controllers\Item_C;
use App\Http\Controllers\Supplier_C;
use App\Http\Controllers\Order_C;
use App\Http\Controllers\Report_C;
use App\Http\Controllers\Inventory_C;
use App\Http\Controllers\Style_C;
use App\Http\Controllers\Purchasing_C;

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

Route::get('/', function () {
    return view('auth/login');
});

Route::get('/admin', function () {
    return view('admin/index');
})->middleware('auth'); 


//ROLE
Route::resource('role', Role_C::class)->middleware('can:access-role');

//USER
Route::get( 'user/{id}/user_profile', [User_C::class, 'user_profile'] )->name('user.user_profile');
Route::get( 'user/{id}/admin_edit_pass', [User_C::class, 'admin_edit_pass'] )->name('user.admin_edit_pass');
Route::post( 'user/admin_update_pass/{id}', [User_C::class, 'admin_update_pass'] )->name('user.admin_update_pass');
Route::post( 'user/update_password/{id}', [User_C::class, 'update_password'] )->name('user.update_password');
Route::middleware(['can:access-user'])->group(function () {
	Route::get( 'user/search', [User_C::class, 'search'] )->name('user.search');
	Route::resource('user', User_C::class);
});

//MASTER
Route::middleware(['can:access-master'])->group(function () {
	Route::get( 'item/search', [Item_C::class, 'search'] )->name('item.search');
	Route::resource('item', Item_C::class);
	Route::get( 'supplier/search', [Supplier_C::class, 'search'] )->name('supplier.search');
	Route::resource('supplier', Supplier_C::class);
});

//PRODUCTION
Route::middleware(['can:access-production'])->group(function () {
	Route::get( 'order/{id}/edit_style', [Order_C::class, 'edit_style'] )->name('order.edit_style');
	Route::post( 'order/update_style/{id}', [Order_C::class, 'update_style'] )->name('order.update_style');
	Route::get( 'order/search', [Order_C::class, 'search'] )->name('order.search');
	Route::resource('order', Order_C::class);
	Route::get( 'style/search', [Style_C::class, 'search'] )->name('style.search');
	Route::resource('style', Style_C::class);
});

//REPORT
Route::middleware(['can:access-report'])->group(function () {
	Route::get( 'order/search', [Order_C::class, 'search'] )->name('order.search');
	Route::resource('order', Order_C::class)->only([
    	'index', 'show'
	]);
	Route::post( 'report/update_notes/{id}', [Report_C::class, 'update_notes'] )->name('report.update_notes');
	Route::post( 'report/update_process/{id}', [Report_C::class, 'update_process'] )->name('report.update_process');
	Route::resource('report', Report_C::class);
});

//INVENTORY
Route::middleware(['can:access-inventory'])->group(function () {
	Route::get( 'inventory/search', [Inventory_C::class, 'search'] )->name('inventory.search');
	Route::resource('inventory', Inventory_C::class);
});

//PURCHASING
Route::middleware(['can:access-inventory'])->group(function () {
	Route::get( 'purchasing/search', [Purchasing_C::class, 'search'] )->name('purchasing.search');
	Route::resource('purchasing', Purchasing_C::class);
});

Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');
