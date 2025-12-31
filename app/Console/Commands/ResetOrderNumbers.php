<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetOrderNumbers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:reset-numbers {--delete : حذف جميع الطلبات الحالية}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset order numbers to start from 1';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $deleteOrders = $this->option('delete');
        
        if ($deleteOrders) {
            if (!$this->confirm('هل أنت متأكد من حذف جميع الطلبات وإعادة تعيين الأرقام؟ هذا الإجراء لا يمكن التراجع عنه!')) {
                $this->info('تم الإلغاء.');
                return 0;
            }
            
            try {
                // Disable foreign key checks temporarily
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                
                // Delete all orderdetailes first
                DB::table('orderdetailes')->delete();
                
                // Delete all orders
                DB::table('orders')->delete();
                
                // Re-enable foreign key checks
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                
                $this->info('تم حذف جميع الطلبات بنجاح.');
            } catch (\Exception $e) {
                // Make sure to re-enable foreign key checks even if there's an error
                try {
                    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                } catch (\Exception $e2) {
                    // Ignore
                }
                $this->error('حدث خطأ أثناء حذف الطلبات: ' . $e->getMessage());
                return 1;
            }
        } else {
            // Check if there are existing orders
            $orderCount = DB::table('orders')->count();
            if ($orderCount > 0) {
                $this->warn("يوجد {$orderCount} طلب في قاعدة البيانات.");
                $this->warn('لإعادة تعيين الأرقام إلى 1، يجب حذف جميع الطلبات أولاً.');
                if (!$this->confirm('هل تريد حذف جميع الطلبات الآن؟')) {
                    $this->info('تم الإلغاء. استخدم --delete لحذف الطلبات.');
                    return 0;
                }
                // Disable foreign key checks temporarily
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                
                // Delete all orderdetailes first
                DB::table('orderdetailes')->delete();
                
                // Delete all orders
                DB::table('orders')->delete();
                
                // Re-enable foreign key checks
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                
                $this->info('تم حذف جميع الطلبات بنجاح.');
            }
        }

        try {
            // Get the table name with prefix if exists
            $tableName = DB::getTablePrefix() . 'orders';
            
            // Reset AUTO_INCREMENT to 1
            // For MySQL/MariaDB
            DB::statement("ALTER TABLE `{$tableName}` AUTO_INCREMENT = 1");
            
            $this->info('تم إعادة تعيين أرقام الطلبات بنجاح! سيبدأ رقم الطلب التالي من 1.');
            
            return 0;
        } catch (\Exception $e) {
            $this->error('حدث خطأ: ' . $e->getMessage());
            return 1;
        }
    }
}

