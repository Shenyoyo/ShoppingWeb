<?php

namespace App\Http\Controllers;

use App\Contact;
use App\ContactDetail;
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
        $contactDetails = $contact->contactDetail()->paginate(8);
        return view('admin/contact.show',['contact' => $contact, 'contactDetails' => $contactDetails]);
    }
    public function replyContact(Request $request)
    {
        $this->validate($request,[
            'message' => 'required' ,
            'name' => 'required' ,
        ]);
        $contact = Contact::find($request->id); 
        $contactDetail = new ContactDetail();
        $contactDetail ->name = $request->name;
        $contactDetail ->message = $request->message;
        $contactDetail ->role = '2';
        $contact->contactDetail()->save($contactDetail);
        return redirect()->back()->withSuccessMessage(__('shop.Successful reply'));
    }
    public function lockContact($id)
    {
        $contact = Contact::find($id); 
        $contact->status = '3'; 
        $contact->save();
        return redirect()->back()->withSuccessMessage(__('shop.Case closed, stop reply function'));
    }
    public function unlockContact($id)
    {
        $contact = Contact::find($id); 
        $contact->status = '2'; 
        $contact->save();
        return redirect()->back()->withSuccessMessage(__('shop.Has been unlocked, you can use the reply function'));
    }
    public function searchContact(Request $request)
    {
        $query = $request->input('query');
        $contacts = Contact::where('id', 'LIKE', '%'.$query.'%')->paginate(10);
        return view('admin/contact.index', ['contacts' => $contacts]);
    }
    public function orderbyStatus(Request $request)
    {
        $oderbyStatus = $request->input('oderbyStatus');
        $contacts = ($oderbyStatus == '0') ? Contact::orderBy('id', 'desc')->paginate(10) : 
        Contact::where('status',$oderbyStatus)->orderBy('id', 'desc')->paginate(10);
        
        return view('admin/contact.index', ['contacts' => $contacts ,'oderbyStatus' => $oderbyStatus]);
    }

    
}
