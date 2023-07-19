<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['namespace' => 'App\Http\Controllers'], function() {
  /**
   * Home & Guest Routes
   */
  Route::get('/', [HomeController::class, 'index'])->name('home.index');
  Route::get('/about-us', [HomeController::class, 'about'])->name('about.index');
  Route::get('/orderFood', [HomeController::class, 'food'])->name('food.index');
  Route::get('/food-{id}', [ProductController::class, 'showDetails'])->name('food.details');

  Route::group(['middleware' => ['guest']], function() {
    /**
     * Registration Routes
     */
    Route::get('register', [AuthController::class, 'show'])->name('register.show');
    Route::post('register', [AuthController::class, 'register'])->name('register.perform');

    /**
     * Login Routes
     */
    Route::get('login', [AuthController::class,'display'])->name('login.show');
    Route::post('login', [AuthController::class, 'login'])->name('login.perform');
  });

  Route::group(['middleware' =>['auth']], function() {

    /**
    * Verification Routes
    */
    Route::get('verifyemail', [AuthController::class, 'verifyemail'])->name('verification.notice');
    Route::get('verify/{token}', [AuthController::class, 'verifyAccount'])->name('verification.verify');

    /**
     * Log Out Routes
     */
    Route::get('/logout', [AuthController::class, 'perform'])->name('logout');

    Route::group(['middleware' => ['is_verify_email']], function() {
        /**
         * User Routes
         */
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        /**
         * Admin Routes
         */
        //Food Category Links
        Route::get('/food-category', [CategoryController::class, 'categoryShow'])->name('admin.category');
        Route::post('/addCategory', [CategoryController::class, 'createCategory'])->name('category.create');
        Route::post('/deleteCategory/{id}', [CategoryController::class, 'deleteCategory'])->name('category.delete');
        Route::post('/editCategory/{id}', [CategoryController::class, 'editCategory'])->name('category.edit');

        //Food Menu(Products) Links
        Route::get('/food-menu', [ProductController::class, 'showProducts'])->name('admin.products');
        Route::post('/addMeal', [ProductController::class, 'addProducts'])->name('food.create');
        Route::post('/editMeal/{id}', [ProductController::class, 'editProducts'])->name('food.edit');
        Route::post('/deleteMeal/{id}', [ProductController::class, 'deleteProducts'])->name('food.delete');

        /**
         * User Routes
         */
        Route::post('/add-to-cart-{id}', [CartController::class, 'addToCart'])->name('cart.update');
        Route::get('/viewCart', [CartController::class, 'showCart'])->name('cart.view');
        Route::get('/remove-food-{id}', [CartController::class, 'removeItem'])->name('cart.remove');

        /**
         * Paystack Routes
         */
        Route::post('/pay', [PaymentController::class, 'redirectToGateway'])->name('pay.now');
        Route::get('/payment/callback', [PaymentController::class, 'handleGatewayCallback']);

    });

  });

});

