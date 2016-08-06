<?php namespace App\Http\Controllers;

use App\Models\Page;

//use App\User;
//use App\Http\Controllers\Controller;
use Laravel\Lumen\Routing\Controller;
// Use the Kurenai document parser.
use Kurenai\DocumentParser;

class PageController extends Controller {

    /**
     * Show front page.
     *
     * @return Response
     */
    public function index()
    {
        $page = Page::where('type', 'index')->get()[0];

        return view('front.' . $page->type, ['page_title' => 'Index', 'menu_transparent' => false, 'menu_style' => 'black', 'nav_active' => 'about', 'page' => $page]);
        // return view('front.index', ['page_title' => 'Index', 'menu_transparent' => false, 'menu_style' => 'black', 'nav_active' => 'about']);
        //return view()->file(theme_path().'/views/front.php'); // , $data

    }

    /**
     * Show contact page.
     *
     * @return Response
     */
    public function page($slug)
    {
        $page = Page::where('slug', $slug)->get()[0];

        if ($page->type == 'index') {
            return redirect('/');
        }

        else {
            return view('front.' . $page->type, ['page_title' => $page->page_title, 'nav_active' => 'contact', 'page' => $page]);
        }

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
        return '<html><body>TEST</body></html>';
    }

}
