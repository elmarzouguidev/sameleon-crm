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
        Schema::table('tickets', function (Blueprint $table) {
            $table->after('code',function($table){
                $table->string('code_retour')->unique()->nullable();
                $table->boolean('is_retour')->default(false);
            });
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn(['code_retour','is_retour']);
        });
    }
};
