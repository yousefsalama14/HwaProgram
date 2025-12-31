<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\weldingwireController;
use App\Http\Controllers\Admin\dashboardController;
use App\Http\Controllers\Admin\rollingController;
use App\Http\Controllers\Admin\cuttingController;
use App\Http\Controllers\Admin\foldcontroller;
use App\Http\Controllers\Admin\materialsController;
use App\Http\Controllers\Admin\perforationController;


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
Route::controller(AuthController::class)->group(function () {
    Route::get('/Admin/login','login')->name('adminLogin');
    Route::Post('/Admin/login','Submitlogin')->name('Admin.login');
    Route::get('/Admin/logout','logout')->name('Admin.logout');
});
Route::middleware('AdminAuth')->group(function(){
    Route::resource('weldingwires', weldingwireController::class);
    Route::resource('materials', materialsController::class);
    Route::get('/upload-file', [materialsController::class, 'createForm']);
    Route::post('/upload-file', [materialsController::class, 'fileUpload'])->name('fileUpload');
    Route::controller(dashboardController::class)->group(function () {
        Route::get('/Admin/dashboard','index')->name('Admin.dashboard');
    });
      Route::resource('rollings', rollingController::class);
      Route::resource('cuttings', cuttingController::class);
      Route::resource('folds', foldcontroller::class);
      Route::controller(perforationController::class)->group(function () {
        Route::get('/perforation', 'index')->name('perforation.index');
        Route::post('/getThickness','getThickness');
        Route::post('/getDiameter','getDiameter');
        Route::post('/getPrice','getPrice');
        Route::post('/updatePrice','updatePrice')->name('perforation.updatePrice');
    });

    // Reset order numbers route (only for cost.accounting admin)
    Route::post('/Admin/reset-order-numbers', function () {
        // Check if admin is cost.accounting (case-insensitive)
        $adminName = strtolower(trim(\Illuminate\Support\Facades\Auth::guard('Admin')->user()->name ?? ''));
        $allowedNames = ['cost.accounting', 'cost accounting'];
        
        if (!in_array($adminName, $allowedNames) && !str_contains($adminName, 'cost.accounting')) {
            return response()->json([
                'success' => false,
                'message' => 'غير مصرح لك بهذا الإجراء'
            ], 403);
        }

        try {
            // Check if there are existing orders
            $orderCount = \Illuminate\Support\Facades\DB::table('orders')->count();
            
            if ($orderCount > 0) {
                // Disable foreign key checks temporarily
                \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                
                // Delete all orderdetailes first
                \Illuminate\Support\Facades\DB::table('orderdetailes')->delete();
                
                // Delete all orders
                \Illuminate\Support\Facades\DB::table('orders')->delete();
                
                // Re-enable foreign key checks
                \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            }
            
            // Reset AUTO_INCREMENT to 1
            $tableName = \Illuminate\Support\Facades\DB::getTablePrefix() . 'orders';
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE `{$tableName}` AUTO_INCREMENT = 1");
            
            return response()->json([
                'success' => true,
                'message' => 'تم إعادة تعيين أرقام الطلبات بنجاح! سيبدأ رقم الطلب التالي من 1.',
                'deleted_orders' => $orderCount
            ]);
        } catch (\Exception $e) {
            // Make sure to re-enable foreign key checks even if there's an error
            try {
                \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            } catch (\Exception $e2) {
                // Ignore
            }
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    })->name('admin.reset-order-numbers');
});

