<?php

# database/seeds/PagesTableSeeder.php

use App\Models\Project;

use Illuminate\Database\Seeder;

use Kurenai\DocumentParser;
use Intervention\Image\ImageManager;

class ProjectsTableSeeder extends Seeder
{
    public function run()
    {

        // update tables instead of overwriting (think timestamps, original...)
        $manager = new ImageManager;

        $pub_path = realpath(dirname(dirname(dirname(__FILE__)))).'/public';

        $parser = new DocumentParser;
        $it = new RecursiveDirectoryIterator(realpath(dirname(dirname(dirname(__FILE__)))."/public/content/projects"), RecursiveDirectoryIterator::FOLLOW_SYMLINKS);
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

                    if ($document->get('slug')) {
                        $slug = substr(str_replace('+', '-', urlencode(strtolower(preg_replace("#[[:punct:]]#", "-", $document->get('slug'))))), 0, 50);
                    } else {
                        $slug = substr(str_replace('+', '-', urlencode(strtolower(preg_replace("#[[:punct:]]#", "-", $document->get('title'))))), 0, 50);
                    }

                    if ($document->get('feature')) {
                        // Fix feature-meta
                        $feature = $path . '/' . ltrim($document->get('feature'), '/');

                        $image_path = $pub_path . $feature;
                        $optimized = preg_replace('/(\.[^.]+)$/', sprintf('%s$1', '-optimized'), $image_path);
                        $thumbnail = preg_replace('/(\.[^.]+)$/', sprintf('%s$1', '-thumbnail'), $image_path);

                        if (!file_exists($optimized) || !file_exists($thumbnail)) {
                            $img = $manager->make($image_path);

                            if (!file_exists($optimized)) {
                                // Convert and optimize images
                                $img->encode(pathinfo($image_path)['extension'], 75)->resize(4096, null, function ($constraint) {
                                    $constraint->upsize();
                                    $constraint->aspectRatio();
                                });
                                $img->save($optimized);
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
                        $feature = str_replace($pub_path, '', $optimized);
                    } else {
                        $feature = '';
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

                    $category = ucfirst(basename(dirname($file)));

                    // Make relative paths (links/images) absolute
                    $body = preg_replace("/(href|src)\=\"([(www)])(\/)?/", "$1=\"http://$2", preg_replace("/(href|src)\=\"(?!(http|www|mailto|\/))(\/)?/", "$1=\"$path/$2", $document->getHtmlContent()));
                    $doc = new DOMDocument();
                    @$doc->loadHTML('<html><body>'.$body.'</body></html>');

                    $images = $doc->getElementsByTagName('img');

                    foreach ($images as $image) {
                        $image_path = $pub_path . $image->getAttribute('src');
                        $optimized = preg_replace('/(\.[^.]+)$/', sprintf('%s$1', '-optimized'), $image_path);
                        $thumbnail = preg_replace('/(\.[^.]+)$/', sprintf('%s$1', '-thumbnail'), $image_path);

                        if (!file_exists($optimized) || !file_exists($thumbnail)) {
                            $img = $manager->make($image_path);

                            if (!file_exists($optimized)) {

                                // Convert and optimize images
                                $img->encode(pathinfo($image_path)['extension'], 75)->resize(1920, null, function ($constraint) {
                                    $constraint->aspectRatio();
                                    $constraint->upsize();
                                });
                                $img->save($optimized);
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
                        $old_image_element = $doc->saveHTML($image);
                        $image->setAttribute('src', str_replace($pub_path, '', $optimized));
                        $image_element = $doc->saveHTML($image);

                        $new_stuff = '<a href="' . str_replace($pub_path, '', $image_path) . '">' . $image_element . '</a><span class="img-caption">' . $caption . '</span>';

                        // Replace the old with the new
                        $body = str_replace(substr($old_image_element, 0, -1).' />', $new_stuff, $body);
                    }

                    $links = $doc->getElementsByTagName('a');

                    foreach ($links as $link) {
                        // Check if link is relative
                        if (substr($link->getAttribute('href'), 0, 1) !== '/' && strpos($link->getAttribute('href'), 'http://') === false && strpos($link->getAttribute('href'), 'https://') === false && strpos($link->getAttribute('href'), 'www.') === false && strpos($link->getAttribute('href'), 'mailto:') === false) {
                            $old_link = $doc->saveHTML($link);
                            $link_path = $path . '/' . $link->getAttribute('href');
                            $link->setAttribute('href', $link_path);
                            $body = str_replace($old_link, $doc->saveHTML($link), $body);
                        } else if (substr($link->getAttribute('href'), 0, 1) !== '/') {
                            // Open external links in new tab/window
                            $old_link = $doc->saveHTML($link);
                            $link->setAttribute('target', '_blank');
                            $link->setAttribute('rel', 'noopener noreferrer');
                            $body = str_replace($old_link, $doc->saveHTML($link), $body);
                        }
                    }

                    $project = Project::create([
                        'date' => $document->get('date'),
                        'project_title' => ucfirst($document->get('title')),
                        'category' => $category,
                        'slug' => $slug,
                        'description' => ucfirst($document->get('description')),
                        'feature' => $feature,
                        'body' => $body,
                        'published' => $document->get('published') == 'false' || false,
                        'list_group' => $document->get('list-group'),
                        'list_title' => $document->get('list-title'),
                        'list_content' => $document->get('list-content'),
                        'type' => $type,
                        'style' => $style,
                        'transparent' => $document->get('transparent') == 'false' || false,
                        'sticky' => $document->get('sticky') == 'false' || false,
                        'seamless' => $document->get('seamless') == 'false' || false,
                    ]);
                }
            }
        }
    }
}
