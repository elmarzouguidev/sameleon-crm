<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tools\MailTemplate\MailFormRequest;
use App\Models\Tools\MailTemplates;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{


    public function store(MailFormRequest $request)
    {
        $template = new MailTemplates();

        $template->content = $request->get('content');

        $template->save();

        $file_handle = fopen(resource_path("views/theme/Emails/" . $request->get('name') . ".blade.php"), "w+");

        fwrite($file_handle, $template->content);

        fclose($file_handle);

        return back();
    }

    public function update(Request $request)
    {
        $template = MailTemplates::where('name', $request->get('name'))->first();

        $template->content = $request->get('content');

        $template->save();

        $file_handle = fopen(resource_path("views/theme/Emails/" . $request->get('name') . ".blade.php"), "w+");

        fwrite($file_handle, $template->content);

        fclose($file_handle);

        return back();
    }
}
