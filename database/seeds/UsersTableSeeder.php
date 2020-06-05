<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
// use Hash;
use App\Role;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $arr = Role::orderBy('id','asc')->pluck('id')->toArray();

      $user= DB::table('users')->insert([
          'fullnames' =>'receptionist',
          'username' => 'receptionist',
          'email' => 'receptionist@receptionist.com',
          'phonenumber' => '0712169695',
          'password' => Hash::make('secret'),
          'role_id' => !empty(Role::where("name","receptionist")->first()->id)  ? Role::where("name","receptionist")->first()->id : null,
      ]);
      DB::table('users')->insert([
          'fullnames' =>'admin',
          'username' => 'admin',
          'email' => 'admin@admin.com',
          'phonenumber' => '0712169696',
          'password' => Hash::make('secret'),
          'role_id' => !empty(Role::where("name","admin")->first()->id)  ? Role::where("name","admin")->first()->id : null,
      ]);
      DB::table('users')->insert([
          'fullnames' =>'optician',
          'username' => 'optician',
          'email' => 'optician@optician.com',
          'phonenumber' => '0712169696',
          'password' => Hash::make('secret'),
          'role_id' => !empty(Role::where("name","optician")->first()->id)  ? Role::where("name","optician")->first()->id : null,
      ]);
      DB::table('users')->insert([
          'fullnames' =>'dentist',
          'username' => 'dentist',
          'email' => 'dentist@dentist.com',
          'phonenumber' => '0712169696',
          'password' => Hash::make('secret'),
          'role_id' => !empty(Role::where("name","dentist")->first()->id)  ? Role::where("name","dentist")->first()->id : null,
      ]);

      $faker = Faker::create();
        foreach (range(1,10) as $index) {
          DB::table('users')->insert([
              'fullnames' => $faker->firstName($gender = 'male'),
              'username' => $faker->lastName,
              'email' => $faker->unique()->safeEmail,
              'phonenumber' => $faker->phoneNumber,
              'password' => Hash::make('secret'),
              'role_id' => !empty($arr[array_rand($arr)])  ? $arr[array_rand($arr)] : null,
          ]);
        }
    }
}
