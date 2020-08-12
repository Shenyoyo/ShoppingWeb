<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Level;


class UpgradeEditRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($param)
    {
        $this->level = $param;
    }

    public $level;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $beforeLevel = Level::where('level', $this->level-1)->first();
        $afterLevel  = Level::where('level', $this->level+1)->first();
        if (empty($beforeLevel)) {
            if ($value < $afterLevel->upgrade) {
                $flag=true;
            } else {
                $flag=false;
            }
        } elseif (empty($afterLevel)) {
            if ($value > $beforeLevel->upgrade) {
                $flag=true;
            } else {
                $flag=false;
            }
        } else {
            if ($value > $beforeLevel->upgrade && $value < $afterLevel->upgrade) {
                $flag=true;
            } else {
                $flag=false;
            }
        }
        return $flag;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $beforeLevel = Level::where('level', $this->level-1)->first();
        $afterLevel  = Level::where('level', $this->level+1)->first();
        if (empty($beforeLevel)){
            // $message = '累積金額請 低於'.$afterLevel->name.'的$'.$afterLevel->upgrade;
            $message = __('shop.higher than',['level' => $afterLevel->name,'upgrade' => $afterLevel->upgrade]);

        }elseif(empty($afterLevel)) {
            $message = __('shop.higher than',['level' => $beforeLevel ->name,'upgrade' => $beforeLevel ->upgrade]);

        }else {
            // $message = '累積金額請 介於'.$beforeLevel ->name.'的$'.$beforeLevel ->upgrade.'與'.$afterLevel ->name.'的$'.$afterLevel ->upgrade;
            $message = __('shop.between',[
                'levelpre' => $beforeLevel ->name,
                'upgradepre' => $beforeLevel ->upgrade,
                'levelnext' => $afterLevel ->name,
                'upgradenext' => $afterLevel ->upgrade,

                ]);
        }
        
        return $message;
    }
}
