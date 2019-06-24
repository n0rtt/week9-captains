<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Assignment;
use App\Captain;

class CaptainController extends Controller
{
    //
    public function index()
    {
        $captains = Hero::orderBy('name' , 'asc')->get();

        return view('/captain/index', compact('captains'));
    }

    public function create()
    {
        $assignment = new Assignment;
        
        return redirect()->route('start');
    }

    public function store(Request $request, $id)
    {
        $assignment = new Emergency;

        $captain = Captain::findOrFail($id);
        $assignment->fill($request->only([
            'subject', 
            'description'
        ]));

        $assignment->captain_id = $captain->id;
        $assignment->save();
        session()->flash('success_message', 'Success!');

        return redirect()->route('emergency.create' , ['captain_slug' => $captain->name]);
    }


    public function show($captain_slug)
    {
        $captain = \App\Captain::where('slug', $captain_slug)->first();

        if (!$captain) {
            abort(404, 'Captain not found');
        }

        $view = view('captain/show');

        $view->captain = $captain;

        return $view;
    }
}
