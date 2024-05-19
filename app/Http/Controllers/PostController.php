<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user', 'comments.user')->get();
        return view('index', ['title' => 'Home', 'posts' => $posts]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,mp4,mov,ogg,qt|max:200000',
        ]);

        $post = new Post();
        $post->content = $request->content;
        $post->user_id = Auth::id();

        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $path = $file->store('media', 'public');
            $post->media_path = $path;
            $post->media_type = $file->getClientOriginalExtension() == 'mp4' || $file->getClientOriginalExtension() == 'mov' ? 'video' : 'image';
        }

        $post->save();

        return redirect()->route('index')->with('success', 'Post created successfully!');
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        if (Auth::check() && Auth::user()->id == $post->user_id) {
            if ($post->media_path) {
                Storage::disk('public')->delete($post->media_path);
            }
            $post->delete();
            return redirect()->route('index')->with('success', 'Post deleted successfully.');
        }

        return redirect()->route('index')->with('error', 'You are not authorized to delete this post.');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        if (Auth::check() && Auth::user()->id == $post->user_id) {
            $title = 'Edit Post';
            return view('posts.edit', compact('post', 'title'));
        }

        return redirect()->route('index')->with('error', 'You are not authorized to edit this post.');
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if (Auth::check() && Auth::user()->id == $post->user_id) {
            $post->content = $request->input('content');
            if ($request->hasFile('media')) {
                $file = $request->file('media');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/media', $filename);
                $post->media_path = 'media/' . $filename;
                $post->media_type = $file->getClientOriginalExtension();
            }
            $post->save();

            return redirect()->route('index')->with('success', 'Post updated successfully.');
        }

        return redirect()->route('index')->with('error', 'You are not authorized to update this post.');
    }
}
