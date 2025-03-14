<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('conges', function (Blueprint $table) {
            $table->id('id_conge');
            $table->unsignedBigInteger('id_employe');
            $table->enum('type_conge', ['RTT','CP','Maladie']);
            $table->date('date_debut');
            $table->date('date_fin');
            $table->enum('statut', ['En attente','Validé','Annulé'])->default('En attente');
            $table->text('commentaires')->nullable();
            $table->timestamps();

            $table->foreign('id_employe')
                ->references('id_employe')
                ->on('employes')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('conges');
    }
};
