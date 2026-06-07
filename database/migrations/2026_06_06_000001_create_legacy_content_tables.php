<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wiki_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('alt_title')->nullable();
            $table->longText('content')->nullable();
        });

        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('title', 32);
            $table->string('css')->nullable();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('key', 32)->unique();
            $table->text('description')->nullable();
        });

        Schema::create('group_memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('groups')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        });

        Schema::create('privileges_g', function (Blueprint $table) {
            $table->foreignId('permission_id')->constrained('permissions')->cascadeOnDelete();
            $table->foreignId('group_id')->constrained('groups')->cascadeOnDelete();
            $table->primary(['permission_id', 'group_id']);
        });

        Schema::create('privileges_u', function (Blueprint $table) {
            $table->foreignId('permission_id')->constrained('permissions')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->primary(['permission_id', 'user_id']);
        });

        Schema::create('featured_projects', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 64)->unique();
            $table->string('name', 128);
            $table->text('description')->nullable();
            $table->string('homepage_url', 512)->nullable();
            $table->string('github_url', 512)->nullable();
            $table->string('docs_url', 512)->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamp('imported_at')->useCurrent();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('featured_projects');
        Schema::dropIfExists('privileges_u');
        Schema::dropIfExists('privileges_g');
        Schema::dropIfExists('group_memberships');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('groups');
        Schema::dropIfExists('wiki_pages');
    }
};
