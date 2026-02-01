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
        Schema::create('sysparams', function (Blueprint $table) {
            $table->id();
            $table->uuid('code')->unique();
            $table->string('groups');
            $table->string('key');
            $table->text('value');
            $table->integer('ordering')->nullable();
            $table->text('description')->nullable();
            $table->integer('status')->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Add index for faster queries
            $table->index(['groups', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sysparams');
    }
};
