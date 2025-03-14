<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_employe');
            $table->date('date_absence');
            $table->string('motif')->nullable();
            $table->timestamps();

            $table->foreign('id_employe')
                ->references('id_employe')
                ->on('employes')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('absences');
    }
};
