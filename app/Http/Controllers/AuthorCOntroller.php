<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AuthorCOntroller extends Controller
{
    public function profile($username)
    {
        
       $author = User::where('username', $username)->first();
       $posts = $author->posts()->approved()->published()->get();
        return view('profile', compact('author','posts'));
    }
}
