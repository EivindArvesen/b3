<?php
use App\Models\Blogpost;
use App\Models\Page;

use Illuminate\Database\Eloquent\Collection;

function theme_path() {
    return base_path().'/public/themes/'.Config::get('bbb_config.theme');
}

function getMenu() {
  try {
    $menu = Page::where('type', 'index')->get(['page_title', 'slug', 'type']);
    $menu[0]->slug = '';
  } catch (ErrorException $e) {
    $menu = new Collection;
  }

  $blog = new \stdClass;
  $blog->page_title = 'Blog';
  $blog->slug = 'blog';
  $blog->type = 'collection';
  $menu->add($blog);

  $projects = new \stdClass;
  $projects->page_title = 'Projects';
  $projects->slug = 'projects';
  $projects->type = 'collection';
  $menu->add($projects);

  foreach (Page::where('type', '!=', 'index')->get(['page_title', 'slug', 'type']) as $element) {
    $menu->add($element);
  }

  return $menu;
}

function ordinal_suffix($num){
    $num = $num % 100; // protect against large numbers
    if($num < 11 || $num > 13){
         switch($num % 10){
            case 1: return 'st';
            case 2: return 'nd';
            case 3: return 'rd';
        }
    }
    return 'th';
}

function date_links($group, $element) {
    $last = array_pop($group);
    foreach ($group as $key => $g) {
      if ($key>0&&$group[$key-1]) $prev=$group[$key-1].'/';
      else $prev='';
      if ($key==1) $m=DateTime::createFromFormat('!m', $g)->format('F');
      else $m=$g;
      echo '<'.$element.'><a href="/blog/'.$prev.$g.'">'.$m.'</a></'.$element.'>';
    }
    if (count($group)==1) $lastm=DateTime::createFromFormat('!m', $last)->format('F');
    else $lastm=$last;
    if ($element=="li") {
        if (is_numeric($lastm) && strlen($lastm)!==4) {
            echo '<'.$element.' class="active">'.ucfirst(strtolower(ltrim($lastm, '0'))).ordinal_suffix($lastm).'</'.$element.'>';
        } else {
            echo '<'.$element.' class="active">'.ucfirst(strtolower(ltrim($lastm, '0'))).'</'.$element.'>';
        }
    } else {
        echo '<'.$element.'><a href="/blog/'.$group[0].'/'.$group[1].'/'.$last.'">'.ucfirst(strtolower(ltrim($lastm, '0'))).ordinal_suffix($lastm).'</a></'.$element.'>';
    }

}

function read_time($id, $only_minutes = false, $short = false) {
  // Originally by Brian Cray: http://briancray.com/posts/estimated-reading-time-web-design/
  $content = Blogpost::where('post_id', $id)->get(['body'])->first();
  $word = str_word_count(strip_tags($content));
  if ($only_minutes) {
    $m = ceil($word / 200);
    $est = $m . ' ' . ($short ? 'min' : 'minute' . ($m == 1 ? '' : 's'));
  } else {
    $m = floor($word / 200);
    $s = floor($word % 200 / (200 / 60));
    $est = $m . ' ' . ($short ? 'min' : 'minute' . ($m == 1 ? '' : 's')) . ', ' . $s . ' ' . ($short ? 'sec' : 'second' . ($s == 1 ? '' : 's'));
  }
  return $est;
}

function get_intro($id) {
  $post_object = Blogpost::where('post_id', $id)->get(['cover', 'lead', 'body'])[0];
  $post = $post_object['body'];

  $string_pp = substr($post, 0, 180);

  preg_match_all('/<p><img[^>]+><\/p>/i',$string_pp, $image);
  $string = str_replace($image[0], '', $string_pp);

  if ($post_object['cover'] && $post_object['cover'] !== '') {
    $image[0] = array('<img class="cover" src="' . $post_object['cover'] . '"/>');
  }

  if ($post_object['lead'] && $post_object['lead'] !== '') {
    $first_chunk = '<h3 class="lead">'.$post_object['lead'].'</h3>';
  } else {
    $last_space = strrpos($string, ' ');
    $last_word = substr($string, $last_space);
    $first_chunk = substr($string, 0, $last_space) . '...';
  }

  return implode($image[0]).$first_chunk;
}
