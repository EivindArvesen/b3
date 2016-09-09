<?php namespace App\Http\Controllers;

use App\Models\Blogpost;
use App\Models\Category;
use App\Models\Language;
use App\Models\Post_category;
use App\Models\Post_tag;
use App\Models\Tag;

use DB;
use DateTime;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class BlogController extends Controller {

    /* Load environments from phpdotenv (/*.env), require certain variables (DB) to be set here...
    Then: Use these for loading
    Also: Set blog-postpath $blog_path = base_path(), storage_path() */

    private function getSidebar() {
        return Cache::remember('blog-sidebar', config('bbb_config.cache-age')*60, function() {
            $sidebar = array();

            $sidebar['languages'] = Language::select('language_title', DB::raw('COUNT(language_title) as count'))->groupBy('language_title')->orderBy('count', 'desc')->take(5)->get()->lists('language_title'); // pluck

            $categories_keys = Post_category::select('category_id', DB::raw('COUNT(category_id) as count'))->groupBy('category_id')->orderBy('count', 'desc')->take(5)->get()->lists('category_id'); // pluck
            $categories_keys_str = implode(',', $categories_keys);
            $sidebar['categories'] = Category::select('category_title')->whereIn('category_id', $categories_keys)->orderByRaw(DB::raw("FIELD(category_id, $categories_keys_str)"))->get()->lists('category_title');

            $tags_keys = Post_tag::select('tag_id', DB::raw('COUNT(tag_id) as count'))->groupBy('tag_id')->orderBy('count', 'desc')->take(5)->get()->lists('tag_id'); // pluck
            $tags_keys_str = implode(',', $tags_keys);
            $sidebar['tags'] = Tag::select('tag_title')->whereIn('tag_id', $tags_keys)->orderByRaw(DB::raw("FIELD(tag_id, $tags_keys_str)"))->get()->lists('tag_title');

            $sidebar['dates'] = [];

            $date_posts = Blogpost::select('created_at', DB::raw("DATE_FORMAT(created_at, '%m-%Y') as month_year"))->groupBy('month_year')->orderBy('month_year','asc')->take(5)->get();

            foreach ($date_posts as $date_post) {
                $date = [];
                $date['link'] = substr($date_post->created_at, 0, 4) . '/' . substr($date_post->created_at, 5, 2);
                $date['text'] = DateTime::createFromFormat('!m', substr($date_post->created_at, 5, 2))->format('F') . ' ' . substr($date_post->created_at, 0, 4);
                array_push($sidebar['dates'], $date);
            }

            return $sidebar;
        });
    }

    /**
     * Blog front.
     *
     * @return Response
     */
    public function showFront($page = 1)
    {
        $blog_posts = Cache::remember('blog-front-'.$page, config('bbb_config.cache-age')*60, function() use ($page) {
            $posts = Blogpost::where('published', '!', false)->orderBy('created_at', 'DESC')
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
            return $posts;
        });

        return view('.blog.index', ['page_title' => 'Blog', 'nav_active' => 'blog', 'menu_transparent' => false, 'menu_style' => 'black', 'sidebar' => $this->getSidebar() , 'results' => $blog_posts]);
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
            $posts = Cache::remember('blog-language-'.$language.'-'.$page, config('bbb_config.cache-age')*60, function() use ($language, $page) {
                $language_id = Language::where('language_title', $language)->get()[0]->language_id;
                $posts = Blogpost::where('published', '!', false)->where('language_id', $language_id)->orderBy('created_at', 'DESC')
                       ->paginate(10);
                foreach ($posts as $post) {
                    $tags = array();
                    foreach (Post_tag::where('post_id', $post->post_id)->get() as $tag) {
                        array_push($tags, Tag::where('tag_id', $tag->tag_id)->get()[0]->tag_title);
                    }
                    $post->tags = $tags;

                    $category = Post_category::where('post_id', $post->post_id)->get()[0];
                    $post->category = Category::where('category_id', $category->category_id)->get()[0]->category_title;

                    $language_obj = Language::where('language_id', $post->language_id)->get()[0];
                    $post->language = Language::where('language_id', $language_obj->language_id)->get()[0]->language_title;
                }
                return $posts;
            });

            return view('.blog.inventory', ['page_title' => 'Blog', 'nav_active' => 'blog', 'group_title' => 'Language', 'group' => [$language], 'sidebar' => $this->getSidebar() , 'results' => $posts]);
        }
        else {
            $languages = Cache::remember('blog-languages-'.$page, config('bbb_config.cache-age')*60, function() use ($page) {
                return Language::paginate(10);
            });

            return view('.blog.list', ['page_title' => 'Blog', 'nav_active' => 'blog', 'list_title' => 'Language', 'sidebar' => $this->getSidebar() , 'results' => $languages]);
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
            $posts = Cache::remember('blog-category-'.$category.'-'.$page, config('bbb_config.cache-age')*60, function() use ($category, $page) {
                $category_title = $category;
                $category_id = Category::where('category_title', $category)->get()[0]->category_id;
                $post_idx = Post_category::where('category_id', $category_id)->get();
                $post_ids=[];
                foreach ($post_idx as $post_id) {
                    array_push($post_ids, $post_id->post_id);
                }
                $posts = Blogpost::where('published', '!', false)->whereIn('post_id', $post_ids)
                       ->orderBy('created_at', 'DESC')->paginate(10);
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
                return $posts;
            });

            return view('.blog.inventory', ['page_title' => 'Blog', 'nav_active' => 'blog', 'group_title' => 'Category', 'group' => [$category], 'sidebar' => $this->getSidebar() , 'results' => $posts]);
        }
        else {
            $categories = Cache::remember('blog-categories-'.$page, config('bbb_config.cache-age')*60, function() use ($page) {
                return Category::paginate(10);
            });

            return view('.blog.list', ['page_title' => 'Blog', 'nav_active' => 'blog', 'list_title' => 'Category', 'sidebar' => $this->getSidebar() , 'results' => $categories]);
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
            $posts = Cache::remember('blog-tag-'.$tag.'-'.$page, config('bbb_config.cache-age')*60, function() use ($tag, $page) {
                $tag_title = $tag;
                $tag_id = Tag::where('tag_title', $tag)->get()[0]->tag_id;
                $post_idx = Post_tag::where('tag_id', $tag_id)->get();
                $post_ids=[];
                foreach ($post_idx as $post_id) {
                    array_push($post_ids, $post_id->post_id);
                }
                $posts = Blogpost::where('published', '!', false)->whereIn('post_id', $post_ids)
                       ->orderBy('created_at', 'DESC')->paginate(10);
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
                return $posts;
            });

            return view('.blog.inventory', ['page_title' => 'Blog', 'nav_active' => 'blog', 'group_title' => 'Tag', 'group' => [$tag], 'sidebar' => $this->getSidebar() , 'results' => $posts]);
        }
        else {
            $tags = Cache::remember('blog-tags-'.$page, config('bbb_config.cache-age')*60, function() use ($page) {
                return Tag::paginate(10);
            });

            return view('.blog.list', ['page_title' => 'Blog', 'nav_active' => 'blog', 'list_title' => 'Tag', 'sidebar' => $this->getSidebar() , 'results' => $tags]);
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
        if (!$request->input('query') || trim($request->input('query'))=='') {
            return redirect('blog');
        }
        else {
            $posts = Cache::remember('blog-search-'.$request->input('query').'-'.$page, config('bbb_config.cache-age')*60, function() use ($request, $page) {
                $posts = Blogpost::where('published', '!', false)->where('body', 'LIKE', '%'.$request->input('query').'%')->orWhere('post_title', 'LIKE', '%'.$request->input('query').'%')->orWhere('slug', 'LIKE', '%'.$request->input('query').'%')->orWhere('lead', 'LIKE', '%'.$request->input('query').'%')
                       ->orderBy('created_at', 'DESC')->paginate(10);

                foreach (Category::where('category_title', 'LIKE', '%'.$request->input('query').'%')->get() as $id) {
                    foreach (Post_category::where('category_id', $id->category_id)->get() as $post_id) {
                        foreach (Blogpost::where('post_id', $post_id->post_id)->orderBy('created_at', 'DESC')->paginate(10) as $post) {
                            $posts->add($post);
                        }
                    }
                }

                foreach (Tag::where('tag_title', 'LIKE', '%'.$request->input('query').'%')->get() as $id) {
                    foreach (Post_tag::where('tag_id', $id->tag_id)->get() as $post_id) {
                        foreach (Blogpost::where('post_id', $post_id->post_id)->orderBy('created_at', 'DESC')->paginate(10) as $post) {
                            $posts->add($post);
                        }
                    }
                }

                foreach (Language::where('language_title', 'LIKE', '%'.$request->input('query').'%')->get() as $id) {
                    foreach (Blogpost::where('language_id', $id->language_id)->orderBy('created_at', 'DESC')->paginate(10) as $post) {
                        $posts->add($post);
                    }
                }

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
                return $posts;
            });

            return view('.blog.search', ['page_title' => 'Blog', 'nav_active' => 'blog', 'query' => $request->input('query'), 'sidebar' => $this->getSidebar() , 'results' => $posts]);
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
            $posts = Cache::remember('blog-archive1-'.$year.'-'.$page, config('bbb_config.cache-age')*60, function() use ($year, $page) {
                $posts = Blogpost::where('published', '!', false)->whereYear('created_at', '=', $year)
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
                return $posts;
            });

            return view('.blog.inventory', ['page_title' => 'Blog', 'nav_active' => 'blog', 'group_title' => '', 'group' => [$year], 'sidebar' => $this->getSidebar() , 'results' => $posts]);
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
            $posts = Cache::remember('blog-archive2-'.$year.'-'.$month.'-'.$page, config('bbb_config.cache-age')*60, function() use ($year, $month, $page) {
                $posts = Blogpost::where('published', '!', false)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)
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
                return $posts;
            });

            return view('.blog.inventory', ['page_title' => 'Blog', 'nav_active' => 'blog', 'group_title' => '', 'group' => [$year, $month], 'sidebar' => $this->getSidebar() , 'results' =>$posts]);
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
            $posts = Cache::remember('blog-archive3-'.$year.'-'.$month.'-'.$day.'-'.$page, config('bbb_config.cache-age')*60, function() use ($year, $month, $day, $page) {
                $posts = Blogpost::where('published', '!', false)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->whereDay('created_at', '=', $day)
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
                return $posts;
            });

            return view('.blog.inventory', ['page_title' => 'Blog', 'nav_active' => 'blog', 'group_title' => '', 'group' => [$year, $month, $day], 'sidebar' => $this->getSidebar() , 'results' => $posts]);
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

            $blogpost = Cache::remember('blog-post-'.$year.'-'.$month.'-'.$day.'-'.$title, config('bbb_config.cache-age')*60, function() use ($year, $month, $day, $title) {

                $pages = Blogpost::where('slug', $title)
                   ->whereDate('created_at', '=', $year.'-'.$month.'-'.$day)->simplePaginate(15);

                $title = strtolower($title);

                $post = Blogpost::where('slug', $title)
                   ->whereDate('created_at', '=', $year.'-'.$month.'-'.$day)
                   ->firstOrFail();

                $language = Language::where('language_id', $post->language_id)->get()[0]->language_title;

                $tags = array();
                foreach (Post_tag::where('post_id', $post->post_id)->get() as $tag) {
                    array_push($tags, Tag::where('tag_id', $tag->tag_id)->get()[0]->tag_title);
                }

                $category = Category::where('category_id', Post_category::where('post_id', $post->post_id)->get()[0]->category_id)->get()[0]->category_title;

                $language = Language::where('language_id', $post->language_id)->get()[0]->language_title;

                $prev_id = Blogpost::where('post_id', '<', $post->post_id)->max('post_id');
                if (!is_null($prev_id)) {
                    $prev_post = Blogpost::where('post_id', '=', $prev_id)->first();
                    $prev_url = '/blog/'.substr($prev_post->created_at, 0, 4).'/'.substr($prev_post->created_at, 5, 2).'/'.substr($prev_post->created_at, 8, 2).'/'.$prev_post->slug;
                }
                else {
                    $prev_url = null;
                }

                $next_id = Blogpost::where('post_id', '>', $post->post_id)->min('post_id');
                if (!is_null($next_id)) {
                    $next_post = Blogpost::where('post_id', '=', $next_id)->first();
                    $next_url = '/blog/'.substr($next_post->created_at, 0, 4).'/'.substr($next_post->created_at, 5, 2).'/'.substr($next_post->created_at, 8, 2).'/'.$next_post->slug;
                }
                else {
                    $next_url = null;
                }
                return array(
                    'post' => $post,
                    'language' => $language,
                    'category' => $category,
                    'tags' => $tags,
                    'pages' => $pages,
                    'prev_url' => $prev_url,
                    'next_url' => $next_url
                );
            });

            return view('.blog.entry', ['page_title' => 'Blog', 'nav_active' => 'blog', 'sidebar' => $this->getSidebar() , 'year' => $year, 'month' => $month, 'day' => $day, 'slug' => $title, 'title' => $blogpost['post']->post_title, 'language' => $blogpost['language'], 'category' => $blogpost['category'], 'tags' => $blogpost['tags'], 'lead' => $blogpost['post']->lead, 'modified_at' => $blogpost['post']->modified_at, 'body' => $blogpost['post']->body, 'pages' => $blogpost['pages'], 'prev_url' => $blogpost['prev_url'], 'next_url' => $blogpost['next_url']]);
        }else{
            abort(404);
        }
    }

    /**
     * List blog archive.
     *
     * @return Response
     */
    public function archive($page = 1)
    {
        $dates = Cache::remember('blog-archive-'.$page, config('bbb_config.cache-age')*60, function() use ($page) {
            $dates = [];

            $date_posts = Blogpost::select('created_at', DB::raw("DATE_FORMAT(created_at, '%m-%Y') as month_year"))->groupBy('month_year')->orderBy('month_year','asc')->get();
            // ->paginate(10)

            foreach ($date_posts as $date_post) {
                $date = [];
                $date['link'] = substr($date_post->created_at, 0, 4) . '/' . substr($date_post->created_at, 5, 2);
                $date['title'] = DateTime::createFromFormat('!m', substr($date_post->created_at, 5, 2))->format('F') . ' ' . substr($date_post->created_at, 0, 4);
                array_push($dates, $date);
            }

            $dates =  new LengthAwarePaginator($dates, sizeof($dates), 10);
            return $dates;
        });

        return view('.blog.list', ['page_title' => 'Blog', 'nav_active' => 'blog', 'list_title' => 'Archive', 'sidebar' => $this->getSidebar() , 'results' => $dates]);
    }

}
