<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\ContactMessage;

class ContactMessageController extends Controller {
    public function index() { $messages = ContactMessage::latest()->paginate(20); return view("admin.messages.index", compact("messages")); }
    public function destroy(ContactMessage $message) { $message->forceDelete(); return back()->with("success", "Message deleted."); }
}