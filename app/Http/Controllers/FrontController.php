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
        return view('front.index', ['page_title' => 'Index', 'nav_active' => 'about']); //
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
        $discard=array('','.','..');
        $debug_folder="/themes/debug/";
        $file_list=array();
        foreach (scandir(base_path().'/public'.$debug_folder) as $file) {
                if (!array_search($file, $discard)){
                    $file_list[]=$file;
                }
        }
        return view('debug.index', ['page_title' => 'Debug', 'nav_active' => 'debug', 'content' => 'Content', 'debug_folder' => $debug_folder, 'file_list' => $file_list]);
    }

    public function debugtheme()
    {
        return '<html><body>BAJS</body></html>';
    }

}
