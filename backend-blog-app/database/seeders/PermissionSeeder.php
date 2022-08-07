<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'Dashboard' => [
                'Order Amount'
            ],
            'Order' => [

            ],
            'Roles' => [
                'create role',
                'view role',
                'update role',
                'delete role'
            ],
            'Assign Roles' => [
                'create assign-role',
            ],
            'Stores' => [
                'create store',
                'update store',
                'delete store'
            ],
            'Categories' => [
                'create category',
                'update category',
                'delete category'
            ],
            'Tags' => [
                'create tag',
                'update tag',
                'delete tag'
            ],
            'Products' => [
                'create product',
                'update product',
                'delete product'
            ],
            'Packages' => [
                'create package',
                'update package',
                'delete package'
            ],
            'Offers' => [
                'create offer',
                'update offer',
                'delete offer'
            ],
            'Money Receivers' => [
                'create money-receivers',
                'update money-receivers',
                'delete money-receivers'
            ],
            'Tickets' => [
                'view ticket',
                'open ticket'
            ],
            'Coupons' => [
                'create coupon',
                'update coupon',
                'delete coupon'
            ],
            'Configurations' => [
                'create configuration',
            ],
            'Sliders' => [
                'create slider',
                'update slider',
                'delete slider'
            ],
            'Payment Methods' => [
                'create payment method',
                'update payment method',
                'delete payment method'
            ],
            //INVENTORY END
            'Shippers' => [
                'create shipper',
                'update shipper',
                'delete shipper'
            ],
            'Order Managements' => [
                'list order-management'
            ],
            'Stock Managements' => [
                'product stock management',
                'label stock management',
            ],
            'Postage-Managements' => [
                'Manage-Postage-Management',
            ],
            'Product Activity Logs' => [
                'list product activity log'
            ],
            'Label Activity Logs' => [
                'list label activity log'
            ],
            'postage Activity Logs' => [],

            //INVENTORY END

            //SHIPPER START
            'Shipper-Order'=>[],
            'Shipper-Products'=>[],
            'Shipper-Products-Label'=>[],
            'Shipper-Postage'=>[],
            'Shipper-Product-Status'=>[],
            'Shipper-Activity-Log'=>[],
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        foreach ($permissions as $parent => $child) {
            $parent_data = \App\Models\Permission::create([
                'name' => $parent,
                'guard_name' => 'web'
            ]);

            foreach ($child as $c) {
                \App\Models\Permission::create([
                    'name' => $c,
                    'guard_name' => 'web',
                    'parent_id' => $parent_data->id
                ]);
            }
        }
    }
}
