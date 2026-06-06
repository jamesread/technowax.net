<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 32)->nullable()->unique()->after('id');
            $table->foreignId('group_id')->nullable()->after('password')->constrained('groups');
            $table->timestamp('last_login')->nullable()->after('group_id');
            $table->timestamp('registered_at')->nullable()->after('last_login');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('group_id');
            $table->dropColumn(['username', 'last_login', 'registered_at']);
        });
    }
};
