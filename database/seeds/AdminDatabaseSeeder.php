<?php

use Illuminate\Database\Seeder;
use App\Models\Admin;
class AdminDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' =>'Ahmed',
            'email'=> 'ahmed123@gmail.com',
            'password'=> bcrypt('ahmed123'),
        ]);
    }
}
