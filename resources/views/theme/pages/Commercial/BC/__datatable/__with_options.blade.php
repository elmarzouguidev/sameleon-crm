<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="col-lg-4 mb-4">
                            <a href="{{ route('commercial:bcommandes.create') }}" type="button" class="btn btn-info">
                                Créer un bon de commande
                            </a>
                        </div>
                    </div>
                </div>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                    <tr>
                        {{--<th style="width: 20px;" class="align-middle">
                            <div class="form-check font-size-16">
                                <input class="form-check-input" type="checkbox" id="checkAll">
                                <label class="form-check-label" for="checkAll"></label>
                            </div>
                        </th>--}}
                        <th>Numéro</th>
                        <th>Founisseur</th>
                        <th>date de BON</th>
                        <th>Montant HT</th>
                        <th>Montant TOTAL</th>
                        <th>Montant TVA</th>
                        {{--<th>Date d'échéance</th>--}}
                        <th>Détails</th>
                        <th>Envoyer</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>

                    @foreach ($commandes as $command)
                        <tr>
                            {{--<td>
                                <div class="form-check font-size-16">
                                    <input class="form-check-input" type="checkbox"
                                           id="orderidcheck-{{ $document->id }}">
                                    <label class="form-check-label" for="orderidcheck-{{ $document->id }}"></label>
                                </div>
                            </td>--}}
                            <td>
                                <a href="{{ $command->url }}" class="text-body fw-bold">
                                    {{ $command->full_number }}
                                </a>
                                <p style="color:#556ee6">
                                    <i class="bx bx-buildings"></i> {{ optional($command->company)->name }}
                                </p>
                            </td>
                            <td> {{ optional($command->provider)->entreprise }}</td>
                            <td>
                                {{ $command->date_command->format('d-m-Y') }}
                            </td>
                            <td>
                                {{ $command->formated_price_ht }}
                            </td>
                            <td>
                                {{ $command->formated_price_total }}
                            </td>
                            <td>
                                {{ $command->formated_total_tva }}
                            </td>
                            {{--<td>
                                {{ $command->date_due }}
                            </td>--}}
                            <td>
                                <a href="{{ $command->url }}" type="button"
                                   class="btn btn-primary btn-sm btn-rounded">
                                    Voir les détails
                                </a>
                            </td>
                            <td>
                                @if (!$command->is_send)
                                    <button type="button" class="btn btn-warning  btn-sm" data-bs-toggle="modal"
                                            data-bs-target=".sendBC-{{ $command->uuid }}">
                                        Envoyer
                                    </button>
                                @else
                                    <a href="#{{-- $command->invoice_url --}}" type="button"
                                       class="btn btn-info btn-sm">
                                        Déjà Envoyé
                                    </a>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-3">
                                    <a href="{{-- route('public.show.bcommand',[$command->uuid,'has_header'=>true])--}}"
                                       target="__blank" class="text-success"
                                       data-bs-toggle="modal"
                                       data-bs-target=".printBC-{{$command->uuid}}"
                                    >
                                        <i class="mdi mdi-file-pdf-outline font-size-18"></i>
                                    </a>
                                    <a href="{{ $command->edit_url }}" class="text-success">
                                        <i class="mdi mdi-pencil font-size-18"></i>
                                    </a>
                                    {{--<a href="#" class="text-danger" onclick="
                                        var result = confirm('Are you sure you want to delete this invoice ?');

                                        if(result){
                                        event.preventDefault();
                                        document.getElementById('delete-command-{{ $document->uuid }}').submit();
                                        }">
                                        <i class="mdi mdi-delete font-size-18"></i>
                                    </a>--}}

                                </div>
                            </td>
                            {{--<form id="delete-command-{{ $document->uuid }}" method="post"
                                  action="{{ route('commercial:bcommandes.delete') }}">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="commandId" value="{{ $document->uuid }}">
                            </form>--}}
                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
