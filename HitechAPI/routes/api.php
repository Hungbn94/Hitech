<?php

Use App\Http\Controllers\ProductController;
Use App\Http\Controllers\CustomerController;
Use App\Http\Controllers\PropertyController;
Use App\Http\Controllers\UserController;
Use App\Http\Controllers\APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', [APIController::class, 'login']);

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/GetUserByID/{UserID}', [UserController::class, 'GetUserByID']);
    Route::get('users/GetUserByUserName/{UserName}', [UserController::class, 'GetUserByUserName']);
    //Product
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{ProductID}', [ProductController::class, 'GetProductByID']);
    Route::get('products/GetProductByCode/{ProductCode}', [ProductController::class, 'GetProductByCode']);
    Route::get('products/GetProductByCustomerId/{CustomerId}', [ProductController::class, 'GetProductByCustomerId']);
    Route::get('products/GetProductByName/{ProductName}', [ProductController::class, 'GetProductByName']);
    Route::get('products/GetProductByContractNumber/{ContractNumber}', [ProductController::class, 'GetProductByContractNumber']);
    Route::get('products/GetProductsByPropertiesName/{PropertiesName}', [ProductController::class, 'GetProductsByPropertiesName']);
    Route::post('products', [ProductController::class, 'store']);
    Route::put('products/{ProductID}', [ProductController::class, 'update']);
    Route::delete('products/{ProductID}', [ProductController::class, 'delete']);
    //Customer
    Route::get('customers', [CustomerController::class, 'index']);
    Route::get('customers/{CustomerID}', [CustomerController::class, 'GetCustomerByID']);
    Route::get('customers/GetCustomerByCode/{CustomerCode}', [CustomerController::class, 'GetCustomerByCode']);
    Route::get('customers/GetCustomerByCompanyName/{CompanyName}', [CustomerController::class, 'GetCustomerByCompanyName']);
    Route::get('customers/GetCustomerByContactName/{ContactName}', [CustomerController::class, 'GetCustomerByContactName']);
    Route::post('customers', [CustomerController::class, 'store']);
    Route::put('customers/{CustomerID}', [CustomerController::class, 'update']);
    Route::delete('customers/{CustomerID}', [CustomerController::class, 'delete']);
    //Property
    Route::get('properties', [PropertyController::class, 'index']);
    Route::get('properties/{PropertiesID}', [PropertyController::class, 'GetPropertyByID']);
    Route::get('properties/GetPropertyByProductID/{ProductID}', [PropertyController::class, 'GetPropertyByProductID']);
    Route::post('properties', [PropertyController::class, 'store']);
    Route::put('properties/{PropertiesID}', [PropertyController::class, 'update']);
    Route::delete('properties/{PropertiesID}', [PropertyController::class, 'delete']);
});

Route::get('products/GetProductByCustomerCode/{CustomerCode}', [ProductController::class, 'GetProductByCustomerCode']);





