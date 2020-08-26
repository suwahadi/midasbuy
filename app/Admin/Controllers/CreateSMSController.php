<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets;

class CreateSMSController extends Controller
{

    public function index(Content $content)
    {
        $content->title('Create SMS');
        $content->description(' ');
        $content->header(' Create SMS');
        $content->view('create-sms', ['data' => 'data']);
        return $content;
    }

}