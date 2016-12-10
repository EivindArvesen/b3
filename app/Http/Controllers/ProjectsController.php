<?php namespace App\Http\Controllers;

use App\Models\Project;

use Illuminate\Support\Facades\Cache;
use Laravel\Lumen\Routing\Controller;

class ProjectsController extends Controller {

    /**
     * Show project list.
     *
     * @param  str  $title
     * @return Response
     */
    public function showList()
    {
        $project_list = Cache::remember('projects-list', config('b3_config.cache-age')*60, function() {
            $projects = [];
            $categories = Project::select('category')->groupBy('category')->orderBy('category','asc')->get()->lists('category');

            foreach ($categories as $category) {
                $collection = [];
                $collection['name'] = $category;
                $collection['projects'] = Project::where('category', $category)->orderBy('date', 'desc')->get();
                array_push($projects, $collection);
            }
            return $projects;
        });

        return view('projects.index', ['page_type' => 'Projects', 'nav_active' => 'projects', 'results' => $project_list, 'keywords' => array('Projects')]);
    }

    /**
     * Present project.
     *
     * @param  str  $title
     * @return Response
     */
    public function description($title)
    {
        $project = Cache::remember('project-'.$title, config('b3_config.cache-age')*60, function() use ($title) {
            return Project::where('slug', $title)->firstOrFail();
        });
        return view('projects.presentation', ['page_title' => ucfirst($title), 'page_type' => 'Projects', 'nav_active' => 'projects', 'project' => $project, 'keywords' => array(ucfirst($title))]);
        //return view('blog.entry', ['user' => Blog::findOrFail($id)]);
    }

}
