@extends('theme.layouts.app')

@section('content')

<div class="container-fluid">

    @include('theme.pages.Setting.section_0_page_title')

    @include('theme.pages.Setting.emails')

</div>

@include('theme.pages.Setting.compose.composeModal')

@endsection
