<?php

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->insert([
            'name' => Str::random(10),
            'post_code' => mt_rand(100, 999),
            'user_id' => mt_rand(100000, 999999),
            // driver_id store_id  location_id address check_out_time price transportation_price status
        ]);
    }
}
