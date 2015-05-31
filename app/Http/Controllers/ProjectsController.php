<?php namespace App\Http\Controllers;

//use App\User;
//use App\Http\Controllers\Controller;
use Laravel\Lumen\Routing\Controller;
// Use the Kurenai document parser.
use Kurenai\DocumentParser;

class ProjectsController extends Controller {

    /**
     * Show project list.
     *
     * @param  str  $title
     * @return Response
     */
    public function showList()
    {
        return view('projects.index', ['page_title' => 'Projects', 'nav_active' => 'projects',]);
        //return view('blog.entry', ['user' => Blog::findOrFail($id)]);
    }

    /**
     * Present project.
     *
     * @param  str  $title
     * @return Response
     */
    public function description($title)
    {
        return view('projects.presentation', ['page_title' => 'Projects', 'nav_active' => 'projects', 'title' => $title]);
        //return view('blog.entry', ['user' => Blog::findOrFail($id)]);
    }

}
