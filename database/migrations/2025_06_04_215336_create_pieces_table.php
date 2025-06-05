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
        Schema::create('pieces', function (Blueprint $table) {
            $table->id();

            $table->string('code');
            $table->decimal('theoretical_weight', 4, 2);
            $table->decimal('real_weight', 4, 2)->nullable();
            $table->enum('status', ['Pendiente', 'Fabricado'])->default('Pendiente');
            $table->boolean('deleted')->default(false);

            $table->string('block_id');
            $table->timestamp('registration_date')->nullable();
            $table->unsignedBigInteger('registered_by')->nullable();

            $table->foreign('block_id')->references('id')->on('blocks')->onDelete('cascade');
            $table->foreign('registered_by')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pieces');
    }
};
