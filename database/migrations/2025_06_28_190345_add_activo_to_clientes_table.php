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
    Schema::table('clientes', function (\Illuminate\Database\Schema\Blueprint $table) {
        $table->boolean('activo')->default(true)->after('panel');
    });
}

public function down(): void
{
    Schema::table('clientes', function (\Illuminate\Database\Schema\Blueprint $table) {
        $table->dropColumn('activo');
    });
}

};
