<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BrokerController;
use App\Http\Controllers\BrokerPermissionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPermissionController;
use Illuminate\Support\Facades\Route;

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


// //////////////////////Language Route //////////////////////////////
// Route::get('lang/{lang}', [LanguageController::class, 'switchLang'])->name('switch.language');


Route::prefix('admin')->middleware('guest:admin')->group(function () {
    Route::get('login',[AuthController::class, 'showLogin'])->name('auth.login-show');
    Route::post('login',[AuthController::class, 'login'])->name('auth.login');

});
// Route::get('admin', function () {
//     return view('cms.categories.create');
// });
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::resource('admins', AdminController::class);
    Route::resource('brokers', BrokerController::class);
    Route::resource('users',UserController::class);
    Route::resource('roles',RoleController::class);
    Route::resource('permissions',PermissionController::class);
    ///////// Broker Direct  Permissions ///////////////////
    Route::get('brokers/{id}/permissions', [BrokerPermissionController::class,'edit'])->name('broker-permissions.edit');
    Route::put('brokers/{id}/permissions', [BrokerPermissionController::class,'update'])->name('broker-permissions.update');
    /////  /// //   ****    User Dirct Permissions
    Route::get('users/{id}/permissions', [UserPermissionController::class,'edit'])->name('user-permissions.edit');
    Route::put('users/{id}/permissions', [UserPermissionController::class,'update'])->name('user-permissions.update');
    Route::put('roles/{role}/permission', [RolePermissionController::class,'update'])->name('role-permission.update');
});
Route::prefix('admin')->middleware('auth:admin')->name('admin.')->group(function () {
    Route::view('/','cms.parent');
    Route::resource('categories', CategoryController::class);
    Route::resource('subcategories',SubcategoryController::class);
    Route::resource('products',ProductController::class);
    Route::resource('cities', CityController::class);

    Route::view('notifications', 'cms.notifications.index')->name('products-notifications');
    Route::delete('notifications/{id}', [NotificationController::class,'destroy'])->name('products-notifications.destroy');
    Route::get('notifications/{id}', [NotificationController::class,'markAsRead'])->name('products-notifications.read');

    Route::get('getSubcategory/{id}',[ProductController::class,'getSubcategory'])->name('getSubcategory');

    //////////// USER Profile//////////////
    Route::get('logout',[AuthController::class, 'logout'])->name('auth.logout');
    Route::get('edit-profile',[AuthController::class, 'editPassword'])->name('auth.edit-profile');
    Route::put('update-password',[AuthController::class, 'updatePassword'])->name('auth.update-profile');

});
Route::fallback(function () {
    //


});

