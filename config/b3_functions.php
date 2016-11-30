<?php
use App\Models\Blogpost;
use App\Models\Page;

use Illuminate\Database\Eloquent\Collection;

function theme_path() {
    return base_path().'/public/themes/'.Config::get('b3_config.theme');
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

function breadcrumb_links($group) {
    $last = array_pop($group);
    foreach ($group as $key => $g) {
      if ($key>0&&$group[$key-1]) $prev=$group[$key-1].'/';
      else $prev='';
      if ($key==1) $m=DateTime::createFromFormat('!m', $g)->format('F');
      else $m=$g;
      echo '<li><a href="/blog/'.$prev.$g.'">'.$m.'</a></li>';
    }
    if (count($group)==1) $lastm=DateTime::createFromFormat('!m', $last)->format('F');
    else $lastm=$last;

    if (is_numeric($lastm) && strlen($lastm)!==4) {
        echo '<li class="active">'.ucfirst(strtolower(ltrim($lastm, '0'))).ordinal_suffix($lastm).'</li>';
    } else {
        echo '<li class="active">'.ucfirst(strtolower($lastm)).'</li>';
    }
}

function date_links($group, $format=false) {
  if (isset($format) && $format ==! false) {
    $order = $format;
  } else {
    $order = config('b3_config.date-format');
  }

    $result = array();
    $last = array_pop($group);
    foreach ($group as $key => $g) {
      if ($key>0&&$group[$key-1]) $prev=$group[$key-1].'/';
      else $prev='';
      if ($key==1) $m=DateTime::createFromFormat('!m', $g)->format('F');
      else $m=$g;
      array_push($result, '<span><a href="/blog/'.$prev.$g.'">'.$m.'</a></span>');
    }
    if (count($group)==1) $lastm=DateTime::createFromFormat('!m', $last)->format('F');
    else $lastm=$last;
    array_push($result, '<span><a href="/blog/'.$group[0].'/'.$group[1].'/'.$last.'">'.ucfirst(strtolower(ltrim($lastm, '0'))).ordinal_suffix($lastm).'</a></span>');

    if (isset($order) && strlen($order) == count($group)+1) {
      switch (strtolower($order)) {
        case 'dmy':
          $last = array_pop($result);
          $result = array_reverse($result);
          array_unshift($result, '<span>of</span>');
          $result = array_merge([$last], $result);
          break;

        case 'mdy':
          $result = array_merge(array_slice($result, 1), [$result[0]]);
          break;

        // case 'ymd':
        default:
          break;
      }
    }

    foreach ($result as $key => $value) {
      echo $value;
    }
}

function month_name($month) {
  return date('F', mktime(0, 0, 0, $month, 10));
}

function format_time($modified_at, $format=false) {
  if (isset($format) && $format ==! false) {
    $order = $format;
  } else {
    $order = config('b3_config.date-format');
  }

  $year = substr($modified_at, 0, 4);
  $month = month_name(substr($modified_at, 5, 2));
  $day = ltrim(substr($modified_at, 8, 2), '0') . ordinal_suffix(ltrim(substr($modified_at, 8, 2), '0'));

  if (isset($order) && strlen($order) == 3) {
      switch (strtolower($order)) {
        case 'dmy':
          $edited = $day . ' of ' . $month . ' ' . $year;
          break;

        case 'mdy':
          $edited = $month . ' ' . $day . ' ' . $year;
          break;

        // case 'ymd':
        default:
          $edited = $year . ' ' . $month . ' ' . $day;
          break;
      }
  } else {
    $edited = $year . ' ' . $month . ' ' . $day;
  }

  return $edited;
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

  $string_pp = substr($post, 0, 500);

  preg_match_all('/<img[^>]+>/i', $string_pp, $image);

  $string = preg_replace('/<img[^>]+>/i', '', $string_pp);

  if ($post_object['cover'] && $post_object['cover'] !== '') {
    $image[0] = array('<figure class="cover-img" style="background-image: url(' . $post_object['cover'] . ')"></figure>');
  }

  if ($post_object['lead'] && $post_object['lead'] !== '') {
    if (strlen($post_object['lead']) > 180) {

      $lead_piece = substr($post_object['lead'], 0, 180) . '...';
      $last_space = strrpos($lead_piece, ' ');
      $last_word = substr($lead_piece, $last_space);
      $lead = substr($lead_piece, 0, $last_space) . '...';

    } else {
      $lead = $post_object['lead'];
    }
    $first_chunk = '<h3 class="lead">'.$lead.'</h3>';
  } else {
    $string = substr($string, 0, 255);
    $last_space = strrpos($string, ' ');
    $last_word = substr($string, $last_space);
    $first_chunk = substr($string, 0, $last_space) . '...';
  }

  return implode($image[0]).$first_chunk;
}

function slugify($string) {
  return substr(str_replace('+', '-', urlencode(strtolower(preg_replace("#[[:punct:]]#", "-", $string)))), 0, 50);
}
