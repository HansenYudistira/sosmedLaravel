@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Edit Post</h1>
    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="content">Content</label>
            <textarea id="content" name="content" class="form-control" required>{{ $post->content }}</textarea>
        </div>
        <div class="form-group mt-3">
            <label for="media">Upload Media (Image/Video)</label>
            <input type="file" id="media" name="media" class="form-control-file">
        </div>
        <button type="submit" class="btn btn-primary mt-3">Update Post</button>
    </form>
</div>
@endsection