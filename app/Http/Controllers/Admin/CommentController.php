<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function index()
    {
        // Fetch all comments ordered by the newest first
        $comments = DB::table('comments')->orderBy('created_at', 'desc')->get();
        return view('admin.comments.index', compact('comments'));
    }

    public function destroy($id)
    {
        // Find the comment by ID and delete it
        DB::table('comments')->where('id', $id)->delete();
        
        return back()->with('success', 'Comment deleted successfully.');
    }
}