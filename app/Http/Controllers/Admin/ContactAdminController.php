<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;

class ContactAdminController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')->paginate(20);
        $unread   = ContactMessage::where('is_read', false)->count();
        return view('admin.contacts.index', compact('messages', 'unread'));
    }

    public function show($id)
    {
        $message = ContactMessage::findOrFail($id);
        if (!$message->is_read) {
            $message->is_read = true;
            $message->save();
        }
        return view('admin.contacts.show', compact('message'));
    }

    public function destroy($id)
    {
        ContactMessage::findOrFail($id)->delete();
        return redirect()->route('admin.contacts.index')
            ->with('success', 'Message deleted.');
    }
}
