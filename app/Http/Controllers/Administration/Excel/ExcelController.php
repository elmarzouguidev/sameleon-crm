<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration\Excel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExcelController extends Controller
{


    public function index()
    {
        return view('theme.pages.Excel.index');
    }
}
