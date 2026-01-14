<?php

use App\Http\Controllers\Dashboard\AuthDashboardController;
use App\Http\Controllers\Dashboard\DashboardCategoryController;
use App\Http\Controllers\Dashboard\DashboardcomplaintController;
use App\Http\Controllers\Dashboard\DashboardEmployeeController;
use App\Http\Controllers\Dashboard\DashboardFabricController;
use App\Http\Controllers\Dashboard\DashboardinvoicesController;
use App\Http\Controllers\Dashboard\DashboardOrderController;
use App\Http\Controllers\Dashboard\DashboardPhotoController;
use App\Http\Controllers\Dashboard\DashboardProductController;
use App\Http\Controllers\Dashboard\DashboardUserController;
use App\Http\Controllers\Dashboard\DashboardWoodController;
use App\Http\Controllers\Dashboard\MapController;
use Illuminate\Support\Facades\Route;

// صفحة تسجيل الدخول
Route::get('/', [AuthDashboardController::class, 'showLogin'])->name('login');
Route::get('/auth/login', [AuthDashboardController::class, 'showLogin'])->name('login');
Route::post('/auth/login', [AuthDashboardController::class, 'login']);
// عرض صفحة الفورغيت باسورد
Route::get('/auth/forgot-password', function () {
    return view('auth.forgot-password');
})->name('auth.forgot-password');

// معالجة نموذج الفورغيت باسورد
Route::post('/auth/forgot-password', [AuthDashboardController::class, 'forgotPasswordWeb'])
    ->name('auth.forgot-password.submit');

// صفحة إدخال الكود
Route::get('/auth/check-code', function () {
    return view('auth.check-code');
})->name('auth.check-code');

// معالجة الكود
Route::post('/auth/check-code', [AuthDashboardController::class, 'checkCodeWeb'])->name('auth.check-code.submit');

// صفحة إعادة تعيين كلمة المرور
Route::get('/auth/reset-password', function () {
    return view('auth.reset-password');
})->name('auth.reset-password');

// معالجة إعادة تعيين كلمة المرور
Route::post('/auth/reset-password', [AuthDashboardController::class, 'resetPasswordWeb'])
    ->name('auth.reset-password.submit');



// الصفحات المحمية (تتطلب تسجيل دخول)
Route::middleware(['auth:employee'])->group(function () {

    // تسجيل الخروج
    Route::post('/logout', [AuthDashboardController::class, 'logout'])->name('logout');


    // مجموعة صفحات الإدارة
    Route::prefix('admin')->group(function () {

        // إدارة الموظفين (للمدير أو مدير الموظفين فقط)
        Route::middleware(['role:Super Admin,Admin'])->group(function () {


            Route::get('/admin/profile', function () {
                return view('admin.employees.profile');
            })->name('profile');

            Route::resource('employees', DashboardEmployeeController::class);

            Route::get('employees/{employee}/delete', [DashboardEmployeeController::class, 'delete'])->name('employees.delete');

            Route::resource('users', DashboardUserController::class)->only(['index', 'destroy']);
            
            Route::get('users/{user}/orders', [DashboardUserController::class, 'orders'])->name('users.orders');

        });

        // إدارة المنتجات والفئات (لمدير المنتجات فقط)
        Route::middleware(['role:Data Entry,Admin'])->group(function () {

            Route::resource('products', DashboardProductController::class);

            Route::get('/photos/{photo}', [DashboardPhotoController::class, 'destroyPhoto'])->name('photos.destroy');

            Route::get('products/{product}/delete', [DashboardProductController::class, 'delete'])->name('products.delete');

            Route::resource('categories', DashboardCategoryController::class);

            Route::get('categories/{category}/delete', [DashboardCategoryController::class, 'delete'])->name('categories.delete');

            Route::resource('woods', DashboardWoodController::class);

            Route::get('woods/{wood}/delete', [DashboardWoodController::class, 'delete'])->name('woods.delete');

            Route::resource('fabrics', DashboardFabricController::class);

            Route::get('fabrics/{fabric}/delete', [DashboardFabricController::class, 'delete'])->name('fabrics.delete');
        });

        // إدارة الطلبات (لمدير الطلبات فقط)
        Route::middleware(['role:Order Validater , Admin'])->group(function () {

            Route::resource('orders', DashboardOrderController::class);

            Route::patch('orders/{order}/status', [DashboardOrderController::class, 'updateStatus'])->name('orders.update.status');

        });


        // إدارة الفواتير (توصيل الطلبات)
        Route::middleware(['role:Shipping Representative,Admin'])->group(function () {

            Route::resource('invoices', DashboardinvoicesController::class)->except(['show', 'create', 'store']);

            Route::get('invoices/{invoice}/delete', [DashboardinvoicesController::class, 'delete'])->name('invoices.delete');
        });

        Route::middleware(['role:Support Team,Admin'])->group(function () {

            Route::resource('complaints', DashboardcomplaintController::class)->except(['create', 'store']);

            Route::get('complaints/{complaint}/delete', [DashboardcomplaintController::class, 'delete'])->name('complaints.delete');

        });

        Route::get('/map', [MapController::class, 'showMap']);
        Route::get('/map/order/{id}', [MapController::class, 'showOrderMap'])->name('map.order');
        Route::post('/map/show', [MapController::class, 'showLocation']); // عرض الخريطة والعنوان


    });

});
