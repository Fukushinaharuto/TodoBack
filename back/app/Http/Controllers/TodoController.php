<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    function index(Request $request) {
        $user = Auth::user(); 
        $query = $request->input('query');
        if(!empty($query)){
            $todos = $user->todos()->where('title', 'like', '%' . $query . '%')->get();
        }else{
            $todos = $user->todos()->get();
        }
        

        
        
        return response()->json($todos);
    }

    function store(Request $request) {
        $user = Auth::user();
        try{
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'due_date' => 'nullable|date',
                'status' => 'boolean',
            ]);
            $todo = $user->todos()->create($validated);
    
            return response()->json($todo, 201);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
        
    }

    function update(Request $request , $id) {
        $todo = Todo::findOrfail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'due_date' => 'nullable|date',
        ]);
        $todo->fill($validated);
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

    function toggleStatus(Request $request, $id) {
        $todo = Todo::findOrFail($id);
        $todo->status = $request->input('status');
        $todo->save();
    
        return response()->json(['todo' => $todo]);
    }

}
