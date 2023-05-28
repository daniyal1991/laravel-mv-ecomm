<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class InsertAdminsData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_records = [
            [
                'id'=>1,
                'name'=>'Super Admin',
                'type'=>'superadmin',
                'vendor_id'=>0,
                'phone'=>'1234567890',
                'email'=>'superadmin@e.com',
                'password'=>Hash::make('12345'),
                'image'=>'',
                'status'=>1
            ]
        ];

        Admin::insert($admin_records);
    }
}
