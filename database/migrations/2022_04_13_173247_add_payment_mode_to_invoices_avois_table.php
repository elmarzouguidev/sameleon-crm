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
        Schema::table('invoice_avoirs', function (Blueprint $table) {
            $table->string('payment_mode')->nullable()->after('due_date');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('invoice_avoirs', function (Blueprint $table) {
            $table->dropColumn('payment_mode');
        });
    }
};
