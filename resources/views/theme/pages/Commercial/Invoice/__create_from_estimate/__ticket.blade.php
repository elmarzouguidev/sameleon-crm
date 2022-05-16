<div class="col-lg-12 mb-4">
    <label for="example-password-input" class="col-md-2 col-form-label">Ticket</label>

    <select name="ticket"
            class="select2 form-control select2-multiple @error('tickets') is-invalid @enderror"
    >
        <option value="{{$estimate->ticket->id}}">
            {{$estimate->ticket->code}}
        </option>
    </select>
</div>
