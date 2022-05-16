<div class="row">
    <div class="col-" id="invoices-list">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="col-lg-4 mb-4">
                            {{--<a href="#" type="button" onclick="openFilters()" class="btn btn-primary">
                                Filters
                            </a>--}}
                            <a href="{{ route('commercial:invoices.create.avoir', ['avoir' => 'yes']) }}"
                               type="button" class="btn btn-danger">
                                Créer une facture d'avoir
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
                        {{-- <th style="width: 20px;" class="align-middle">
                            <div class="form-check font-size-16">
                                <input class="form-check-input" type="checkbox" id="checkAll">
                                <label class="form-check-label" for="checkAll"></label>
                            </div>
                        </th> --}}
                        <th>{{ __('invoice.table.number') }}</th>
                        <th>Facture N°</th>
                        <th>{{ __('invoice.table.date_invoice') }}</th>
                        <th>{{ __('invoice.table.total_ht') }}</th>
                        <th>{{ __('invoice.table.total_tva') }}</th>
                        <th>Status</th>
                        <th>Envoyer</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>

                    @foreach ($invoices as $invoice)
                        <tr>
                            {{-- <td>
                                <div class="form-check font-size-16">
                                    <input class="form-check-input" type="checkbox"
                                        id="orderidcheck-{{ $invoice->id }}">
                                    <label class="form-check-label" for="orderidcheck-{{ $invoice->id }}"></label>
                                </div>
                            </td> --}}
                            <td>
                                <a href="{{ $invoice->url }}" class="text-body fw-bold">
                                    <i class="bx bx-hash"></i> {{ $invoice->full_number }}
                                </a>
                                <p style="color:#556ee6">
                                    <i class="bx bx-buildings"></i> {{ optional($invoice->company)->name }}
                                </p>
                            </td>
                            <td>
                                {{ $invoice->invoice_number }}
                                <p style="color:#556ee6">
                                    <i class="bx bx-buildings"></i> {{ optional($invoice->client)->entreprise }}
                                </p>
                            </td>
                            <td>
                                {{ $invoice->invoice_date->format('d-m-Y') }}
                            </td>
                            <td>
                                {{ $invoice->formated_price_ht }} DH
                            </td>
                            {{-- <td>
                                {{ $invoice->formated_price_total }} DH
                            </td> --}}
                            <td>
                                {{ $invoice->formated_total_tva }} DH
                            </td>
                            <td>
                                @php
                                    $status = $invoice->status;
                                    $textt = '';
                                    $color = '';
                                    if ($status === 'paid') {
                                        $textt = 'Régler';
                                        $color = 'info';
                                    } elseif ($status === 'non-paid') {
                                        $textt = 'A régler';
                                        $color = 'warning';
                                    } else {
                                        $textt = 'IMPAYÉE';
                                        $color = 'warning';
                                    }
                                @endphp
                                <i class="mdi mdi-circle text-{{ $color }} font-size-10"></i>
                                {{ $textt }}
                            </td>
                            <td>
                                @if (!$invoice->is_send)
                                    <button type="button" class="btn btn-warning  btn-sm" data-bs-toggle="modal"
                                            data-bs-target=".sendInvoiceAvoir-{{ $invoice->uuid }}">
                                        Envoyer
                                    </button>
                                @else
                                    <a href="#{{-- $invoice->invoice_url --}}" type="button"
                                       class="btn btn-info btn-sm">
                                        Déjà Envoyé
                                    </a>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-3">

                                    <a href="{{-- route('public.show.invoice.avoir',[$invoice->uuid,'has_header'=>true])--}}"
                                       target="__blank" class="text-success"
                                       data-bs-toggle="modal"
                                       data-bs-target=".printInvoiceAvoir-{{ $invoice->uuid }}"
                                    >
                                        <i class="mdi mdi-file-pdf-outline font-size-18"></i>
                                    </a>

                                    <a href="{{ $invoice->edit_url }}" class="text-success">
                                        <i class="mdi mdi-pencil font-size-18"></i>
                                    </a>
                                    {{--<a href="#" class="text-danger" onclick="
                                        var result = confirm('Are you sure you want to delete this invoice ?');

                                        if(result){
                                        event.preventDefault();
                                        document.getElementById('delete-invoice-avr-{{ $invoice->uuid }}').submit();
                                        }">
                                        <i class="mdi mdi-delete font-size-18"></i>
                                    </a>--}}
                                </div>
                            </td>
                            {{--<form id="delete-invoice-avr-{{ $invoice->uuid }}" method="post"
                                  action="{{ route('commercial:invoices.delete.avoir') }}">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="invoiceId" value="{{ $invoice->uuid }}">
                            </form>--}}
                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
