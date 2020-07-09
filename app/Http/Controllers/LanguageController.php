<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
class LanguageController extends Controller
{
    public function changeLocale($locale)
    {
        if (in_array($locale, ['en', 'zh'])) {
            session()->put('locale', $locale);
        }
        return redirect()
            ->back()
            ->withInput();
    }
}
