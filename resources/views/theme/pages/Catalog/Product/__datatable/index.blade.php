@extends('theme.layouts.app')

@section('content')

    <div class="container-fluid">

        @include('theme.pages.Catalog.Product.__title')

        @include('theme.pages.Catalog.Product.__datatable.__with_options')

    </div>

@endsection

@section('css')

@endsection

@push('scripts')

    <script src="{{ asset('assets/libs/datatables.js') }}"></script>
    <script src="{{ asset('js/pages/datatables.init.js') }}"></script>
@endpush
