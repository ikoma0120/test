<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function about()
    {
        // 変数に値をセット
        $first_name = "Luke";
        $last_name = "Skywalker";

        // view関数の第２引数に compact関数を使う
        return view('pages.about', compact('first_name', 'last_name'));
    }
}
