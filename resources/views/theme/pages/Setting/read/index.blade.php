@extends('theme.layouts.app')

@section('content')

<div class="container-fluid">

    @include('theme.pages.Email.section_0_page_title')
    @include('theme.pages.Email.read.content')


</div>

@endsection
@once

    @push('scripts')

        <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>

        <script src="{{asset('assets/libs/tinymce/tinymce.min.js')}}"></script>
        <script src="{{asset('js/pages/ticket-create.init.js')}}"></script>

    @endpush

@endonce
