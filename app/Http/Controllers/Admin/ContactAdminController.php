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
    public function reply(\Illuminate\Http\Request $request, $id)
    {
        $request->validate([
            'reply_message' => 'required|string|max:2000',
        ]);

        $message = ContactMessage::findOrFail($id);

        \App\Helpers\BrevoMail::send(
            $message->email,
            $message->name,
            'Re: ' . $message->subject . ' — Tunara Support',
            view('emails.admin-reply', [
                'userName'        => $message->name,
                'replyMessage'    => $request->reply_message,
                'originalSubject' => $message->subject,
            ])->render()
        );


        $replies = $message->replies ?? [];
        $replies[] = [
            'message'    => $request->reply_message,
            'sent_at'    => now()->format('d M Y, h:i A'),
            'sent_by'    => 'Admin',
        ];
        $message->replies = $replies;
        $message->save();

        return back()->with('reply_sent', 'Reply sent to ' . $message->email);
    }

    public function destroy($id)
    {
        ContactMessage::findOrFail($id)->delete();
        return redirect()->route('admin.contacts.index')
            ->with('success', 'Message deleted.');
    }
}
