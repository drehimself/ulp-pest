@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-6">
            <h3>Create Post</h3>
            <form action="{{ route('posts.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="Title of post">
                </div>

                <div class="form-group">
                    <label for="body">Body</label>
                    <textarea class="form-control" name="body" id="body" rows="5"></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Create Post</button>
                </div>
            </form>
        </div>
    </div>
@endsection
