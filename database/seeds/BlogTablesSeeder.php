<?php

# database/seeds/BlogTablesSeeder.php

use App\Models\Blogpost;
use App\Models\Category;
use App\Models\Language;
use App\Models\Post_category;
use App\Models\Post_tag;
use App\Models\Post_series;
use App\Models\Series;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Kurenai\DocumentParser;
use Intervention\Image\ImageManager;

class BlogTablesSeeder extends Seeder
{
    public function run()
    {

        // protected $table = 'my_flights'; // set table

        // update tables instead of overwriting (think timestamps, original...)
        $manager = new ImageManager;

        $pub_path = realpath(dirname(dirname(dirname(__FILE__)))).'/public';

        $parser = new DocumentParser;
        $it = new RecursiveDirectoryIterator(realpath(dirname(dirname(dirname(__FILE__)))."/public/content/blog"));
        $display = Array ( 'md' );
        foreach(new RecursiveIteratorIterator($it) as $file)
        {
            $exp = explode('.', $file);
            if (basename($file)!=='.' && basename($file)!=='..' && in_array(strtolower(array_pop($exp)), $display)) {
                $original_date = basename(dirname(dirname(dirname($file)))) . '-' . basename(dirname(dirname($file))) . '-' . basename(dirname($file));

                $source = file_get_contents($file);
                $document = $parser->parse($source);

                if ($document->get('published') != 'false' ) {

                    // Build absolute path to content
                    $path = "/content" . dirname(explode("/content", $file)[1]);

                    $languages = array();
                    if (!Language::where('language_title', $document->get('language'))->first()) {
                        Language::create([
                            'language_title' => ucfirst($document->get('language'))
                        ]);
                    }
                    $lang_id = Language::where('language_title', $document->get('language'))->first()->language_id;
                    if (!array_key_exists($document->get('language')[0], $languages)) {
                        $languages[$document->get('language')[0]] = $lang_id;
                    }

                    $categories = array();
                    if (!Category::where('category_title', ucfirst(trim($document->get('category'))))->first()) {
                        Category::create([
                            'category_title' => ucfirst(trim($document->get('category'))),
                            'category_slug' => substr(str_replace('+', '-', urlencode(strtolower(preg_replace("#[[:punct:]]#", "-", ucfirst(trim($document->get('category'))))))), 0, 50)
                        ]);
                    }
                    $cat_id = Category::where('category_title', ucfirst(trim($document->get('category'))))->first()->category_id;
                    if (!array_key_exists($document->get('category'), $categories)) {
                        $categories[$document->get('category')] = $cat_id;
                    }

                    $tags = array();
                    foreach (explode(",", $document->get('tags')) as $tag) {
                        if (!Tag::where('tag_title', ucfirst(trim($tag)))->first()) {
                            Tag::create([
                            'tag_title' => ucfirst(trim($tag)),
                            'tag_slug' => substr(str_replace('+', '-', urlencode(strtolower(preg_replace("#[[:punct:]]#", "-", ucfirst(trim($tag)))))), 0, 50)
                            ]);
                        }
                        $tag_id = Tag::where('tag_title', ucfirst(trim($tag)))->first()->tag_id;
                        if (!array_key_exists($tag, $tags)) {
                            $tags[$tag] = $tag_id;
                        }
                    }

                    $series = array();
                    if (!Series::where('series_title', ucfirst(trim($document->get('series'))))->first()) {
                        Series::create([
                            'series_title' => ucfirst(trim($document->get('series'))),
                            'series_slug' => substr(str_replace('+', '-', urlencode(strtolower(preg_replace("#[[:punct:]]#", "-", ucfirst(trim($document->get('series'))))))), 0, 50)
                        ]);
                    }
                    $ser_id = Series::where('series_title', ucfirst(trim($document->get('series'))))->first()->series_id;
                    if (!array_key_exists($document->get('series'), $series)) {
                        $series[$document->get('series')] = $ser_id;
                    }

                    if ($document->get('slug')) {
                        $slug = substr(str_replace('+', '-', urlencode(strtolower(preg_replace("#[[:punct:]]#", "-", $document->get('slug'))))), 0, 50);
                    } else {
                        $slug = substr(str_replace('+', '-', urlencode(strtolower(preg_replace("#[[:punct:]]#", "-", $document->get('title'))))), 0, 50);
                    }

                    if ($document->get('cover')) {
                        // Fix cover-meta
                        $cover = $path . '/' . ltrim($document->get('cover'), '/');

                        $image_path = $pub_path . $cover;
                        // Append "-original" to original and replace it
                        $original = preg_replace('/(\.[^.]+)$/', sprintf('%s$1', '-original'), $image_path);
                        $thumbnail = preg_replace('/(\.[^.]+)$/', sprintf('%s$1', '-thumbnail'), $image_path);

                        if (!file_exists($original) || !file_exists($thumbnail)) {
                            $img = $manager->make($image_path);

                            if (!file_exists($original)) {
                                rename($image_path, $original);
                                // Convert and optimize images
                                $img->encode(pathinfo($image_path)['extension'], 75)->resize(4096, null, function ($constraint) {
                                    $constraint->upsize();
                                    $constraint->aspectRatio();
                                });

                                $new_path = dirname($image_path).'/'.pathinfo($image_path)['filename']. ".".pathinfo($image_path)['extension'];
                                $img->save($new_path);
                            }

                            if (!file_exists($thumbnail)) {
                                // Generate thumbnail
                                $img->resize(800, null, function ($constraint) {
                                    $constraint->aspectRatio();
                                    //$constraint->upsize();
                                });
                                $img->save($thumbnail);
                            }
                            $img->destroy();
                        }

                    } else {
                        $cover = '';
                    }

                    if ($document->get('type')) {
                        $type = $document->get('type');
                    } else {
                        $type = 'default';
                    }

                    if ($document->get('style')) {
                        $style = $document->get('style');
                    } else {
                        $style = 'default';
                    }

                    // Make relative paths (links/images) absolute
                    $body = preg_replace("/(href|src)\=\"([(www)])(\/)?/", "$1=\"http://$2", preg_replace("/(href|src)\=\"([^(http|www|\/)])(\/)?/", "$1=\"$path/$2", $document->getHtmlContent()));

                    $doc = new DOMDocument();
                    @$doc->loadHTML('<html><body>'.$body.'</body></html>');

                    $images = $doc->getElementsByTagName('img');

                    foreach ($images as $image) {
                        $image_path = $pub_path . $image->getAttribute('src');
                        // Append "-original" to original and replace it
                        $original = preg_replace('/(\.[^.]+)$/', sprintf('%s$1', '-original'), $image_path);
                        $thumbnail = preg_replace('/(\.[^.]+)$/', sprintf('%s$1', '-thumbnail'), $image_path);

                        if (!file_exists($original) || !file_exists($thumbnail)) {
                            $img = $manager->make($image_path);

                            if (!file_exists($original)) {
                                rename($image_path, $original);

                                // Convert and optimize images
                                $img->encode(pathinfo($image_path)['extension'], 75)->resize(1920, null, function ($constraint) {
                                    $constraint->aspectRatio();
                                    $constraint->upsize();
                                });

                                $new_path = dirname($image_path).'/'.pathinfo($image_path)['filename']. ".".pathinfo($image_path)['extension'];
                                $img->save($new_path);
                            }

                            if (!file_exists($thumbnail)) {
                                // Generate thumbnail
                                $img->resize(800, null, function ($constraint) {
                                    $constraint->aspectRatio();
                                    //$constraint->upsize();
                                });
                                $img->save($thumbnail);
                            }

                            $img->destroy();
                        }

                        // Generate image caption based on img title attribute
                        $caption = $image->getAttribute('title');

                        // Make optimized image link to original image on click
                        $image_element = $doc->saveHTML($image);
                        str_replace($image->getAttribute('src'), dirname($image->getAttribute('src')).'/'.basename($image->getAttribute('src'), ".jpg") , $image_element);
                        $new_stuff = '<a href="' . str_replace($pub_path, '', $original) . '">' . $image_element . '</a><span class="img-caption">' . $caption . '</span>';

                        // Replace the old with the new
                        $body = str_replace(substr($doc->saveHTML($image), 0, -1).' />', $new_stuff, $body);
                    }

                    $blogpost = Blogpost::create([
                        'created_at' => $original_date . ' 00:00:00',
                        'modified_at' => $document->get('modified') . ' 00:00:00',
                        'language_id' => $lang_id,
                        'post_title' => ucfirst($document->get('title')),
                        'slug' => $slug,
                        'cover' => $cover,
                        'lead' => ucfirst($document->get('lead')),
                        'body' => $body,
                        'published' => $document->get('published') == 'false' || false,
                        'type' => $type,
                        'style' => $style,
                        'transparent' => $document->get('transparent') == 'false' || false,
                        'sticky' => $document->get('sticky') == 'false' || false,
                        'seamless' => $document->get('seamless') == 'false' || false,
                    ]);

                    // $post_id = $blogpost->post_id;
                    // use hashes here instead?
                    $post_id = Blogpost::where('body', $body)->first()->post_id;

                    Post_category::create([
                        'post_id' => $post_id,
                        'category_id' => $cat_id
                    ]);

                    //post-tags:
                    //legg til post-id, tag-id
                    foreach ($tags as $index => $tag_id) {
                        Post_tag::create([
                            'post_id' => $post_id,
                            'tag_id' => $tag_id
                        ]);
                    }

                    Post_series::create([
                        'post_id' => $post_id,
                        'series_id' => $ser_id
                    ]);
                }
            }
        }
    }
}
