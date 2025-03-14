<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('finances', function (Blueprint $table) {
            $table->id('id_finance'); // clé primaire auto-incrémentée
            $table->enum('type_operation', ['dépense', 'revenu', 'facture', 'taxe']);
            $table->text('description')->nullable();
            $table->decimal('montant', 10, 2);
            $table->date('date_operation');
            $table->enum('categorie', ['Marketing', 'Salaire', 'Fournisseur'])->nullable();
            $table->unsignedBigInteger('id_fournisseur')->nullable();
            $table->enum('statut', ['Payé', 'En attente', 'Annulé'])->default('En attente');
            $table->string('reference_facture', 100)->nullable();
            $table->timestamp('date_creation')->useCurrent();
            $table->timestamp('date_modification')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('id_fournisseur')
                ->references('id_fournisseur')->on('fournisseurs')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('finances');
    }
};
