<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Testimoni extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('testimonials')->insert([
            [
                'name' => 'John Doe',
                'content' => 'This is a great service!',
                'phone' => '1234567890',
                'email' => 'johndoe@example.com',
                'active' => true,
            ],
            [
                'name' => 'Jane Smith',
                'content' => 'I highly recommend this.',
                'phone' => '0987654321',
                'email' => 'janesmith@example.com',
                'active' => true,
            ],
            [
                'name' => 'Alice Johnson',
                'content' => 'Fantastic experience!',
                'phone' => '1122334455',
                'email' => 'alicejohnson@example.com',
                'active' => false,
            ],
            [
                'name' => 'Bob Brown',
                'content' => 'Very satisfied with the service.',
                'phone' => '2233445566',
                'email' => 'bobbrown@example.com',
                'active' => true,
            ],
            [
                'name' => 'Charlie Green',
                'content' => 'Could be better.',
                'phone' => '3344556677',
                'email' => 'charliegreen@example.com',
                'active' => false,
            ],
            [
                'name' => 'David White',
                'content' => 'Excellent customer support!',
                'phone' => '4455667788',
                'email' => 'davidwhite@example.com',
                'active' => true,
            ],
            [
                'name' => 'Eve Black',
                'content' => 'Not what I expected.',
                'phone' => '5566778899',
                'email' => 'eveblack@example.com',
                'active' => false,
            ],
            [
                'name' => 'Frank Blue',
                'content' => 'Would use this service again.',
                'phone' => '6677889900',
                'email' => 'frankblue@example.com',
                'active' => true,
            ],
            [
                'name' => 'Grace Yellow',
                'content' => 'Friendly staff and good service.',
                'phone' => '7788990011',
                'email' => 'graceyellow@example.com',
                'active' => true,
            ],
            [
                'name' => 'Hannah Purple',
                'content' => 'Quick response times.',
                'phone' => '8899001122',
                'email' => 'hannahpurple@example.com',
                'active' => true,
            ],
        ]);
    }
}
