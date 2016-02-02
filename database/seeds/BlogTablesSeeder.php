<?php

# database/seeds/BlogTablesSeeder.php

use App\Models\Blogpost;
use App\Models\Category;
use App\Models\Language;
use App\Models\Post_category;
use App\Models\Post_tag;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Kurenai\DocumentParser;

class BlogTablesSeeder extends Seeder
{
    public function run()
    {
        // protected $table = 'my_flights'; // set table

        // update tables instead of overwriting (think timestamps, original...)

        $parser = new DocumentParser;
        $it = new RecursiveDirectoryIterator(realpath("./storage/app/blog"));
        $display = Array ( 'md' );
        foreach(new RecursiveIteratorIterator($it) as $file)
        {
            //echo basename($file);
            $exp = explode('.', $file);
            if (basename($file)!=='.' && basename($file)!=='..' && in_array(strtolower(array_pop($exp)), $display)) {
                $source = file_get_contents($file);
                $document = $parser->parse($source);

                $languages = array();
                if (!array_key_exists($document->get('language'), $languages)) {
                    Language::create([
                        'language_title' => $document->get('language')
                    ]);
                    $lang_id = Language::where('language_title', $document->get('language'))->get()[0]->language_id;
                    $languages[$document->get('language')] = $lang_id;
                }

                $categories = array();
                if (!array_key_exists($document->get('category'), $categories)) {
                    Category::create([
                        'category_title' => $document->get('category')
                    ]);
                    $cat_id = Category::where('category_title', $document->get('category'))->get()[0]->category_id;
                    $categories[$document->get('category')] = $lang_id;
                }

                $tags = array();
                foreach (explode(",", $document->get('tags')) as $tag) {
                    if (!array_key_exists($tag, $tags)) {
                        Tag::create([
                        'tag_title' => trim($tag)
                        ]);
                        $tag_id = Tag::where('tag_title', $document->get('tag'))->get();
                        $tags[$tag] = $tag_id;
                    }
                }

                Blogpost::create([
                    'language_id' => $lang_id,
                    'post_title' => $document->get('title'),
                    'slug' => ($document->get('slug')||''),
                    'body' => $document->getHtmlContent(),
                    'author' => ($document->get('author')||''),
                    'published' => ($document->get('published')||'')
                ]);

                // use hashes here in stead?
                $post_id = Blogpost::where('body', $document->getHtmlContent())->get()[0]->post_id;

                Post_category::create([
                    'post_id' => $post_id,
                    'category_id' => $cat_id
                ]);

                //post-tags:
                //legg til post-id, tag-id
                foreach ($tags as $tag_id => $tag_title) {
                    Post_tag::create([
                        'post_id' => $post_id,
                        'tag_id' => $tag_id
                    ]);
                }
            }
        }
    }
}
