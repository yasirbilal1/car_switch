<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $data = [
            ['name' => 'email_to'],
            ['name' => 'email_cc'],
            ['name' => 'email_bcc'],
            ['name' => 'email_sent'],
        ];
        \App\Models\EmailTypes::insert($data);
    }
}
