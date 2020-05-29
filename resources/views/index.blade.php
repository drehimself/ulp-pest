@extends('layouts.app')

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">Posts</div>
        <div class="card-body">
            @if (session('success_message'))
                <div class="alert alert-success">
                    {{ session('success_message') }}
                </div>
            @endif
            <ul>
                @forelse ($posts as $post)
                    <li><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></li>
                @empty
                    <li>No posts yet!</li>
                @endforelse
            </ul>

            @auth
                <div>
                    <a href="{{ route('posts.create') }}" class="btn btn-primary">Create Post</a>
                </div>
            @endauth
        </div>
    </div>
</div>

@endsection
