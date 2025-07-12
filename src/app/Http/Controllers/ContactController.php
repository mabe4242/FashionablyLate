<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;
use App\Http\Requests\ContactRequest;
//use App\Services\CheckFormService;

class ContactController extends Controller
{
    public function create(){
        $categories = Category::all();

        return view('contacts/create', compact('categories'));
    }

    public function confirm(ContactRequest $request){
        $keys = ['first_name', 'last_name', 'gender', 'email', 'tel1',
            'tel2', 'tel3', 'address', 'building', 'category_id', 'detail'];
        $contact = $request->only($keys);
        $contact['name'] = \App\Services\CheckFormService::makeFullName($request->first_name, $request->last_name);
        $contact['tel']  = $request->tel1.$request->tel2.$request->tel3;
        $contact['gender_type'] = \App\Services\CheckFormService::checkGender((int)$request->gender);
        $category = Category::find($request->category_id);

        return view('contacts/confirm', compact('contact', 'category'));
    }
}

     