<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('is_admin')->default(0)->after('password');
        });
        User::insert([[
            "name" => "admin",
            "email" => "admin@gmail.com",
            "password" => Hash::make('admin'),
            "is_admin" => 1
        ], ["name" => "user",
            "email" => "user@gmail.com",
            "password" => Hash::make('user'),
            "is_admin" => 0]]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
