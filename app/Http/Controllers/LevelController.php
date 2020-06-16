<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Level;
use App\Rules\UpgradeRule;

class LevelController extends Controller
{
    public function getIndex()
    {
        $levels = Level::all();
        return view('admin/level.index', ['levels' =>$levels]);
    }
    public function newlevel()
    {
        $level = Level::orderBy('level', 'desc')->first();
        return view('admin/level.new', ['level' => $level]);
    }

    public function addlevel(Request $request)
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
}
