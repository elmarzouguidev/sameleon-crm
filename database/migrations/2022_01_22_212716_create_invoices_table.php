<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {

            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('code');
            $table->string('full_number')->unique();

            $table->string('bl_code')->nullable();
            $table->string('bc_code')->nullable();

            $table->unsignedBigInteger('price_ht')->default(0);
            $table->unsignedBigInteger('price_total')->default(0);
            $table->unsignedBigInteger('price_tva')->default(0);

            $table->string('status')->default('impayee');

            $table->string('remise')->default('0');

            $table->date('invoice_date')->nullable();
            $table->date('due_date')->nullable();
            $table->date('payment_date')->nullable();

            $table->enum('type', ['normal', 'avoir'])->default('normal');
            $table->boolean('has_avoir')->default(false);
            $table->boolean('is_paid')->default(false);

            $table->boolean('active')->default(true);

            $table->mediumText('admin_notes')->nullable();
            $table->mediumText('client_notes')->nullable();
            $table->mediumText('condition_general')->nullable();

            $table->foreignId('client_id')
                //->index()
                ->nullable()
                ->constrained();
            $table->foreignId('ticket_id')
                //->index()
                ->nullable()
                ->constrained();
            $table->foreignId('company_id')
                //->index()
                ->constrained();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
