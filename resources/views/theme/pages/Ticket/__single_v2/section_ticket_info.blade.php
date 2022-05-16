<div class="col-lg-6">
    <div class="table-responsive">
        <table class="table mb-0 table-bordered">
            <tbody>
            <tr>
                <th scope="row">Code</th>
                <td>{{ $ticket->code }}</td>
            </tr>
            <tr>
                <th scope="row" style="width: 400px;">Technicien</th>
                <td>{{ optional($ticket->technicien)->full_name }}</td>
            </tr>
            <tr>
                <th scope="row">Client</th>
                <td>{{ optional($ticket->client)->entreprise }}</td>
            </tr>
            <tr>
                <th scope="row">Etat</th>
                <td>{{ __('etat.etats.'. $ticket->etat) }}</td>
            </tr>
            <tr>
                <th scope="row">Status</th>
                <td>

                    {{__('status.statuses.'.$ticket->status)}}
                    {{--$ticket->newStatus()->first()->name--}}
                </td>
            </tr>
            @if(!is_null($ticket->started_at))
                <tr>
                    <th scope="row">Date de départ</th>
                    <td>{{ $ticket->started_at->format('d-m-Y') }}</td>
                </tr>
            @endif
            @if(!is_null($ticket->finished_at))
                <tr>
                    <th scope="row">Date de finalisation</th>
                    <td>{{ $ticket->finished_at->format('d-m-Y') }}</td>
                </tr>
            @endif
            @if($ticket->delivery_count)
                <tr style="color:red">
                    <th scope="row">Date de sortie</th>
                    <td>{{ optional($ticket->delivery)->date_end->format('d-m-Y') }}</td>
                </tr>
                <tr style="color:red">
                    <th scope="row">sortie par :</th>
                    <td>
                        {{ optional($ticket->delivery->reception)->full_name }}<br>
                        note :
                        {{ optional($ticket->delivery)->notes }}
                    </td>

                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
