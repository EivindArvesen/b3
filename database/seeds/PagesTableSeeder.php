<?php

# database/seeds/PagesTableSeeder.php

use App\Models\Page;
use Illuminate\Database\Seeder;
use Kurenai\DocumentParser;

class PagesTableSeeder extends Seeder
{
    public function run()
    {

        // update tables instead of overwriting (think timestamps, original...)

        $parser = new DocumentParser;
        $it = new RecursiveDirectoryIterator(realpath(dirname(dirname(dirname(__FILE__)))."/public/content/pages"));
        $display = Array ( 'md' );
        foreach(new RecursiveIteratorIterator($it) as $file)
        {
            $exp = explode('.', $file);
            if (basename($file)!=='.' && basename($file)!=='..' && in_array(strtolower(array_pop($exp)), $display)) {
                $original_date = basename(dirname(dirname(dirname($file)))) . '-' . basename(dirname(dirname($file))) . '-' . basename(dirname($file));

                if ($file == realpath("./storage/app/pages") . 'index.md') {
                    $type = 'index';
                }

                $source = file_get_contents($file);
                $document = $parser->parse($source);

                // Build absolute path to content
                $path = dirname(explode("/public", $file)[1])."/";

                if ($document->get('slug')) {
                    $slug = substr(str_replace('+', '-', urlencode(strtolower(preg_replace("#[[:punct:]]#", "-", $document->get('slug'))))), 0, 50);
                } else {
                    $slug = substr(str_replace('+', '-', urlencode(strtolower(preg_replace("#[[:punct:]]#", "-", $document->get('title'))))), 0, 50);
                }

                if ($document->get('cover')) {
                    // Fix cover-meta
                    $cover = $path . '/' . ltrim($document->get('cover'), '/');
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
                $body = preg_replace("/(href|src)\=\"([^(http|www)])(\/)?/", "$1=\"$path/$2", $document->getHtmlContent());

                $page = Page::create([
                    'page_title' => ucfirst($document->get('title')),
                    'slug' => $slug,
                    'cover' => $cover,
                    'body' => $body,
                    'published' => $document->get('published') == 'false' || false,
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
