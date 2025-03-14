<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('salaires', function (Blueprint $table) {
            $table->id('id_salaire');
            $table->unsignedBigInteger('id_employe');
            $table->decimal('montant', 10, 2);
            $table->date('date_debut');
            $table->date('date_fin')->nullable();
            $table->timestamp('date_creation')->useCurrent();
            $table->timestamp('date_modification')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('id_employe')
                ->references('id_employe')
                ->on('employes')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('salaires');
    }
};
