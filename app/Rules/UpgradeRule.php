<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Level;
class UpgradeRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $oldLevel = Level::orderBy('level', 'desc')->first();
        return $value > $oldLevel->upgrade;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $oldLevel = Level::orderBy('level', 'desc')->first();
        return '晉級條件要超過'.$oldLevel->name."的累積金額".$oldLevel->upgrade.'以上';
    }
}
