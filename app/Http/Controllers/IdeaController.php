<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Idea;
use Illuminate\Contracts\View\View;

class IdeaController extends Controller
{

    public function index(): View
    {
        $ideas = Idea::all(); //DB::table('ideas')->get(); //selet * from ideas
        return view('ideas.index', ['ideas' => $ideas]);  //nombre variable view => variable en controller

    }

    public function create(): View
    {
        return  view('ideas.create');
    }

    public function store(Request $request)
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

        return redirect()->route('idea.index');

    }
}
