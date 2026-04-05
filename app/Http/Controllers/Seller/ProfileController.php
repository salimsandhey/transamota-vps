<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function showDocuments()
    {
        return view('seller.profile.documents');
    }
    
    public function uploadDocument(Request $request)
    {
        $request->validate([
            'document_type' => 'required|string|max:255',
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240', // 10MB max
        ]);
        
        $user = Auth::user();
        
        // Store the document
        $path = $request->file('document')->store('seller-documents', 'public');
        
        // Update user profile with document path and type
        $user->profile->update([
            'verification_doc' => $path,
            'verification_doc_type' => $request->document_type,
            'verified_by_admin' => false, // Reset verification status when new document is uploaded
        ]);
        
        return redirect()->back()->with('success', 'Document uploaded successfully. Please wait for admin verification.');
    }
    
    public function deleteDocument()
    {
        $user = Auth::user();
        
        // Delete the document file if it exists
        if ($user->profile->verification_doc) {
            Storage::disk('public')->delete($user->profile->verification_doc);
        }
        
        // Update user profile
        $user->profile->update([
            'verification_doc' => null,
            'verification_doc_type' => null,
            'verified_by_admin' => false,
        ]);
        
        return redirect()->back()->with('success', 'Document deleted successfully.');
    }
}