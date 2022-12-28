<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_member_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by');
            $table->foreignId('team_member_id');
            $table->foreignId('task_id');
            $table->boolean('is_important')->default(false);
            $table->string('status')->default('on work');
            $table->timestamp('reminder_at')->nullable();
            $table->longText('note')->nullable();
            $table->date('due_date')->nullable();
            $table->timestamp('added_to_my_day_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_member_tasks');
    }
};
