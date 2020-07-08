<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\DollorLog;
use App\User;
use Illuminate\Http\Request;

class DollorController extends Controller
{
  
    public function getIndex()
    {
        $startDate = Carbon::now()->toDateString();
        $endDate = Carbon::tomorrow()->toDateString();
        return view('admin/dollor.index',['startDate' => $startDate , 'endDate' => $endDate] );
    }
    public function searchDollor(Request $request)
    {
        
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $user = User::where('name',$request->name)->first();
        if(!empty($request->name)){
            $dollorlogs = DollorLog::whereBetween('created_at',[$startDate, $endDate ])
            ->Where('user_id', $user->id ?? '')
            ->orderBy('id','desc')
            ->paginate(10);
        }else{
            $dollorlogs = DollorLog::whereBetween('created_at',[$startDate, $endDate ])
            ->orderBy('id','desc')
            ->paginate(10);
        }
       
        return view('admin/dollor.index', [
            'dollorlogs' => $dollorlogs,
            'startDate' => $startDate ,
            'endDate' => $endDate
            ]);
    } 
}
