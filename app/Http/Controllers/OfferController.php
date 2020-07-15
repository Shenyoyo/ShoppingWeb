<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Level;
use App\Offer;
use App\Discount;
use App\Cashback;
use App\Rebate;

class OfferController extends Controller
{
    public function getIndex()
    {
        $offers = Offer::paginate(10);
        return view('admin/offer.index', ['offers' => $offers]);
    }
    public function newOffer()
    {
        $offers = Offer::all();
        if (count($offers) > 0 ) {
            foreach ($offers as $offer) {
                $offerLevel[]= $offer->level_level;
            }
            //過濾已經建立的VIP等級
            $levels = Level::whereNotIn('level', $offerLevel)->get();
        } else {
            $levels = Level::all();
        }
        
        if(count($levels) != 0){
            return view('admin/offer.new', ['levels' => $levels]);
        }else{
            return redirect()->back()->withErrors('未有等級可以設定，請自會員等級管理新增等級')->withInput(); 
        }
         
        
    }
    public function editOffer($id)
    {
        $offer = Offer::find($id);
        return view('admin/offer.edit', ['offer' => $offer]);
    }
    public function updateOffer(Request $request)
    {
        $offer = Offer::find($request->input('id'));
        if (!empty($request->input('optimun_yn'))) {
            $offer->optimun_yn = $request->input('optimun_yn');
        } else {
            $offer->optimun_yn = 'N';
        }
        if (!empty($request->input('discount_yn'))) {
            $offer->discount_yn = $request->input('discount_yn');
            $offer->discount->above = $request->input('discount_above');
            $offer->discount->percent = saveDiscount($request->input('discount_percent'))/100;
            $offer->discount->save();
        } else {
            $offer->discount_yn = 'N';
        }
        if (!empty($request->input('cashback_yn'))) {
            $offer->cashback_yn = $request->input('cashback_yn');
            $offer->cashback->above = $request->input('cashback_above');
            $offer->cashback->percent = $request->input('cashback_percent')/100;
            $offer->cashback->save();
        } else {
            $offer->cashback_yn = 'N';
        }
        if (!empty($request->input('rebate_yn'))) {
            $offer->rebate_yn = $request->input('rebate_yn');
            $offer->rebate->above = $request->input('rebate_above');
            $offer->rebate->rebate = $request->input('rebate_rebate');
            $offer->rebate->save();
        } else {
            $offer->rebate_yn = 'N';
        }
        $offer->save();
        return redirect()->route('offer.index');
    }

    public function addOffer(Request $request)
    {
        $offer = new Offer();
        $offer->level_level = $request->input('level');
        if (!empty($request->input('optimun_yn'))) {
            $offer->optimun_yn = $request->input('optimun_yn');
        } else {
            $offer->optimun_yn = 'N';
        }
        if (!empty($request->input('discount_yn'))) {
            $offer->discount_yn = $request->input('discount_yn');
        } else {
            $offer->discount_yn = 'N';
        }
        if (!empty($request->input('cashback_yn'))) {
            $offer->cashback_yn = $request->input('cashback_yn');
        } else {
            $offer->cashback_yn = 'N';
        }
        if (!empty($request->input('rebate_yn'))) {
            $offer->rebate_yn = $request->input('rebate_yn');
        } else {
            $offer->rebate_yn = 'N';
        }

        $offer->save();

        if ($offer->discount_yn == 'Y') {
            $discount = new Discount();
            $discount->offer_id = $offer->id;
            $discount->above = $request->input('discount_above');
            $discount->percent = saveDiscount($request->input('discount_percent'))/100;
            $discount->save();
        } else {
            $discount = new Discount();
            $discount->offer_id = $offer->id;
            $discount->above = $request->input('discount_above');
            $discount->percent = $request->input('discount_percent');
            $discount->save();
        }

        if ($offer->cashback_yn == 'Y') {
            $cashback = new Cashback();
            $cashback->offer_id = $offer->id;
            $cashback->above = $request->input('cashback_above');
            $cashback->percent = $request->input('cashback_percent')/100;
            $cashback->save();
        } else {
            $cashback = new Cashback();
            $cashback->offer_id = $offer->id;
            $cashback->above = $request->input('cashback_above');
            $cashback->percent = $request->input('cashback_percent');
            $cashback->save();
        }

        if ($offer->rebate_yn == 'Y') {
            $rebate = new Rebate();
            $rebate->offer_id = $offer->id;
            $rebate->above = $request->input('rebate_above');
            $rebate->rebate = $request->input('rebate_rebate');
            $rebate->save();
        } else {
            $rebate = new Rebate();
            $rebate->offer_id = $offer->id;
            $rebate->above = $request->input('rebate_above');
            $rebate->rebate = $request->input('rebate_rebate');
            $rebate->save();
        }

        return redirect()->route('offer.index');
    }
    public function destroyOffer($id)
    {
        
        Offer::find($id)->discount->delete();
        Offer::find($id)->cashback->delete();
        Offer::destroy($id);

        return redirect()->route('offer.index');
    }
    public function searchOffer(Request $request)
    {
        $query = $request->input('query');
        $offers = Offer::where('id', 'LIKE', '%'.$query.'%')->paginate(10);
        return view('admin/offer.index', ['offers' => $offers]);
    }
}
