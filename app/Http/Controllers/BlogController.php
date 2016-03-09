<?php namespace App\Http\Controllers;

use App\Models\Blogpost;
use App\Models\Category;
use App\Models\Language;
use App\Models\Post_category;
use App\Models\Post_tag;
use App\Models\Tag;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination;

class BlogController extends Controller {

    /* Load environments from phpdotenv (/*.env), require certain variables (DB) to be set here...
    Then: Use these for loading
    Also: Set blog-postpath $blog_path = base_path(), storage_path() */

    /**
     * Blog front.
     *
     * @return Response
     */
    public function showFront($page = 1)
    {
        $posts = Blogpost::where('published', '!', false)
               ->paginate(10);
        foreach ($posts as $post) {
            $tags = array();
            foreach (Post_tag::where('post_id', $post->post_id)->get() as $tag) {
                array_push($tags, Tag::where('tag_id', $tag->tag_id)->get()[0]->tag_title);
            }
            $post->tags = $tags;

            $category = Post_category::where('post_id', $post->post_id)->get()[0];
            $post->category = Category::where('category_id', $category->category_id)->get()[0]->category_title;

            $language = Language::where('language_id', $post->language_id)->get()[0];
            $post->language = Language::where('language_id', $language->language_id)->get()[0]->language_title;
        }

        return view('blog.index', ['page_title' => 'Blog', 'nav_active' => 'blog', 'results' => $posts]);
        //return view('blog.entry', ['user' => Blog::findOrFail($id)]);
        //
        //pagination at https://laracasts.com/discuss/channels/lumen/pagination-in-lumen
        //
        // $small = substr($big, 0, 100);
    }

    /**
     * List blog language.
     *
     * @param  str  $language
     * @return Response
     */
    public function listLanguage($language, $page = 1)
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
    public function listCategory($category, $page = 1)
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
    public function listTag($tag, $page = 1)
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
    public function search(Request $request, $page = 1)
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
    public function showArchive1($year, $page = 1)
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
    public function showArchive2($year, $month, $page = 1)
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
    public function showArchive3($year, $month, $day, $page = 1)
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
            /*
            $file = base_path().'/storage/app/blog/test.md';
            $source = file_get_contents($file);
            $parser = new DocumentParser;
            $document = $parser->parse($source);
            $rawMarkdown = $document->getContent();
            $html = $document->getHtmlContent();
            $metadata = $document->get();
            $slug = $document->get('slug');
            $body = $html;
            */

            $pages = Blogpost::where('url_title', $title)
               ->whereDate('modified_at', '=', $year.'-'.$month.'-'.$day)->simplePaginate(15);

            $title = strtolower($title);

            $post = Blogpost::where('url_title', $title)
               ->whereDate('modified_at', '=', $year.'-'.$month.'-'.$day)
               ->firstOrFail();

            $language = Language::where('language_id', $post->language_id)->get()[0]->language_title;
            //error_log($language);

            $tags = array();
            foreach (Post_tag::where('post_id', $post->post_id)->get() as $tag) {
                array_push($tags, Tag::where('tag_id', $tag->tag_id)->get()[0]->tag_title);
            }
            //foreach ($tags as $key) {
            //    error_log($key);
            //}

            $category = Category::where('category_id', Post_category::where('post_id', $post->post_id)->get()[0]->category_id)->get()[0]->category_title;

            $language = Language::where('language_id', $post->language_id)->get()[0]->language_title;

            return view('blog.entry', ['page_title' => 'Blog', 'nav_active' => 'blog', 'year' => $year, 'month' => $month, 'day' => $day, 'url_title' => $title, 'title' => $post->post_title, 'language' => $language, 'category' => $category, 'tags' => $tags, 'body' => $post->body, 'pages' => $pages]);
        }else{
            abort(404);
        }
    }

}
