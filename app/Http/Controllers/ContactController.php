<?php

namespace App\Http\Controllers;

use App\Contact;
use App\ContactDetail;
use Auth;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function getIndex(){
        $user = Auth::user(); 
        return view('contact.index',['user' => $user]);
    }
    public function sendMessage(Request $request){
        $this->validate($request,[
            'email' => 'email',
        ], [
            'email.email' => __('shop.emailvalidation'),
        ]);

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->status = '1';//未處理
        $contact->save();
        $contactDetail = new ContactDetail();
        $contactDetail->name = $request->name;
        $contactDetail->message = $request->message;
        $contactDetail->role = '1';
        $contact->contactDetail()->save($contactDetail);

        return redirect()->back()->withSuccessMessage(__('shop.applycontact'));
    }
    
}
