<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration\Setting;

use App\Http\Controllers\Controller;
use App\Models\Tools\MailTemplates;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $emails = MailTemplates::all();
        return view('theme.pages.Setting.index', compact('emails'));
    }

    public function email(MailTemplates $email)
    {
        return view('theme.pages.Setting.read.index', compact('email'));
    }
}
