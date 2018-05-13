<?php

namespace App\Http\ViewComposers;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LocationComposer
{
    public $locations;

    public function __construct()
    {
        $this->locations = DB::table('languages')->get();;
    }

    public function compose(View $view)
    {
        $locations = $this->locations;
        $view->with(compact('locations'));
    }

}
