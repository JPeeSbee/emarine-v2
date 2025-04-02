<?php

use App\Models\Certificate;
use App\Models\Coverage;
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
        Schema::create('coverage_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coverage_id')->index();
            $table->foreignId('certificates_id')->index();
            $table->decimal('invoice_amount', 10, 2);
            $table->decimal('markup_percent', 4, 2);
            $table->decimal('markup_amount', 15, 2);
            $table->decimal('sum_insured', 15, 2);
            $table->decimal('rate_percent', 4, 4);
            $table->decimal('premium', 15, 6);
            $table->softDeletes('deleted_at');
            $table->smallInteger('user_created');
            $table->smallInteger('user_modified');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coverage_details');
    }
};
