<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Idea;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class IdeaController extends Controller
{

    public function index(): View
    {
        $ideas = Idea::all(); //DB::table('ideas')->get(); //selet * from ideas
        return view('ideas.index', ['ideas' => $ideas]);  //nombre variable view => variable en controller

    }

    public function create(): View
    {
        return  view('ideas.create_or_edit');
    }

    public function store(Request $request) :RedirectResponse
    {

        $validate =$request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:500',
        ]);

        Idea::create([
            'user_id' => auth()->user()->id, // $request()->user()->id // $validate['user_id'],
            'title' => $validate['title'],
            'description' => $validate['description'],
        ]);

        session()->flash('message' , 'Idea creada correctamente.');

        return redirect()->route('idea.index');

    }

    public function edit(int $id):View
    {
        $editedIdea = Idea::findOrFail($id);
        return view('ideas.create_or_edit')->with('idea_edit', $editedIdea);
    }

    public function update(Request $request, int  $id):RedirectResponse
    {
        $validate =$request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:500',
        ]);

        $editedIdea = Idea::findOrFail($id);
        $editedIdea->update($validate );

        session()->flash('message' , 'Idea actualizada correctamente.');

        return redirect(route('idea.index'));

    }

    public function show(Idea $idea):View
    {

       // $ideaToShow = Idea::findOrFail($id);
        return view('ideas.show')->with('idea' , $idea);

    }

    public function delete(Idea $idea):RedirectResponse
    {
        $idea->delete();

        session()->flash('message' , 'Idea eliminada correctamente.');

        return redirect()->route('idea.index');
    }
}
