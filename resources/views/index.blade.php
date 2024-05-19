@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-5">Ujian Social Media</h1>

    <div class="mb-4">
        <h3>Create a New Post</h3>
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="content">Content</label>
                <textarea id="content" name="content" class="form-control" required></textarea>
            </div>
            <div class="form-group mt-3">
                <label for="media">Upload Media (Image/Video)</label>
                <input type="file" id="media" name="media" class="form-control-file">
            </div>
            <button type="submit" class="btn btn-primary mt-3">Post</button>
        </form>
    </div>

    <div class="posts">
        @foreach($posts as $post)
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title m-0">{{ $post->user->name }}</h5>
                    <div class="d-flex">
                        @if(Auth::check() && Auth::user()->id == $post->user_id)
                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning btn-sm" style="margin-right: 15px;">Edit</a>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDeletePost(this);">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                        @endif
                    </div>
                </div>

                @if($post->media_path)
                    @if($post->media_type == 'image')
                        <img src="{{ asset('storage/' . $post->media_path) }}" alt="Post Image" class="img-fluid post-media">
                    @elseif($post->media_type == 'video')
                        <video controls class="img-fluid post-media mb-3">
                            <source src="{{ asset('storage/' . $post->media_path) }}" type="video/{{ pathinfo($post->media_path, PATHINFO_EXTENSION) }}">
                        </video>
                    @endif
                @endif
                <p class="card-text">{{ $post->content }}</p>
                <div class="comments mt-4">
                    <h6>Comments</h6>
                    @foreach($post->comments as $comment)
                    <div class="comment mb-2 p-2 rounded bg-light">
                        <strong>{{ $comment->user->name }}:</strong>
                        <p class="m-0">{{ $comment->content }}</p>
                        @if(Auth::check() && Auth::user()->id == $comment->user_id)
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-warning btn-sm mr-2">Edit</a>
                        </div>
                        @endif
                    </div>
                    @endforeach

                    <form action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <div class="form-group">
                            <textarea name="content" class="form-control" rows="2" placeholder="Add a comment" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-secondary btn-sm mt-2">Comment</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    function confirmDeletePost(form) {
        return confirm('Are you sure you want to delete this post?');
    }
</script>

@endsection
