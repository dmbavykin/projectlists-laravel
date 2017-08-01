<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeadlineColumnForTasks extends Migration
{

    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->date('deadline')->nullable();
        });
    }

    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('deadline');
        });
    }
}
