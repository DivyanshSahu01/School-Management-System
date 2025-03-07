<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Fee;
use App\Models\Session;
use App\Models\User;
use App\Models\Student;

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

        Fee::truncate();
        Fee::upsert
        ([
            ["standard"=>1, "medium"=>1, "exam_fee"=>1000, "admission_fee"=>1200, "monthly_fee"=>500],
            ["standard"=>1, "medium"=>2, "exam_fee"=>1000, "admission_fee"=>1200, "monthly_fee"=>500],
            ["standard"=>2, "medium"=>1, "exam_fee"=>1000, "admission_fee"=>1200, "monthly_fee"=>500],
            ["standard"=>2, "medium"=>2, "exam_fee"=>1000, "admission_fee"=>1200, "monthly_fee"=>500],
            ["standard"=>3, "medium"=>1, "exam_fee"=>1000, "admission_fee"=>1200, "monthly_fee"=>500],
            ["standard"=>3, "medium"=>2, "exam_fee"=>1000, "admission_fee"=>1200, "monthly_fee"=>500],
            ["standard"=>4, "medium"=>1, "exam_fee"=>1000, "admission_fee"=>1200, "monthly_fee"=>500],
            ["standard"=>4, "medium"=>2, "exam_fee"=>1000, "admission_fee"=>1200, "monthly_fee"=>500],
            ["standard"=>5, "medium"=>1, "exam_fee"=>1000, "admission_fee"=>1200, "monthly_fee"=>500],
            ["standard"=>5, "medium"=>2, "exam_fee"=>1000, "admission_fee"=>1200, "monthly_fee"=>500],
            ["standard"=>6, "medium"=>1, "exam_fee"=>1000, "admission_fee"=>1200, "monthly_fee"=>500],
            ["standard"=>6, "medium"=>2, "exam_fee"=>1000, "admission_fee"=>1200, "monthly_fee"=>500],
            ["standard"=>7, "medium"=>1, "exam_fee"=>1000, "admission_fee"=>1200, "monthly_fee"=>500],
            ["standard"=>7, "medium"=>2, "exam_fee"=>1000, "admission_fee"=>1200, "monthly_fee"=>500],
            ["standard"=>8, "medium"=>1, "exam_fee"=>1000, "admission_fee"=>1200, "monthly_fee"=>500],
            ["standard"=>8, "medium"=>2, "exam_fee"=>1000, "admission_fee"=>1200, "monthly_fee"=>500],
            ["standard"=>9, "medium"=>1, "exam_fee"=>1000, "admission_fee"=>1200, "monthly_fee"=>500],
            ["standard"=>9, "medium"=>2, "exam_fee"=>1000, "admission_fee"=>1200, "monthly_fee"=>500],
            ["standard"=>10, "medium"=>1, "exam_fee"=>1000, "admission_fee"=>1200, "monthly_fee"=>500],
            ["standard"=>10, "medium"=>2, "exam_fee"=>1000, "admission_fee"=>1200, "monthly_fee"=>500],
            ["standard"=>11, "medium"=>1, "exam_fee"=>1000, "admission_fee"=>1200, "monthly_fee"=>500],
            ["standard"=>11, "medium"=>2, "exam_fee"=>1000, "admission_fee"=>1200, "monthly_fee"=>500],
            ["standard"=>12, "medium"=>1, "exam_fee"=>1000, "admission_fee"=>1200, "monthly_fee"=>500],
            ["standard"=>12, "medium"=>2, "exam_fee"=>1000, "admission_fee"=>1200, "monthly_fee"=>500],
        ],
        [],
        []);

        Session::truncate();
        Session::upsert(["name"=>"2024-25", "is_active"=>1], [], []);

        User::truncate();
        User::upsert([['userid'=>'admin123', 'password'=>Hash::make('12345'), 'role'=>'admin'], ['userid'=>'user123', 'password'=>Hash::make('12345'), 'role'=>'other']], [], []);

        Student::truncate();
        Student::factory()->count(20)->create();
    }
}
