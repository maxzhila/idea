<?php

namespace App\Http\Controllers;

use App\Models\idea;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(idea $idea)
    {
        $comment = new Comment;
        $comment->idea_id = $idea->id;
        $comment->user_id = auth()->id();
        $comment->content = request()->get('content');
        $comment->save();
        return redirect()->route('ideas.show', $idea->id)->with('success', 'comment posted successfully');
    }
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted');
    }
}
