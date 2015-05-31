<?php namespace App\Http\Controllers;

//use App\User;
//use App\Http\Controllers\Controller;
use Laravel\Lumen\Routing\Controller;
// Use the Kurenai document parser.
use Kurenai\DocumentParser;

class FrontController extends Controller {

    /**
     * Show front page.
     *
     * @return Response
     */
    public function index()
    {
        return view('front.index', ['page_title' => 'Index', 'nav_active' => 'home']); //
        //return view()->file(theme_path().'/views/front.php'); // , $data

    }

    /**
     * Show about page.
     *
     * @return Response
     */
    public function about()
    {
        return view('front.single', ['page_title' => 'About', 'nav_active' => 'about', 'content' => 'Content']); //
        //return view()->file(theme_path().'/views/front.php'); // , $data

    }

    /**
     * Show contact page.
     *
     * @return Response
     */
    public function contact()
    {
        return view('front.single', ['page_title' => 'Contact', 'nav_active' => 'contact', 'content' => 'Content']); //
        //return view()->file(theme_path().'/views/front.php'); // , $data

    }

    public function debug()
    {
        $designs="";
        foreach (scandir(base_path().'/public/themes/debug') as $design) {
            $designs.='<a href="'.'/themes/debug/'.$design.'">'.$design.'</a><br />';
        }
        return '
        <html>
            <head>
                <title>DEBUG</title>
            </head>
            <body>
                <h1>DEBUG</h1>
                '.$designs.'
            </body
        </html>
        ';
    }


}
