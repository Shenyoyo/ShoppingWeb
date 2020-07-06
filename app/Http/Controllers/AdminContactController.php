<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;

class AdminContactController extends Controller
{
    public function getIndex()
    {
        $contacts = Contact::orderBy('id','dsec')->paginate(10); 
        return view('admin/contact.index',['contacts' => $contacts]);
    }
    public function showContact($id)
    {
        $contact = Contact::find($id); 
        if($contact->status != '3'){
            $contact->status = '2';
            $contact->save();
        }
        return view('admin/contact.show',['contact' => $contact]);
    }
    public function replyContact(Request $request)
    {
        $contact = Contact::find($request->id); 
        $contact->response = $request->response;
        $contact->status = '3';
        $contact->save();
        return redirect()->back()->withSuccessMessage('已紀錄處理方式。');
    }

    
}
