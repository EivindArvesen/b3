<?php namespace App\Http\Controllers;

use App\Models\Project;

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
        $projects = [];

        $categories = Project::select('category')->groupBy('category')->orderBy('category','asc')->get()->lists('category');

        foreach ($categories as $category) {
            $collection = [];
            $collection['name'] = $category;
            $collection['projects'] = Project::where('category', $category)->orderBy('project_id', 'desc')->get();
            array_push($projects, $collection);
        }

        return view(config('bbb_config.theme') . '.projects.index', ['page_title' => 'Projects', 'nav_active' => 'projects', 'results' => $projects]);
    }

    /**
     * Present project.
     *
     * @param  str  $title
     * @return Response
     */
    public function description($title)
    {
        $project = Project::where('slug', $title)->get()[0];
        return view(config('bbb_config.theme') . '.projects.presentation', ['page_title' => 'Projects', 'nav_active' => 'projects', 'project' => $project]);
        //return view(config('bbb_config.theme') . '.blog.entry', ['user' => Blog::findOrFail($id)]);
    }

}
