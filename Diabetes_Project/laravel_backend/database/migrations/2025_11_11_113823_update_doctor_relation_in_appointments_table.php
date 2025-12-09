<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            try {
                DB::statement('ALTER TABLE appointments DROP CONSTRAINT IF EXISTS appointments_doctor_id_foreign');
            } catch (\Exception $e) {
            }

            if (!Schema::hasColumn('appointments', 'doctor_id')) {
                $table->unsignedBigInteger('doctor_id')->nullable();
            }

            $table->foreign('doctor_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['doctor_id']);
        });
    }
};

