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
            $table->smallInteger('user_modified')->after('email')->nullable();
            $table->smallInteger('user_created')->after('email')->nullable();
            $table->softDeletes('deleted_at')->after('email')->nullable();
            $table->smallInteger('role_id')->after('email')->nullable();
            $table->foreignId('location_id')->after('email')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('user_modified');
            $table->dropColumn('user_created');
            $table->dropColumn('deleted_at');
            $table->dropColumn('role_id');
            $table->dropColumn('location_id');
        });
    }
};
