<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 

     public function index()
    {
        //
        $todos=Todo::all();
        return view('todo',compact('todos'));
    }

    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if ($validator->fails())
        {
            return redirect()->route('todos.index')->withErrors($validator);
        }

        Todo::create([
            'title'=>$request->get('title')
        ]);

               return redirect()->route('todos.index')->with('success', 'Inserted');

    }

    public function edit($id)
    {
        //

        $todo=Todo::where('id',$id)->first();
        return view('edit-todo',compact('todo'));
    }
    public function update(Request $request, $id)
    {


        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if ($validator->fails())
        {
            return redirect()->route('todos.edit',['todo'=>$id])->withErrors($validator);
        }



        $todo=Todo::where('id',$id)->first();
        $todo->title=$request->get('title');
        $todo->is_completed=$request->get('is_completed');
        $todo->save();

        return redirect()->route('todos.index')->with('success', 'Updated Todo');

    }
    public function destroy($id)
    {
        Todo::where('id',$id)->delete();
        return redirect()->route('todos.index')->with('success', 'Deleted Todo');
    }
}
