<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Idea;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class IdeaController extends Controller
{

    private array $validateRules = [
        'title' => 'required|string|max:100',
        'description' => 'required|string|max:300',
    ];


    private array $errorMessages = [
        'title.required' => 'El campo título es obligatorio',
        'description.required' => 'El campo descripción es obligatorio',
        'string' => 'Solo se aceptan :atribute',
        'title.max' => 'El campo título  no acepta más de :max caracteres.',
        'description.max' => 'El campo  descripción no acepta más de :max caracteres.',

    ];


    public function index(Request $request): View
    {
        $ideas = Idea::myIdeas($request->filtro)->theBests($request->filtro)->get(); //DB::table('ideas')->get(); //selet * from ideas
        return view('ideas.index', ['ideas' => $ideas]);  //nombre variable view => variable en controller

    }


    public function create(): View
    {
        return  view('ideas.create_or_edit');
    }


    // crea una idea
    public function store(Request $request) :RedirectResponse
    {

        $validate =$request->validate(
            $this->validateRules,
            $this->errorMessages
        );

        Idea::create([
            'user_id' => auth()->user()->id, // $request()->user()->id // $validate['user_id'],
            'title' => $validate['title'],
            'description' => $validate['description'],
        ]);

        session()->flash('message' , 'Idea creada correctamente.');

        return redirect()->route('idea.index');

    }


    // solo muestra los datos guardados para modificar
    public function edit(Idea $idea):View
    {
        $this->authorize('update' , $idea);
        //$editedIdea = Idea::findOrFail($idea);
        return view('ideas.create_or_edit')->with('idea_edit', $idea);
    }


    // actualiza idea en base de datos
    public function update(Request $request, Idea  $idea): RedirectResponse
    {
        $this->authorize('update', $idea);

        $validate =$request->validate(
            $this->validateRules ,
            $this-> errorMessages
        );

        //$editedIdea = Idea::findOrFail($idea->id);
        $idea->update($validate );

        session()->flash('message' , 'Idea actualizada correctamente.');

        return redirect()->route('idea.index');

    }



    public function show(Idea $idea):View
    {

       // $ideaToShow = Idea::findOrFail($id);
        return view('ideas.show')->with('idea' , $idea);

    }



    public function delete(Idea $idea):RedirectResponse
    {
        $this->authorize('delete' , $idea);

        $idea->delete();

        session()->flash('message' , 'Idea eliminada correctamente.');

        return redirect()->route('idea.index');
    }



    public function synchronizeLikes(Request $request, Idea $idea)
    {
        $request->user()->ideasLiked()->toggle([$idea->id]); //obtengo del request el dato del user logueado y
                                                            //tomo del Modelo User la function ideas Liked de many-to many
                                                            //toogle() funcion de laravel para tablas pivote(many-to many)
        //$idea->users()->toggle([$request->user()->id]); otra forma de hacer lo mismo que el anterior

        $likesQuantity =  $idea->users()->count(); //llamo al objeto idea, llamo a su método   users() y  llamo a count() para contar cuantos usuarios le dieron like a esa idea

        $idea->update(['likes'=> $likesQuantity]); //actuaiza la pagina index

        return redirect()->route('idea.show' , $idea);
    }
}

