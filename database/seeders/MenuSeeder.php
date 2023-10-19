<?php

namespace Database\Seeders;

use App\Models\menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $row=[
            [
                'menu' => 'Master',
                'active' => '1',
            ],
            [
                'menu' => 'Purchase',
                'active' => '1',
            ],
            [
                'menu' => 'Stocks',
                'active' => '1',
            ],
           
            ];
                DB::table('menus')->insert($row);
      
    }
}
