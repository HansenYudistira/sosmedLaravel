<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string',
        ]);

        $comment = new Comment();
        $comment->post_id = $request->post_id;
        $comment->user_id = Auth::id();
        $comment->content = $request->content;
        $comment->save();

        return redirect()->route('index')->with('success', 'Comment added successfully!');
    }

    public function edit($id)
    {
        $comment = Comment::findOrFail($id);

        if (Auth::check() && Auth::user()->id == $comment->user_id) {
            $title = 'Edit Comment';
            return view('comments.edit', compact('title', 'comment'));
        }

        return redirect()->route('index')->with('error', 'You are not authorized to edit this comment.');
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        if (Auth::check() && Auth::user()->id == $comment->user_id) {
            $comment->content = $request->input('content');
            $comment->save();

            return redirect()->route('index')->with('success', 'Comment updated successfully.');
        }

        return redirect()->route('index')->with('error', 'You are not authorized to update this comment.');
    }
}
