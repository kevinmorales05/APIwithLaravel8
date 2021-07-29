<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleColumnUser extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
        $table->string('role')->default(\App\Models\User::ROLE_USER);
        });
    }
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('role');
        });
    }
}
