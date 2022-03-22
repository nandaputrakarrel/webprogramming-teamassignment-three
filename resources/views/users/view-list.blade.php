@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <users-viewlist v-bind:user="{{ json_encode(Auth::user()) }}"></users-viewlist>
        </div>
    </div>
</div>
@endsection
