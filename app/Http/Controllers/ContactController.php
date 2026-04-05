<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessageMail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function showContactForm()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        // Save the contact message
        $contactMessage = ContactMessage::create($validatedData);

        // Get admin email from config or use default
        $adminEmail = config('mail.from.address', 'admin@example.com');

        try {
            // Send email notification to admin
            Mail::to($adminEmail)->send(new ContactMessageMail($contactMessage));
        } catch (\Exception $e) {
            Log::error('Failed to send contact message email: ' . $e->getMessage());
            // Don't fail the request if email fails
        }

        // Handle AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you for your message. We will get back to you soon!'
            ]);
        }

        return back()->with('success', 'Thank you for your message. We will get back to you soon!');
    }
}
