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
        // $small = substr($big, 0, 100);
    }

    /**
     * List blog language.
     *
     * @param  str  $language
     * @return Response
     */
    public function listLanguage($language=False, $page = 1)
    {
        if ($language!=False) {
            $language_id = Language::where('language_title', $language)->get()[0]->language_id;
            $posts = Blogpost::where('published', '!', false)->where('language_id', $language_id)
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

            return view('blog.inventory', ['page_title' => 'Blog', 'nav_active' => 'blog', 'group_title' => 'Language', 'group' => [$language->language_title], 'results' => $posts]);
        }
        else {
            $languages = Language::paginate(10);

            return view('blog.list', ['page_title' => 'Blog', 'nav_active' => 'blog', 'list_title' => 'Language', 'results' => $languages]);
        }
    }

    /**
     * List blog category.
     *
     * @param  str  $category
     * @return Response
     */
    public function listCategory($category=False, $page = 1)
    {
        if ($category!=False) {
            $category_title = $category;
            $category_id = Category::where('category_title', $category)->get()[0]->category_id;
            $post_idx = Post_category::where('category_id', $category_id)->get();
            $post_ids=[];
            foreach ($post_idx as $post_id) {
                array_push($post_ids, $post_id->post_id);
            }
            $posts = Blogpost::where('published', '!', false)->whereIn('post_id', $post_ids)
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

            return view('blog.inventory', ['page_title' => 'Blog', 'nav_active' => 'blog', 'group_title' => 'Category', 'group' => [$category_title], 'results' => $posts]);
        }
        else {
            $categories = Category::paginate(10);

            return view('blog.list', ['page_title' => 'Blog', 'nav_active' => 'blog', 'list_title' => 'Category', 'results' => $categories]);
        }
    }

    /**
     * List blog tag.
     *
     * @param  str  $tag
     * @return Response
     */
    public function listTag($tag=False, $page = 1)
    {
        if ($tag!=False) {
            $tag_title = $tag;
            $tag_id = Tag::where('tag_title', $tag)->get()[0]->tag_id;
            $post_idx = Post_tag::where('tag_id', $tag_id)->get();
            $post_ids=[];
            foreach ($post_idx as $post_id) {
                array_push($post_ids, $post_id->post_id);
            }
            $posts = Blogpost::where('published', '!', false)->whereIn('post_id', $post_ids)
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

            return view('blog.inventory', ['page_title' => 'Blog', 'nav_active' => 'blog', 'group_title' => 'Tag', 'group' => [$tag_title], 'results' => $posts]);
        }
        else {
            $tags = Tag::paginate(10);

            return view('blog.list', ['page_title' => 'Blog', 'nav_active' => 'blog', 'list_title' => 'Tag', 'results' => $tags]);
        }
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
            $posts = Blogpost::where('published', '!', false)->where('body', 'LIKE', '%'.$request->input('query').'%')->orWhere('post_title', 'LIKE', '%'.$request->input('query').'%')
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

            return view('blog.search', ['page_title' => 'Blog', 'nav_active' => 'blog', 'query' => $request->input('query'), 'results' => $posts]);
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
            $posts = Blogpost::where('published', '!', false)->whereYear('modified_at', '=', $year)
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

            return view('blog.inventory', ['page_title' => 'Blog', 'nav_active' => 'blog', 'group_title' => '', 'group' => [$year], 'results' => $posts]);
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
            $posts = Blogpost::where('published', '!', false)->whereYear('modified_at', '=', $year)
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

            return view('blog.inventory', ['page_title' => 'Blog', 'nav_active' => 'blog', 'group_title' => '', 'group' => [$year, $month], 'results' =>$posts]);
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
            $posts = Blogpost::where('published', '!', false)->whereYear('modified_at', '=', $year)
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

            return view('blog.inventory', ['page_title' => 'Blog', 'nav_active' => 'blog', 'group_title' => '', 'group' => [$year, $month, $day], 'results' => $posts]);
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
