<?php

namespace App\Policies;

use App\Constants\Status;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Ticket $ticket
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Ticket $ticket)
    {
        return $user->hasRole('Technicien') || $user->hasPermissionTo('ticket.read')
            ? Response::allow()
            : Response::deny("désolé vous n'avez pas l'autorisation de voir ce ticket .");
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasRole('Reception') || $user->hasPermissionTo('ticket.create')
            ? Response::allow()
            : Response::deny("désolé vous n'avez pas l'autorisation de crée un ticket .");
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Ticket $ticket
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Ticket $ticket)
    {
        return $user->hasRole('Admin') || $user->hasPermissionTo('ticket.edit')
            ? Response::allow()
            : Response::deny("désolé vous n'avez pas l'autorisation de modifier ce ticket .");
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Ticket $ticket
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Ticket $ticket)
    {
        return $user->hasRole('Admin') || $user->hasPermissionTo('ticket.delete')
            ? Response::allow()
            : Response::deny("désolé vous n'avez pas l'autorisation de supprimer ce ticket .");
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Ticket $ticket
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Ticket $ticket)
    {
        //
    }


    /**
     * @param User $user
     * @param Ticket $ticket
     * @return Response
     */
    public function forceDelete(User $user, Ticket $ticket)
    {
        return $user->hasPermissionTo('ticket.delete')
            ? Response::allow()
            : Response::deny("désolé vous n'avez pas l'autorisation de supprimer ce ticket .");
    }


    /**
     * @param User $user
     * @param Ticket $ticket
     * @return Response
     */
    public function canDiagnose(User $user, Ticket $ticket)
    {
        return $user->hasAnyRole('Technicien', 'Admin', 'SuperAdmin')
            ? Response::allow()
            : Response::deny("désolé vous n'avez pas l'autorisation de diagnostiquer ce ticket .");
    }

    public function canStoreDiagnose(User $user, Ticket $ticket)
    {

        return $user->hasRole('Technicien')
            &&
            $ticket->technicien()->is($user)
            //&& $ticket->diagnoseReports->close_report === false

            ? Response::allow()
            : Response::deny("désolé vous n'avez pas l'autorisation de diagnostiquer ce ticket .");
    }

    public function canConfirme(User $user, Ticket $ticket)
    {
        // dd('cab fofofof');
        return $user->hasAnyRole('Admin', 'SuperAdmin')
            && $ticket->user_id !== null
            && $ticket->status == Status::EN_ATTENTE_DE_BON_DE_COMMAND
            ? Response::allow()
            : Response::deny("désolé vous n'avez pas l'autorisation de confirmer  ce ticket il faut crée le devis avant confirmé .");
    }


    public function canRepear(User $user, Ticket $ticket)
    {
        return $user->hasRole('Technicien')
            && $ticket->technicien()->is($user)

            ? Response::allow()
            : Response::deny("désolé vous n'avez pas l'autorisation de Réparer  ce ticket .");
    }

    public function canRepearStore(User $user, Ticket $ticket)
    {

        //dd('store repar');
        return $user->hasRole('Technicien')
            && $ticket->technicien()->is($user)
            && $ticket->status == Status::EN_COURS_DE_REPARATION
            ? Response::allow()
            : Response::deny("désolé vous n'avez pas l'autorisation de Réparer  ce ticket .");
    }
}
