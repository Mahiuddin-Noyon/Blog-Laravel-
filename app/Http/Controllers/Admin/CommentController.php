<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::latest()->get();
        return view('admin.comments', compact('comments'));
    }
    
    public function destroy($id)
    {
       $comment = Comment::findOrFail($id)->delete();
       Toastr::success('Comment has been successfully deleted','Success');
       return redirect()->back();

    }
}
