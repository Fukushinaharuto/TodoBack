<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    function index(Request $request) {
        $query = $request->input('query');
        if(!empty($query)){
            $todos = Todo::where('title', 'like', '%' . $query . '%')->get();
        }else{
            $todos = Todo::all();
        }
        

        
        
        return response()->json($todos);
    }

    function store(Request $request) {
        try{
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'due_date' => 'nullable|date',
                'status' => 'boolean',
                'image_url' => 'nullable|string'
            ]);
            $todo = Todo::create($validated);
    
            return response()->json($todo, 201);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
        
    }

    function update(Request $request , $id) {
        $todo = Todo::findOrfail($id);
        $todo->status = $request->input('status');
        $todo->save();
        
        return response()->json(['todo' => $todo]);
    }

    function destroy($id) {
        $todo = Todo::find($id);
        if(!$id){
            return response()->json(['error' => 'Todoがありません'], 404);
        }
        $todo->delete();
        return response()->json(['message' => '削除成功'], 200);

    }

}