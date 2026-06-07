<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('dyndns');
    }

    public function down(): void
    {
        Schema::create('dyndns', function (Blueprint $table) {
            $table->id();
            $table->timestamp('timestamp')->useCurrent();
            $table->string('ip_address', 45);
            $table->string('ident')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        });
    }
};
