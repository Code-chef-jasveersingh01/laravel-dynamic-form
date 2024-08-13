<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\DataTables\FormsDataTable;

class FormController extends Controller
{

    public function index(FormsDataTable $dataTable)
    {
        return $dataTable->render('form.index');
    }

    public function create()
    {
       return view('form.create');
    }

    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'method' => 'required',
            'action' => 'required',
            'structure' => 'required|json',
        ]);

        // Create a new form entry in the database
        $form = Form::create([
            'name' => $request->input('name'),
            'method' => $request->input('method'),
            'action' => $request->input('action'),
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
        return view('form.show', [
            'formName' => $form->name,
            'formMethod' => $form->method,
            'formAction' => $form->action,
            'formStructure' => $form->structure,
        ]);
    }

    public function edit($id)
    {
        $form = Form::findOrFail($id);
        return view('forms.edit', compact('form'));
    }

    // Update a specific form
    public function update(Request $request, $id)
    {
        $form = Form::findOrFail($id);
        $form->update($request->all());
        return redirect()->route('form.show', ['id' => $id])->with('success', 'Form updated successfully.');
    }

    // Delete a specific form
    public function destroy($id)
    {
        $form = Form::findOrFail($id);
        $form->delete();
        return redirect()->route('form.index')->with('success', 'Form deleted successfully.');
    }
}
