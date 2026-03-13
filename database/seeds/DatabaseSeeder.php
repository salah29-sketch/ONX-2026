<?php

use Illuminate\Database\Seeder;
use Database\Seeders\ServiceSeeder;
use Database\Seeders\ServiceHseeder;


class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            CompanySeeder::class,
            UsersTableSeeder::class,
            ServiceSeeder::class,
        ]);
    }
}
