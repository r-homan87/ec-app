<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('last_name')->after('id');
            $table->string('first_name')->after('last_name');
            $table->string('last_name_kana')->after('first_name');
            $table->string('first_name_kana')->after('last_name_kana');
            $table->string('postal_code', 7)->after('email');
            $table->string('address')->after('postal_code');
            $table->string('phone_number')->after('address');
            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
