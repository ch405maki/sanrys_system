<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DocumentController extends Controller
{

    public function index()
    {
        $users = User::with(['profile', 'documents'])->get();

        // Pass the users to the Inertia view
        return Inertia::render('Documents/Index', [
            'users' => $users,
        ]);
    }

    public function mydoc()
    {
        $user = Auth::user()->load(['profile', 'documents']);
    
        // Pass the user to the Inertia view
        return Inertia::render('Documents/MyDocs', [
            'user' => $user,
        ]);
    }

    public function show(User $user)
    {
        $user->load(['profile', 'documents']);

        return Inertia::render('Documents/MyDocs', [
            'user' => $user,
        ]);
    }

    public function upload(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'document_name' => 'required|string|max:255', // Add validation for document name
            'description' => 'nullable|string|max:1000',  // Add validation for description
            'document_type' => 'required|string|max:255',
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // Max 2MB
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Store the document in the public disk
        $documentPath = $request->file('document')->store('documents', 'public');

        // Create the document record
        $document = Document::create([
            'user_id' => $request->user_id,
            'document_name' => $request->document_name, // Add this
            'description' => $request->description,     // Add this
            'document_type' => $request->document_type,
            'document_path' => $documentPath, // Store the relative path
            'status' => 'pending', // Default status
        ]);

        return response()->json([
            'message' => 'Document uploaded successfully!',
            'document' => $document,
        ], 201);
    }

    public function destroy($id)
    {
        // Find the document by ID
        $document = Document::find($id);

        // If the document doesn't exist, return a 404 error
        if (!$document) {
            return response()->json(['message' => 'Document not found'], 404);
        }

        // Delete the document
        $document->delete();

        // Return a success response
        return response()->json(['message' => 'Document deleted successfully']);
    }
}
