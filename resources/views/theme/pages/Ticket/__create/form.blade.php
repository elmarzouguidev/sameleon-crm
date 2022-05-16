<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Ajouter un Ticket</h4>

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
                <form id="ticketForm" action="{{ route('admin:tickets.createPost') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 row">

                        <label class="col-lg-2 col-form-label">Retour ?</label>
                        <div class="col-lg-2">
                            <input class="form-check-input" name="is_retour" type="checkbox" id="is_retour" onclick="myFunction()">
                            <label class="form-check-label" for="is_retour">
                                Retourné ?
                            </label>
                        </div>
                        <div class="col-lg-8">

                            <select disabled name="ticket_retoure" id="ticket_retoure" class="form-select select2 @error('ticket_retoure') is-invalid @enderror">
                                <option value="">choisir le ticket retourné</option>
                             
                                    @foreach ($tickets as $ticket)
                                        <option data-client="{{$ticket->client_id}}" data-article="{{$ticket->article}}" value="{{ $ticket->id }}">{{ $ticket->code }} -- (N retour : {{$ticket->retour_number}})</option>
                                    @endforeach
                               
                            </select>
                            @error('ticket_retoure')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>
                    <div class="row mb-4">
                        <label for="article" class="col-form-label col-lg-2">Article *</label>
                        <div class="col-lg-10">
                            <input id="article" name="article" type="text"
                                class="form-control @error('article') is-invalid @enderror"
                                value="{{ old('article') }}" placeholder="Entrer l'article ..." required>
                            @error('article')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Client *</label>
                        <div class="col-md-8">

                            <select id="clientList" name="client" class="form-select select2 @error('photo') is-invalid @enderror" required>
                                <option value="">choisir le client</option>
                                <optgroup label="Clients">
                                    @foreach ($clients as $client)
                                        <option data-tickclient="{{ $client->id }}" value="{{ $client->id }}">{{ $client->entreprise }}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                            @error('client')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            {{--<a href="{{ route('admin:clients.create') }}" type="button" class="btn btn-info">
                               Ajouter un client
                            </a>--}}
                            <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                    data-bs-target=".createClient">
                                Ajouter un client
                            </button>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label class="col-form-label col-lg-2">Description *</label>
                        <div class="col-lg-10">
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description"
                                id="ticketdesc-editor" rows="3" placeholder="Entrer la description " required>
                                {{ old('description') }}
                            </textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label class="col-form-label col-lg-2">Photo *</label>
                        <div class="col-lg-10">
                            <input class="form-control @error('photo') is-invalid @enderror" name="photo" type="file"
                                accept="image/*"  required/>
                            @error('photo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-lg-10">
                            <button type="submit" class="btn btn-primary">
                                {{__('buttons.store')}}
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
