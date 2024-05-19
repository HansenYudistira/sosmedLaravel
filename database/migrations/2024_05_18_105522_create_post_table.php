<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('media_type')->nullable();
            $table->string('media_path')->nullable();
            $table->text('content')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        DB::table('posts')->insert([
            [
                'user_id' => '1',
                'media_type' => 'video',
                'media_path' => 'media/xk7JDQfWLlhzNDHlX3SY0GQ7KSelO3HNdObxATmb.mp4',
                'content' => 'konten video',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => '1',
                'media_type' => 'image',
                'media_path' => 'media/58ZDCef2r6duBVZJLTn6ZjD3f9UaBrA0P89RCSDS.jpg',
                'content' => 'konten gambar',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => '1',
                'media_type' => null,
                'media_path' => null,
                'content' => 'konten tanpa video atau gambar',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
