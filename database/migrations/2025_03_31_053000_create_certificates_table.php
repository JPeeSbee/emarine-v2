<?php

use App\Models\Agent;
use App\Models\Policy;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('insured_name', 100);
            $table->mediumText('insured_address');
            $table->string('vessel', 50);
            $table->string('voyage_from', 50);
            $table->string('voyage_to', 50);
            $table->dateTime('etd');
            $table->dateTime('eta');
            $table->string('blnum', 50);
            $table->string('lcnum', 50);
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
            $table->string('currency_other', 3);
            $table->decimal('currency_rate', 15, 4);
            $table->boolean('posted');
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
        Schema::dropIfExists('certificates');
    }
};
