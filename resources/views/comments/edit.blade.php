@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Edit Comment</h1>
    <form action="{{ route('comments.update', $comment->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="content">Content</label>
            <textarea id="content" name="content" class="form-control" required>{{ $comment->content }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Update Comment</button>
    </form>
</div>
@endsection
