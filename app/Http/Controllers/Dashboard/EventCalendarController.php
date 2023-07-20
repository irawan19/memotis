<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

class EventCalendarController extends AdminCoreController
{
    public function index(Request $request)
    {
        $calendar_data[] = [
            'title'         => 'test',
            'start'         => '2023-07-20',
            'end'           => '2023-07-23',
            'description'   => 'testing',
            'color'         => 'orange',
        ];
        return json_encode($calendar_data);
    }

}