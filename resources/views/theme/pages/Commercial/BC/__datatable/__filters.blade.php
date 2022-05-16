<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Filters</h5>

                <form class="row gy-2 gx-3 align-items-center">
                    <div class="col-lg-2 col-md-2">

                        <div class="input-group" id="datepicker1">
                            <input type="text" name="invoice_date" id="filterDate"
                                   class="form-control @error('invoice_date') is-invalid @enderror"
                                   value="{{ request()->input('appFilter.GetBCDate') }}" data-date-format="dd-mm-yyyy"
                                   data-date-container='#datepicker1' data-provide="datepicker" placeholder="Date">

                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                            @error('invoice_date')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2">
                        <label class="visually-hidden" for="clienter">Fournisseur</label>
                        <select class="form-select select2" id="clienter">
                            <option selected value="">Fournisseur</option>
                            @foreach ($providers as $provider)
                                <option value="{{ $provider->id }}"
                                    {{ in_array($provider->id, explode(',', request()->input('appFilter.GetProvider'))) ? 'selected' : '' }}>

                                    {{ $provider->entreprise }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                    @foreach ($companies as $company)
                        <div class="col-sm-auto">
                            <div class="form-check">
                                <input class="form-check-input chk-filter" type="radio" name="company"
                                    id="company-{{ $company->id }}" value="{{ $company->id }}"
                                    {{ in_array($company->id, explode(',', request()->input('appFilter.GetCompany'))) ? 'checked' : '' }}>

                                <label class="form-check-label" for="company-{{ $company->id }}">
                                    {{ $company->name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-sm-auto">
                        <button type="submit" id="filterData" class="btn btn-primary w-md">filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
