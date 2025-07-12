<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;
use App\Http\Requests\ContactRequest;
use App\Services\CheckFormService;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
        $contacts = Contact::with('category')->paginate(7);
        foreach ($contacts as $contact){
            $contact['name'] = CheckFormService::makeFullName($contact['first_name'], $contact['last_name']);
            $contact['gender_type'] = CheckFormService::checkGender((int)$contact['gender']);
        }
        $categories = Category::all();

        return view('contacts/index', compact('contacts', 'categories'));
    }

    public function destroy(Request $request){
        Contact::find($request->id)->delete();
        return redirect('/admin')->with('message', 'お問合せを削除しました');
    }

    protected function getFilteredContacts(Request $request)
    {
        $keyword = $request->keyword;
        $normalizedKeyword = preg_replace('/\s+/u', '', $keyword);
        $contacts =  Contact::with('category')
                    ->GenderSearch($request->gender)
                    ->CategorySearch($request->category_id)
                    ->DateSearch($request->created_at)
                    ->KeywordSearch($normalizedKeyword);

        return $contacts;
    }

    public function search(Request $request)
    {
        $query = $this->getFilteredContacts($request);
        $contacts = $query->paginate(7)->appends($request->all());
        foreach ($contacts as $contact) {
            $contact['name'] = CheckFormService::makeFullName($contact['first_name'], $contact['last_name']);
            $contact['gender_type'] = CheckFormService::checkGender((int)$contact['gender']);
        }
        $categories = Category::all();

        return view('contacts/index', compact('contacts', 'categories'));
    }

    public function export(Request $request){
        $contacts = $this->getFilteredContacts($request)->get();
        foreach ($contacts as $contact) {
            $contact['name'] = CheckFormService::makeFullName($contact['first_name'], $contact['last_name']);
            $contact['gender_type'] = CheckFormService::checkGender((int)$contact['gender']);
        }
        $response = new StreamedResponse(function () use ($contacts) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', '名前', '性別', 'メールアドレス', 'お問い合わせの種類', 
            '電話番号', '住所', '建物名', 'お問い合わせ内容', '日付']);
            foreach ($contacts as $contact) {
                fputcsv($handle, [
                    $contact->id,
                    CheckFormService::makeFullName($contact->first_name, $contact->last_name),
                    CheckFormService::checkGender($contact->gender),
                    $contact->email,
                    $contact->category->content,
                    $contact->tel,
                    $contact->address,
                    $contact->building,
                    $contact->detail,
                    $contact->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($handle);
        });

        $filename = 'contacts_' . now()->format('Ymd_His') . '.csv';
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename=\"$filename\"");

        return $response;
    }
}