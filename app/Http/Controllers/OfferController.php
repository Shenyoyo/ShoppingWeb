<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Level;
class OfferController extends Controller
{
    public function getIndex()
    {   
        return view('admin/offer.index');
    }
    public function newOffer()
    {
        $levels = Level::all();
        return view('admin/offer.new', ['levels' => $levels]);
    }
    public function editOffer($id)
    {
        $level = Level::find($id);
        return view('admin/level.edit', ['level' => $level]);
    }
    public function updateOffer(Request $request)
    {
        $this->validate($request, [
            'upgrade' => ['required',new UpgradeEditRule($request->input('level'))],
        ]);
        $level = Level::find($request->input('id'));
        $level->description = $request->input('description');
        $level->upgrade = $request->input('upgrade');
        $level->save();

        return redirect()->route('level.index');
    }

    public function addOffer(Request $request)
    {
        $this->validate($request, [
            'upgrade' => ['required',new UpgradeRule],
        ]);
    
        $levels = new Level();
        $levels->name = $request->input('name');
        $levels->description = $request->input('description');
        $levels->level = $request->input('level');
        $levels->upgrade = $request->input('upgrade');
        $levels->save();

        return redirect()->route('level.index');
    }
    public function destroyOffer($id)
    {
        Level::destroy($id);
        return redirect()->route('level.index');
    }
    public function searchOffer(Request $request)
    {
        $query = $request->input('query');
        $levels = Level::where('name', 'LIKE', '%'.$query.'%')->get();
        $highestLevel = Level::orderBy('level', 'desc')->first();

        return view('admin/level.index',['levels' => $levels,'highestLevel' =>$highestLevel]);
    }
}
