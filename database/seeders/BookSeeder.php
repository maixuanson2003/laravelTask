<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('books')->insert([
            [
                'title' => 'Laravel 101',
                'author' => 'John Doe',
                'create_year' => '2020',
                'amount' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'PHP for Beginners',
                'author' => 'Jane Smith',
                'create_year' => '2019',
                'amount' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'title' => 'PHP for Besadginners',
                'author' => 'Jane Smidasdth',
                'create_year' => '2011',
                'amount' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
