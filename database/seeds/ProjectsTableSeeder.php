<?php

# database/seeds/PagesTableSeeder.php

use App\Models\Project;
use Illuminate\Database\Seeder;
use Kurenai\DocumentParser;

class ProjectsTableSeeder extends Seeder
{
    public function run()
    {

        // update tables instead of overwriting (think timestamps, original...)

        $parser = new DocumentParser;
        $it = new RecursiveDirectoryIterator(realpath(dirname(dirname(dirname(__FILE__)))."/storage/app/projects"));
        $display = Array ( 'md' );
        foreach(new RecursiveIteratorIterator($it) as $file)
        {
            $exp = explode('.', $file);
            if (basename($file)!=='.' && basename($file)!=='..' && in_array(strtolower(array_pop($exp)), $display)) {
                $original_date = basename(dirname(dirname(dirname($file)))) . '-' . basename(dirname(dirname($file))) . '-' . basename(dirname($file));

                $source = file_get_contents($file);
                $document = $parser->parse($source);

                if ($document->get('slug')) {
                    $slug = substr(str_replace('+', '-', urlencode(strtolower(preg_replace("#[[:punct:]]#", "-", $document->get('slug'))))), 0, 50);
                } else {
                    $slug = substr(str_replace('+', '-', urlencode(strtolower(preg_replace("#[[:punct:]]#", "-", $document->get('title'))))), 0, 50);
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

                $project = Project::create([
                    'date' => $document->get('date'),
                    'project_title' => ucfirst($document->get('title')),
                    'category' => $category,
                    'slug' => $slug,
                    'description' => ucfirst($document->get('description')),
                    'body' => $document->getHtmlContent(),
                    'published' => $document->get('published') == 'false' || false,
                    'list_title' => $document->get('list-title'),
                    'list_content' => $document->get('list-content'),
                    'type' => $type,
                    'style' => $style,
                    'transparent' => $document->get('transparent') == 'false' || false,
                ]);
            }
        }
    }
}
