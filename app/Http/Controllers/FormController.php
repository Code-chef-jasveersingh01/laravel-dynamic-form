<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class FormController extends Controller
{

    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'structure' => 'required|json',
        ]);

        // Create a new form entry in the database
        $form = Form::create([
            'name' => $request->input('name'),
            'structure' => json_decode($request->input('structure'), true),
        ]);

        // Return a JSON response indicating success
        return response()->json([
            'success' => true,
            'form_id' => $form->id,
            'message' => 'Form saved successfully!'
        ]);
    }
    public function show($id)
    {
        $form = Form::findOrFail($id);

        // Pass the form structure to the view
        return view('show', [
            'formName' => $form->name,
            'formStructure' => $form->structure,
        ]);
    }
}
