<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Filters</h5>

                <form class="row gy-2 gx-3 align-items-center">
                    {{--<div class="col-sm-auto">
                        <label class="visually-hidden" for="autoSizingInput">Name</label>
                        <input type="text" class="form-control" id="autoSizingInput" placeholder="">
                    </div>--}}
                    <div class="col-lg-2 col-md-2">

                        <div class="input-group" id="datepicker1">
                            <input type="text" name="ticket_date" id="filterDate"
                                   class="form-control @error('ticket_date') is-invalid @enderror"
                                   value="{{ request()->input('appFilter.GetTicketDate') }}" data-date-format="dd-mm-yyyy"
                                   data-date-container='#datepicker1' data-provide="datepicker" placeholder="Date">

                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                            @error('ticket_date')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2">
                        <label class="visually-hidden" for="clientsList">Client</label>
                        <select class="form-select select2" id="clientsList">
                            <option selected value="">Client</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}"
                                    {{ in_array($client->id, explode(',', request()->input('appFilter.GetClient'))) ? 'selected' : '' }}>

                                    {{ $client->entreprise }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-sm-auto">
                        <label class="visually-hidden" for="statusList">Status</label>
                        <select class="form-select " id="statusList">
                            <option selected value="">Status</option>
                            <option value="{{ App\Constants\Status::NON_TRAITE }}"
                                {{ in_array(App\Constants\Status::NON_TRAITE, explode(',', request()->input('appFilter.GetStatus')))? 'selected': '' }}>
                                Non traité
                            </option>
                            <option value="{{ App\Constants\Status::EN_COURS_DE_DIAGNOSTIC }}"
                                {{ in_array(App\Constants\Status::EN_COURS_DE_DIAGNOSTIC, explode(',', request()->input('appFilter.GetStatus')))? 'selected': '' }}>
                                En cours de diagnostic
                            </option>
                            <option value="{{ App\Constants\Status::EN_COURS_DE_REPARATION }}"
                                {{ in_array(App\Constants\Status::EN_COURS_DE_REPARATION, explode(',', request()->input('appFilter.GetStatus')))? 'selected': '' }}>
                                En cours de réparation
                            </option>
                            <option value="{{ App\Constants\Status::RETOUR_NON_REPARABLE }}"
                                {{ in_array(App\Constants\Status::RETOUR_NON_REPARABLE, explode(',', request()->input('appFilter.GetStatus')))? 'selected': '' }}>
                                Retour non réparable
                            </option>
                            <option value="{{ App\Constants\Status::RETOUR_DEVIS_NON_CONFIRME }}"
                                {{ in_array(App\Constants\Status::RETOUR_DEVIS_NON_CONFIRME,explode(',', request()->input('appFilter.GetStatus')))? 'selected': '' }}>
                                Retour Devis non
                                confirmé
                            </option>
                            <option value="{{ App\Constants\Status::RETOUR_LIVRE }}"
                                {{ in_array(App\Constants\Status::RETOUR_LIVRE, explode(',', request()->input('appFilter.GetStatus')))? 'selected': '' }}>
                                Retour livré
                            </option>
                            <option value="{{ App\Constants\Status::EN_ATTENTE_DE_DEVIS }}"
                                {{ in_array(App\Constants\Status::EN_ATTENTE_DE_DEVIS, explode(',', request()->input('appFilter.GetStatus')))? 'selected': '' }}>


                                En attente de devis
                            </option>
                            <option value="{{ App\Constants\Status::EN_ATTENTE_DE_BON_DE_COMMAND }}"
                                {{ in_array(App\Constants\Status::EN_ATTENTE_DE_BON_DE_COMMAND,explode(',', request()->input('appFilter.GetStatus')))? 'selected': '' }}>


                                En attente de
                                bon
                                de command</option>
                            <option value="{{ App\Constants\Status::DEVIS_CONFIRME }}"
                                {{ in_array(App\Constants\Status::DEVIS_CONFIRME, explode(',', request()->input('appFilter.GetStatus')))? 'selected': '' }}>


                                Devis Confirmé
                            </option>
                            <option value="{{ App\Constants\Status::A_REPARER }}"
                                {{ in_array(App\Constants\Status::A_REPARER, explode(',', request()->input('appFilter.GetStatus')))? 'selected': '' }}>

                                à réparer
                            </option>
                            <option value="{{ App\Constants\Status::PRET_A_ETRE_LIVRE }}"
                                {{ in_array(App\Constants\Status::PRET_A_ETRE_LIVRE, explode(',', request()->input('appFilter.GetStatus')))? 'selected': '' }}>



                                Prêt à être livré
                            </option>
                            <option value="{{ App\Constants\Status::PRET_A_ETRE_FACTURE }}"
                                {{ in_array(App\Constants\Status::PRET_A_ETRE_FACTURE, explode(',', request()->input('appFilter.GetStatus')))? 'selected': '' }}>


                                Prêt à être Facturé
                            </option>
                            <option value="{{ App\Constants\Status::LIVRE }}"
                                {{ in_array(App\Constants\Status::LIVRE, explode(',', request()->input('appFilter.GetStatus')))? 'selected': '' }}>


                                Livré
                            </option>
                        </select>
                    </div>
                    {{--<div class="col-sm-auto">
                        <div class="form-check">
                            <input class="form-check-input" name="etat"
                                value="{{ App\Constants\Etat::NON_DIAGNOSTIQUER }}" type="radio"
                                id="autoSizingCheck0"
                                {{ in_array(App\Constants\Etat::NON_DIAGNOSTIQUER, explode(',', request()->input('appFilter.GetEtat')))? 'checked': '' }}>
                            <label class="form-check-label" for="autoSizingCheck0">
                                Non diagnostiqué
                            </label>
                        </div>

                    </div>--}}
                    <div class="col-sm-auto">
                        <div class="form-check">
                            <input class="form-check-input" name="etat" value="{{ App\Constants\Etat::REPARABLE }}"
                                type="radio" id="autoSizingCheck1"
                                {{ in_array(App\Constants\Etat::REPARABLE, explode(',', request()->input('appFilter.GetEtat')))? 'checked': '' }}>
                            <label class="form-check-label" for="autoSizingCheck1">
                                Réparable
                            </label>
                        </div>

                    </div>
                    <div class="col-sm-auto">
                        <div class="form-check">
                            <input class="form-check-input" name="etat"
                                value="{{ App\Constants\Etat::NON_REPARABLE }}" type="radio" id="autoSizingCheck2"
                                {{ in_array(App\Constants\Etat::NON_REPARABLE, explode(',', request()->input('appFilter.GetEtat')))? 'checked': '' }}>
                            <label class="form-check-label" for="autoSizingCheck2">
                                Non Réparable
                            </label>
                        </div>

                    </div>
                    <div class="col-md-2">
                        <input class="form-check-input" name="has_router" type="checkbox" id="has_router"
                        {{ in_array('on', explode(',', request()->input('appFilter.GetRetour')))? 'checked': '' }}
                        >
                        <label class="form-check-label" for="has_router">
                            Retour
                        </label>
                    </div>
                    <div class="col-sm-auto">
                        <button type="submit" id="filterData" class="btn btn-primary w-md">filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
