<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultAppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['role' => 'Super admin'],
            ['role' => 'Admin'],
            ['role' => 'Docteur'],
            ['role' => 'Infirmier'],
            ['role' => 'Réceptionniste'],
            ['role' => 'Laborantin'],
            ['role' => 'Pharmacien'],
        ];
        DB::table('user_roles')->insert($roles);
    }
}
