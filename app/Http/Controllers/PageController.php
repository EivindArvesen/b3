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
        try {
            $page = Page::where('type', 'index')->first();
        } catch (ErrorException $e) {
            return redirect('/blog');
        }

        return view(config('bbb_config.theme') . '.front.' . $page->type, ['page_title' => $page->page_title, 'menu_transparent' => false, 'menu_style' => 'black', 'nav_active' => '', 'page' => $page]);
        // return view(config('bbb_config.theme') . '.front.index', ['page_title' => 'Index', 'menu_transparent' => false, 'menu_style' => 'black', 'nav_active' => 'about']);
        //return view()->file(theme_path().'/views/front.php'); // , $data

    }

    /**
     * Show contact page.
     *
     * @return Response
     */
    public function page($slug)
    {
        try {
            $page = Page::where('slug', $slug)->first();
        } catch (ErrorException $e) {
            return redirect('/');
        }

        if ($page->type == 'index') {
            return redirect('/');
        }

        else {
            return view(config('bbb_config.theme') . '.front.' . $page->type, ['page_title' => $page->page_title, 'nav_active' => $page->slug, 'page' => $page]);
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
        return view(config('bbb_config.theme') . '.debug.index', ['page_title' => 'Debug', 'nav_active' => 'debug', 'content' => 'Content', 'debug_folder' => $debug_folder, 'file_list' => $file_list]);
    }

    public function debugtheme()
    {
        return '<html><body>TEST</body></html>';
    }

}
