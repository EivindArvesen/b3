<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Support\Facades\View;

class StatusController extends Controller {

    // maintenance, unavailable, landing, prelaunch

    /**
     * Show contact page.
     *
     * @return Response
     */
    public function status()
    {
        if (View::exists('status.'.config('b3_config.status'))) {
            return view('status.' . config('b3_config.status'), ['page_title' => ucfirst(config('b3_config.status'))]);
        }
        else {
            return view('status.unavailable', ['page_title' => 'Unavailable']);
        }

    }

}
