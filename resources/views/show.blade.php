@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h2>{{ $post->title }}</h2>
                <div>
                    {{ $post->body }}
                </div>
            </div>
        </div>
    </div>
@endsection
