<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
        $books = [
            [
                'title' => 'Laravel 101',
                'author' => 'John Doe',
                'create_year' => '2020',
                'amount' => 3,
            ],
            [
                'title' => 'PHP for Beginners',
                'author' => 'Jane Smith',
                'create_year' => '2019',
                'amount' => 3,
            ],
            [
                'title' => 'Mastering PHP',
                'author' => 'David Brown',
                'create_year' => '2018',
                'amount' => 5,
            ],
            [
                'title' => 'Advanced Laravel',
                'author' => 'Michael Johnson',
                'create_year' => '2021',
                'amount' => 2,
            ],
            [
                'title' => 'Database Design',
                'author' => 'Emily White',
                'create_year' => '2017',
                'amount' => 4,
            ],
            [
                'title' => 'Web Development with Laravel',
                'author' => 'Chris Evans',
                'create_year' => '2022',
                'amount' => 3,
            ],
            [
                'title' => 'Modern PHP',
                'author' => 'Sarah Green',
                'create_year' => '2016',
                'amount' => 2,
            ],
            [
                'title' => 'Fullstack Development',
                'author' => 'Robert Downey',
                'create_year' => '2020',
                'amount' => 6,
            ],
            [
                'title' => 'Backend Essentials',
                'author' => 'Natalie Portman',
                'create_year' => '2015',
                'amount' => 4,
            ],
            [
                'title' => 'Frontend with Vue.js',
                'author' => 'Tom Hardy',
                'create_year' => '2019',
                'amount' => 5,
            ],
            [
                'title' => 'Testing PHP Applications',
                'author' => 'Emma Watson',
                'create_year' => '2018',
                'amount' => 3,
            ],
            [
                'title' => 'Microservices in PHP',
                'author' => 'Chris Hemsworth',
                'create_year' => '2021',
                'amount' => 2,
            ],
            [
                'title' => 'Laravel Security',
                'author' => 'Mark Ruffalo',
                'create_year' => '2017',
                'amount' => 3,
            ],
            [
                'title' => 'High Performance PHP',
                'author' => 'Scarlett Johansson',
                'create_year' => '2016',
                'amount' => 4,
            ],
            [
                'title' => 'Object-Oriented PHP',
                'author' => 'Benedict Cumberbatch',
                'create_year' => '2015',
                'amount' => 3,
            ],
            [
                'title' => 'REST API with Laravel',
                'author' => 'Jeremy Renner',
                'create_year' => '2022',
                'amount' => 5,
            ],
            [
                'title' => 'Docker for PHP Developers',
                'author' => 'Chris Pratt',
                'create_year' => '2020',
                'amount' => 2,
            ],
            [
                'title' => 'PHP Performance Optimization',
                'author' => 'Paul Rudd',
                'create_year' => '2019',
                'amount' => 3,
            ],
            [
                'title' => 'Scalable PHP Architecture',
                'author' => 'Brie Larson',
                'create_year' => '2021',
                'amount' => 4,
            ],
            [
                'title' => 'The Art of PHP Debugging',
                'author' => 'Tom Holland',
                'create_year' => '2018',
                'amount' => 3,
            ],
        ];

        foreach ($books as &$book) {
            $book['created_at'] = Carbon::now();
            $book['updated_at'] = Carbon::now();
        }

        DB::table('books')->insert($books);
    }
}
