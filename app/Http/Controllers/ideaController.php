<?php

namespace App\Http\Controllers;

use App\Models\idea;
use Illuminate\Http\Request;

class ideaController extends Controller
{
    public function show(idea $idea)
    {
        return view('ideas.show', compact('idea'));
    }
    public function store()
    {
        $validated = request()->validate(['content' => 'required|min:5|max:240']);
        $validated['user_id'] = auth()->id();
        $idea = idea::create($validated);
        return redirect()->route('dashboard')->with('success', 'idea created successfully');
    }
    public function destroy($idea)
    {
        $idea = idea::find($idea);
        if ($idea) {
            $idea->delete();
            return redirect()->route('dashboard')->with('success', 'idea deleted successfuly');
        } else {
            return redirect()->back()->with('success', 'idea deleted successfuly');
        }
    }
    public function edit(idea $idea)
    {
        if (auth()->id() !== $idea->user_id) {
            abort(404);
        }
        $editing = true;
        return view('ideas.show', compact('idea', 'editing'));
    }
    public function update(idea $idea)
    {
        if (auth()->id() !== $idea->user_id) {
            abort(404);
        }
        $validated = request()->validate(['content' => 'required|min:5|max:240']);
        $idea->update($validated);
        return redirect()->route('ideas.show', $idea->id)->with('success', "idea updated successfully");
    }
    public function like($idea)
    {
        $idea = Idea::find($idea);
        $like = json_decode($idea->like, true) ?? [];
        if ($idea->user_id != auth()->id()) {
            if (!in_array(auth()->id(), $like)) {
                $like[] = auth()->id();
            } else {
                $like = array_diff($like, [auth()->id()]);
            }
            $idea->like = json_encode($like);
            $idea->update();
        }

        return redirect()->route('dashboard');
    }
}
