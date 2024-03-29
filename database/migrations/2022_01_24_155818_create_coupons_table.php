<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {

            $table->id();
            $table->uuid('uuid')->unique();

            $table->string('code')->unique();
            $table->enum('type', ['fixed', 'percent'])->default('percent');
            $table->bigInteger('value')->nullable();
            $table->bigInteger('percent_off')->nullable();

            $table->enum('model', ['invoice', 'other'])->default('invoice');

            $table->foreignId('invoice_id')
                ->nullable()
                ->index()
                ->constrained();

            $table->boolean('active')->default(true);

            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
