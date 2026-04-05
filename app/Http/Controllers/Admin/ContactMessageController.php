<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactMessage;

class ContactMessageController extends Controller
{
    public function index()
    {
        $contactMessages = ContactMessage::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.contact-messages.index', compact('contactMessages'));
    }

    public function show(ContactMessage $contactMessage)
    {
        // Mark as read when viewed
        if (!$contactMessage->is_read) {
            $contactMessage->update(['is_read' => true]);
        }
        
        return view('admin.contact-messages.show', compact('contactMessage'));
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();
        return redirect()->route('admin.contact-messages.index')->with('success', 'Message deleted successfully.');
    }
}
