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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('salary');
            $table->timestamps();
        });

        //stored procedure
        DB::unprepared('
            CREATE PROCEDURE UpdateSalary(IN empID INT, IN newSalary INT)
            BEGIN
                UPDATE employees
                SET salary = newSalary
                WHERE id = empID;
            END
        ');

        //trigger
        DB::unprepared('
            CREATE TRIGGER AfterUpdateSalary
            AFTER UPDATE ON employees
            FOR EACH ROW
            BEGIN
                CALL UpdateSalary(NEW.id, NEW.salary);
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the table and the stored procedure when rolling back
        Schema::dropIfExists('employees');
        DB::unprepared('DROP PROCEDURE IF EXISTS UpdateSalary');
        DB::unprepared('DROP TRIGGER IF EXISTS AfterUpdateSalary');
    }
};
