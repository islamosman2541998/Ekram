<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\ThemesSeeder;
use Database\Seeders\SettingSeeder;
use Database\Seeders\ServicesSeeder;
use Database\Seeders\ContactUsSeeding;
use Database\Seeders\HomeSettingPageSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(SettingSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(AdminSeeder::class);
        
        $this->call(CmsSeeder::class);
        
        $this->call(CharitySeeder::class);

        $this->call(ReferSeeder::class);

        $this->call(GiftsSeeder::class);


    }
}
