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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number', 20);
            $table->string('certificate_number', 50);
            $table->foreignId('policy_id')->index();
            $table->foreignId('agent_id')->index();
            $table->date('date_issued');
            $table->string('insured_name', );
            $table->string('insured_address');
            $table->string('vessel', 50);
            $table->string('voyage_from', 50);
            $table->string('voyage_to', 50);
            $table->date('etd');
            $table->date('eta');
            $table->string('blnum', 50);
            $table->string('clnum', 50);
            $table->mediumText('consignee');
            $table->mediumText('consignee_address');
            $table->mediumText('mortgagee');
            $table->mediumText('subject_matter_insured');
            $table->date('date_effective');
            $table->date('date_expiry');
            $table->decimal('total_sum_insured', 15, 2);
            $table->decimal('total_premium', 15, 2);
            $table->decimal('vat', 15, 2);
            $table->decimal('doc_stamp', 15, 2);
            $table->decimal('lgt', 15, 2);
            $table->decimal('other_charges', 15, 2);
            $table->decimal('total_amount_due', 15, 2);
            $table->string('currency', 3);
            $table->decimal('currency_rate',15 ,4);
            $table->string('currency_other', 3);
            $table->boolean('posted')->default(false);
            $table->softDeletes('deleted_at');
            $table->smallInteger('user_created');
            $table->smallInteger('user_modified');
            $table->timestamps();
        });

        Schema::create('coverages', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50);
            $table->string('name', 100);
            $table->decimal('rate_percent', 2, 2);
            $table->softDeletes('deleted_at');
            $table->smallInteger('user_created');
            $table->smallInteger('user_modified');
            $table->timestamps();
        });

        Schema::create('coverage_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('certificate_id')->index();
            $table->foreignId('coverage_id')->index();
            $table->decimal('invoice_amount', 10, 2);
            $table->decimal('markup_percent', 4, 2);
            $table->decimal('markup_amount', 15, 2)->default(0.00);
            $table->decimal('sum_insured', 15, 2)->default(0.00);
            $table->decimal('premium', 15, 6)->default(0.000000);
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
        Schema::dropIfExists('coverages');
        Schema::dropIfExists('certificates');
    }
};
