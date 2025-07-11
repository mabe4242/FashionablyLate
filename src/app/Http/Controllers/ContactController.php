<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;

class ContactController extends Controller
{
    public function create(){
        $categories = Category::all();

        return view('contacts/create', compact('categories'));
    }
}

     