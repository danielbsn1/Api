<?php

declare(strict_types=1);

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
       Schema::create('employs', function (Blueprint $table) {
    $table->id();
    $table->uuid('uuid')->unique();

    $table->string('first_name');
    $table->string('last_name');
    $table->string('preferred_name')->nullable();

    $table->string('cpf', 14)->unique();
    $table->string('rg', 12)->unique();
    $table->string('email')->unique();
    $table->string('phone', 15)->nullable();

    $table->foreignId('department_id')->constrained('departments')->cascadeOnDelete();
    $table->foreignId('position_id')->constrained('positions')->cascadeOnDelete();

    $table->date('hire_date');
    $table->date('termination_date')->nullable();
    $table->decimal('salary', 10, 2)->nullable();

    $table->enum('status', [
        'active',
        'inactive',
        'vacation',
        'leave',
        'terminated',
    ])->default('active');

    $table->timestamps();
    $table->softDeletes();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employs');
    }
};
