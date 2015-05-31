<?php namespace App\Http\Controllers;

//use App\User;
//use App\Http\Controllers\Controller;
use Laravel\Lumen\Routing\Controller;
// Use the Kurenai document parser.
use Kurenai\DocumentParser;
use Illuminate\Http\Request;

class BlogController extends Controller {

    /* Load environments from phpdotenv (/*.env), require certain variables (DB) to be set here...
    Then: Use these for loading
    Also: Set blog-postpath $blog_path = base_path(), storage_path() */

    /**
     * Blog front.
     *
     * @return Response
     */
    public function showFront()
    {
        return view('blog.index', ['page_title' => 'Blog', 'nav_active' => 'blog']);
        //return view('blog.entry', ['user' => Blog::findOrFail($id)]);
    }

    /**
     * List blog language.
     *
     * @param  str  $language
     * @return Response
     */
    public function listLanguage($language)
    {
        return view('blog.inventory', ['page_title' => 'Blog', 'nav_active' => 'blog', 'group_title' => 'Language', 'group' => [$language]]);
        //return view('blog.entry', ['user' => Blog::findOrFail($id)]);
    }

    /**
     * List blog category.
     *
     * @param  str  $category
     * @return Response
     */
    public function listCategory($category)
    {
        return view('blog.inventory', ['page_title' => 'Blog', 'nav_active' => 'blog', 'group_title' => 'Category', 'group' => [$category]]);
        //return view('blog.entry', ['user' => Blog::findOrFail($id)]);
    }

    /**
     * List blog tag.
     *
     * @param  str  $tag
     * @return Response
     */
    public function listTag($tag)
    {
        return view('blog.inventory', ['page_title' => 'Blog', 'nav_active' => 'blog', 'group_title' => 'Tag', 'group' => [$tag]]);
        //return view('blog.entry', ['user' => Blog::findOrFail($id)]);
    }

    /**
     * Search blog.
     *
     * @param  str  $query
     * @return Response
     */
    public function search(Request $request)
    {
        if (!$request->input('query') || $request->input('query')==' ') {
            return redirect('blog');
        }
        else {
            return view('blog.search', ['page_title' => 'Blog', 'nav_active' => 'blog', 'query' => $request->input('query')]);
            //return view('blog.entry', ['user' => Blog::findOrFail($id)]);
        }
    }

    /**
     * Show archive.
     *
     * @param  int  $year
     * @return Response
     */
    public function showArchive1($year)
    {
        if(preg_match('/^[0-9]{4}$/', $year)){
            return view('blog.inventory', ['page_title' => 'Blog', 'nav_active' => 'blog', 'group_title' => '', 'group' => [$year]]);
            //return view('blog.entry', ['user' => Blog::findOrFail($id)]);
        }else{
            abort(404);
        }
    }

    /**
     * Show archive.
     *
     * @param  int  $year
     * @param  int  $month
     * @return Response
     */
    public function showArchive2($year, $month)
    {
        if(preg_match('/^[0-9]{4}-[0-9]{2}$/', $year.'-'.$month)){
            return view('blog.inventory', ['page_title' => 'Blog', 'nav_active' => 'blog', 'group_title' => '', 'group' => [$year, $month]]);
            //return view('blog.entry', ['user' => Blog::findOrFail($id)]);
        }else{
            abort(404);
        }
    }

    /**
     * Show archive.
     *
     * @param  int  $year
     * @param  int  $month
     * @param  int  $day
     * @return Response
     */
    public function showArchive3($year, $month, $day)
    {
        if(preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $year.'-'.$month.'-'.$day)){
            return view('blog.inventory', ['page_title' => 'Blog', 'nav_active' => 'blog', 'group_title' => '', 'group' => [$year, $month, $day]]);
            //return view('blog.entry', ['user' => Blog::findOrFail($id)]);
        }else{
            abort(404);
        }
    }

    /**
     * Show a given blog entry.
     *
     * @param  int  $year
     * @param  int  $month
     * @param  int  $day
     * @param  str  $title
     * @return Response
     */
    public function showEntry($year, $month, $day, $title)
    {
        if(preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $year.'-'.$month.'-'.$day)){
            $file = base_path().'/test.md';
            $source = file_get_contents($file);
            $parser = new DocumentParser;
            $document = $parser->parse($source);
            $rawMarkdown = $document->getContent();
            $html = $document->getHtmlContent();
            $metadata = $document->get();
            $slug = $document->get('slug');

            $body = $html;

            return view('blog.entry', ['page_title' => 'Blog', 'nav_active' => 'blog', 'date' => $year.'/'.$month.'/'.$day, 'title' => $title, 'body' => $body]);
            //return view('blog.entry', ['user' => Blog::findOrFail($id)]);
        }else{
            abort(404);
        }
    }

}
