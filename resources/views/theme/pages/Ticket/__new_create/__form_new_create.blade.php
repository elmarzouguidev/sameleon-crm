<div class="row">
    <div class="col-lg-8">
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
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
        @endif
        <form  action="{{ route('admin:tickets.createPost') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card mb-4">
                <div class="card-body">

                    <p class="card-title-desc">Ajouter un Ticket</p>

                    <div class="row">
                        <div class="col-lg-6">

                            @include('theme.pages.Ticket.__new_create.__info')

                            <div class="docs-options">
                                <label class="form-label">Numéro de Ticket</label>
                                <div class="input-group mb-4">
                                    <input type="text" class="form-control"
                                            value=""
                                           aria-describedby="code" readonly>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6 mb-4">
                                        <label>* Date de entrer</label>
                                        <div class="input-group" id="datepicker1">
                                            <input type="text"
                                                   class="form-control"
                                                   value=""
                                                   data-date-format="mm-dd-yyyy"
                                                   data-date-container='#datepicker1' data-provide="datepicker">

                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mb-4">
                                        <label> Date de sortie</label>
                                        <div class="input-group" id="datepicker2">
                                            <input type="text"
                                                   class="form-control"
                                                   value=""
                                                   data-date-format="mm-dd-yyyy" data-date-container='#datepicker2'
                                                   data-provide="datepicker" data-date-autoclose="true">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class=" mb-4">
                                <label>Image</label>
                                <div style="width: 80%">
                                    <img src="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    <p class="card-title-desc"> Détails de Ticket</p>
                    <div class="row">
                        <div class="col-lg-4 mb-4">

                        </div>
                    </div>
                    <div class="row" id="articles_list">

                        <div class="col-lg-12">
                            <div class="justify-content-end">
                                <div class="card border border-primary">
                                    <div class="card-header bg-transparent border-primary">

                                             <textarea class="form-control @error('description') is-invalid @enderror" name="description"
                                                                       id="ticketdesc-editor" rows="6">
                                            
                                            </textarea>

                                            @error('description')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="d-flex flex-wrap gap-2 justify-content-end mb-4">
                <div class="">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                        Update
                    </button>
                    <button type="submit" class="btn btn-secondary waves-effect waves-light">
                        Sauvegarder en tant que brouillon
                    </button>
                </div>
            </div>

        </form>
    </div>

    <div class="col-lg-4">
        @include('theme.pages.Ticket.__new_create.__ticket_actions')
    </div>

</div>

