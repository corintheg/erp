<?php

namespace App\Observers;

use App\Models\Employe;
use App\Models\Utilisateur;

class EmployeObserver
{
    /**
     * Handle the Employe "created" event.
     */
    public function created(Employe $employe): void
    {
        $username = strtolower($employe->prenom . '.' . $employe->nom);
        $motDePasse = strtolower($employe->prenom . $employe->nom . $employe->id_employe);

        $data = [
            'id_employe' => $employe->id_employe,
            'username' => $username,
            'mot_de_passe' => bcrypt($motDePasse),
            'email' => $employe->email,
            'date_creation' => now(),
            'date_modification' => now()
        ];

        //dd($data); // Vérifiez les données avant l'insertion

        Utilisateur::create($data);
    }

    /**
     * Handle the Employe "updated" event.
     */
    public function updated(Employe $employe): void
    {
        //
    }

    /**
     * Handle the Employe "deleted" event.
     */
    public function deleted(Employe $employe): void
    {
        //
    }

    /**
     * Handle the Employe "restored" event.
     */
    public function restored(Employe $employe): void
    {
        //
    }

    /**
     * Handle the Employe "force deleted" event.
     */
    public function forceDeleted(Employe $employe): void
    {
        //
    }
}
