<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UpgradeEditRule;
use Illuminate\Support\Facades\Session;
class LevelUpdateRequest extends FormRequest
{
    public function __construct()
    {
        //從Session取的當前Level
        $this->level = Session::get('level');
    }
    public $level;
   
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // dd($this->level);
        return [
            'upgrade' => ['required',new UpgradeEditRule($this->level)],
        ];
    }
}
