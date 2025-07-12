<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;
use App\Http\Requests\ContactRequest;
use App\Services\CheckFormService;

class ContactController extends Controller
{
    public function create(Request $request){
        $contact = $request->session()->get('form_input', []);
        $categories = Category::all();

        return view('contacts/create', compact('contact', 'categories'));
    }

    public function confirm(ContactRequest $request){
        $keys = ['first_name', 'last_name', 'gender', 'email', 'tel1',
          'tel2', 'tel3', 'address', 'building', 'category_id', 'detail'];
        $contact = $request->only($keys);
        $request->session()->put('form_input', $contact);
        $contact['name'] = CheckFormService::makeFullName($request->first_name, $request->last_name);
        $contact['tel']  = $request->tel1.$request->tel2.$request->tel3;
        $contact['gender_type'] = CheckFormService::checkGender((int)$request->gender);
        $category = Category::find($request->category_id);

        return view('contacts/confirm', compact('contact', 'category'));
    }

    public function back(Request $request){
        $contact = $request->session()->get('form_input');
        return redirect()->route('contacts.create')->withInput($contact);
    }

    public function store(ContactRequest $request){
        $contact = $request->only(['category_id', 'first_name', 'last_name', 
        'gender', 'email', 'tel', 'address', 'building', 'detail']);
        Contact::create($contact);
        $request->session()->forget('form_input');

        return view('contacts/thanks');
    }

    public function index(){
        $contacts = Contact::all();//リレーションはまだ
        foreach ($contacts as $contact){
            $contact['name'] = CheckFormService::makeFullName($contact['first_name'], $contact['last_name']);
            $contact['gender_type'] = CheckFormService::checkGender((int)$contact['gender']);
        }
        $categories = Category::all();

        return view('contacts/index', compact('contacts', 'categories'));
    }
}