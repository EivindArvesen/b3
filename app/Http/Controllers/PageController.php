<?php namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Blogpost;
use App\Models\Project;

use Illuminate\Support\Facades\Cache;
use Laravel\Lumen\Routing\Controller;

class PageController extends Controller {

    /**
     * Show front page.
     *
     * @return Response
     */
    public function index()
    {
        try {
            $page = $value = Cache::remember('page-index', config('b3_config.cache-age')*60, function() {
                return Page::where('type', 'index')->first();
            });
        } catch (ErrorException $e) {
            return redirect('/blog');
        }

        $last_blogposts = Cache::remember('last_posts-', config('b3_config.cache-age')*60, function() {
            return Blogpost::where('published', '!', false)->orderBy('created_at', 'DESC')
                   ->take(3)->get(['post_title', 'created_at', 'slug']);
        });

        $last_projects = Cache::remember('last_projects', config('b3_config.cache-age')*60, function() {
            return Project::where('published', '!', false)->orderBy('date', 'desc')
                   ->take(3)->get(['slug', 'project_title']);
        });

        return view('front.' . $page->type, ['page_title' => $page->page_title, 'bg' => $page->bg, 'menu_transparent' => false, 'style' => $page->style, 'nav_active' => '', 'page' => $page, 'last_blogposts' => $last_blogposts, 'last_projects' => $last_projects ]);
    }

    /**
     * Show contact page.
     *
     * @return Response
     */
    public function page($slug)
    {
        try {
            $page = Cache::remember('page-'.$slug, config('b3_config.cache-age')*60, function() use ($slug) {
                return Page::where('slug', $slug)->first();
            });
        } catch (ErrorException $e) {
            return redirect('/');
        }

        if ($page == null) {
            abort(404);
        }

        if ($page->type == 'index') {
            return redirect('/');
        }

        else {
            return view('front.' . $page->type, ['page_title' => $page->page_title, 'bg' => $page->bg, 'nav_active' => $page->slug, 'page' => $page]);
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
