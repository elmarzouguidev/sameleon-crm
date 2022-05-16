<div class="row">
    <div class="col-lg-12">
        <div class="mb-4">
            <label class="form-label">Ticket *</label>
            <input id="article" name="article" type="text"
                   class="form-control @error('article') is-invalid @enderror"
                   value="{{$ticket->article}}">
            @error('article')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>
    </div>

</div>
