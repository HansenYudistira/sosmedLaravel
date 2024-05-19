<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('photo')->nullable();
            $table->string('address')->default("");
            $table->string('phone')->default("");
            $table->string('gender')->default("");
            $table->string('minat')->default("");
            $table->string('bio')->default("");
            $table->date("birth_date")->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert([
            [
                'name' => 'Hansen Yudistira',
                'email' => 'hansen@gmail.com',
                'password' => Hash::make('hansen'),
                'photo' => null,
                'address' => 'Jakarta Utara',
                'phone' => '081234567890',
                'gender' => 'Laki-Laki',
                'minat' => 'Programming',
                'bio' => 'I love Game',
                'birth_date' => '1997-06-24',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
