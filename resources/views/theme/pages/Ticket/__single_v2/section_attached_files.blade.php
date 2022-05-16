<div class="col-lg-6">
    <div class="table-responsive">
        <table class="table mb-0 table-bordered">
            <tbody>
            <tr>
                <th scope="row">fichiers attachés</th>
                <th scope="row">Nom</th>
                <th scope="row">Télécharger</th>
            </tr>
            @if($ticket->estimate_count > 0)
                <tr>
                    <td style="width: 45px;">
                        <div class="avatar-sm">
                          <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-24">
                            <i class="bx bxs-file-pdf"></i>
                          </span>
                        </div>
                    </td>
                    <td>
                        <h5 class="font-size-14 mb-1">
                            <a target="_blank" title="{{$ticket->estimate->full_number}}"
                               href="{{ route('public.show.estimate',[$ticket->estimate->uuid,'has_header'=>true])}}"

                               class="text-dark">DEVIS-{{$ticket->estimate->code}}.pdf</a></h5>
                        {{--<small>Size : 3.25 MB</small>--}}
                    </td>
                    <td>
                        <div class="text-center">
                            <a target="_blank"
                               href="{{ route('public.show.estimate',[$ticket->estimate->uuid,'has_header'=>true])}}"
                               class="text-dark"><i
                                    class="bx bx-download h3 m-0"></i></a>
                        </div>
                    </td>
                </tr>
            @endif
            @if($ticket->invoice_count > 0)
                <tr>
                    <td style="width: 45px;">
                        <div class="avatar-sm">
                      <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-24">
                           <i class="bx bxs-file-pdf"></i>
                        </span>
                        </div>
                    </td>
                    <td>
                        <h5 class="font-size-14 mb-1">
                            <a target="_blank" title="{{$ticket->invoice->full_number}} : {{optional($ticket->invoice->company)->name}}"
                               href="{{ route('public.show.invoice',[$ticket->invoice->uuid,'has_header'=>true])}}"

                               class="text-dark">FACTURE-{{$ticket->invoice->code}}.pdf</a></h5>

                    </td>
                    <td>
                        <div class="text-center">
                            <a target="_blank"
                               href="{{ route('public.show.invoice',[$ticket->invoice->uuid,'has_header'=>true])}}"
                               class="text-dark"><i
                                    class="bx bx-download h3 m-0"></i></a>
                        </div>
                    </td>
                </tr>
            @endif
            <tr>
                <td style="width: 45px;">
                    <div class="avatar-sm">
                      <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-24">
                           <i class="bx bxs-file-pdf"></i>
                        </span>
                    </div>
                </td>
                <td>
                    <h5 class="font-size-14 mb-1">
                        <a target="_blank"
                           title="{{$ticket->code}}"
                           href="{{ route('admin:tickets.report.generate',$ticket->uuid) }}"
                                                     class="text-dark">Rapport-complet.pdf
                        </a>
                    </h5>

                </td>
                <td>
                    <div class="text-center">
                        <a target="_blank" href="{{ route('admin:tickets.report.generate',$ticket->uuid) }}"
                           class="text-dark">
                            <i class="bx bx-download h3 m-0"></i>

                        </a>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
