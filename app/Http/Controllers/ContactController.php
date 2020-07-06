<?php

namespace App\Http\Controllers;

use App\Contact;
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
            'email.email' => '不是正確的電子信箱',
        ]);

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->status = '1';//未處理
        $contact->save();

        return redirect()->back()->withSuccessMessage('已成功寄送您的訊息，請等待客服人員的回覆，並留意您的信箱');
    }
    
}
