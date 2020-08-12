<?php

namespace App\Http\Controllers;

use App\Http\Requests\LevelRequest;
use Illuminate\Http\Request;
use App\Level;
use App\Rules\UpgradeRule;
use App\Rules\UpgradeEditRule;

class LevelController extends Controller
{
    public function getIndex()
    {
        $levels = Level::paginate(10);
        $highestLevel = Level::orderBy('level', 'desc')->first();
        return view('admin/level.index', ['levels' =>$levels], ['highestLevel' => $highestLevel] );
    }
    public function newLevel()
    {
        $level = Level::orderBy('level', 'desc')->first();
        return view('admin/level.new', ['level' => $level]);
    }
    public function editlevel($id)
    {
        $level = Level::find($id);
        return view('admin/level.edit', ['level' => $level]);
    }
    public function updateLevel(Request $request)
    {
        $this->validate($request, [
            'upgrade' => ['required',new UpgradeEditRule($request->input('level'))],
        ]);
        $level = Level::find($request->input('level'));
        $level->description = $request->input('description');
        $level->upgrade = $request->input('upgrade');
        $level->save();

        return redirect()->route('level.index');
    }

    public function addLevel(LevelRequest $request)
    {
        // $this->validate($request, [
        //     'upgrade' => ['required',new UpgradeRule],
        // ]);
    
        $levels = new Level();
        $levels->name = $request->input('name');
        $levels->description = $request->input('description');
        $levels->level = $request->input('level');
        $levels->upgrade = $request->input('upgrade');
        $levels->save();

        return redirect()->route('level.index');
    }
    public function destroyLevel($id)
    {
        Level::destroy($id);
        return redirect()->route('level.index');
    }
    public function searchLevel(Request $request)
    {
        $query = $request->input('query');
        $levels = Level::where('name', 'LIKE', '%'.$query.'%')->paginate(10);
        $highestLevel = Level::orderBy('level', 'desc')->first();

        return view('admin/level.index',['levels' => $levels,'highestLevel' =>$highestLevel]);
    }
}
