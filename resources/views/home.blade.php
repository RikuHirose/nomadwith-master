@extends('layouts.app')

@section('content')
<div id="app">
        <main-app :show-header="{{ getenv('UI_HIDE_HEADER') }}"></main-app>
    </div>
@endsection
