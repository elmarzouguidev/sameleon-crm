<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create('b_routers', function (Blueprint $table) {
            $table->id();
            
            $table->uuid('uuid')->unique();
            $table->string('code')->unique();
            $table->string('full_number')->unique();

            $table->string('price_ht')->nullable();
            $table->string('price_total')->nullable();
            $table->string('price_tva')->nullable();
            $table->string('status')->default('approved');

            $table->date('date_command');
            $table->date('date_approved')->nullable();
            $table->date('date_due')->nullable();

            $table->foreignId('provider_id')->index()->nullable();

            $table->mediumText('admin_notes')->nullable();
            $table->mediumText('client_notes')->nullable();
            $table->mediumText('condition_general')->nullable();

            $table->boolean('active')->default(true);

            $table->timestamps();
            $table->softDeletes();
  
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('b_routers');
    }
};
