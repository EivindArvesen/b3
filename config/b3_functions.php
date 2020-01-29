<?php
use App\Models\Blogpost;
use App\Models\Page;

use Illuminate\Database\Eloquent\Collection;

function theme_path() {
    return base_path().'/public/themes/'.Config::get('b3_config.theme');
}

function getFirstImage($body) {
    $match = preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $body, $image);
    if ($match) {
      return $image['src'];
    } else {
      return '';
    }
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

  ob_start();
  addslashes(printTruncated(255, $post) . '...');
  $string_pp = ob_get_contents();
  ob_end_clean();

  preg_match_all('/<img[^>]+>/i', $string_pp, $image);

  $string = preg_replace('/<img[^>]+>/i', '', $string_pp);

  if ($post_object['cover'] && $post_object['cover'] !== '') {
    $image[0] = array('<figure class="cover-img" style="background-image: url(' . preg_replace('/(\.[^.]+)$/', sprintf('%s$1', '-thumbnail'), str_replace('-optimized.', '.', $post_object['cover'])) . ')"></figure>');
  } else if ($image[0]) {
    $dom = new DOMDocument();
    $dom->loadHTML($image[0][0]);
    $dom->getElementsByTagName('img')->item(0)->setAttribute('src', preg_replace('/(\.[^.]+)$/', sprintf('%s$1', '-thumbnail'), str_replace('-optimized.', '.', $dom->getElementsByTagName('img')->item(0)->getAttribute('src'))));
      $image[0] = array(substr($dom->saveHTML($dom->getElementsByTagName('img')->item(0)), 0, -1).' />');
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
    $last_space = strrpos($string, ' ');
    $last_word = substr($string, $last_space);
    $first_chunk = substr($string, 0, $last_space) . '...';
  }

  return implode($image[0]).$first_chunk;
}

function printTruncated($maxLength, $html, $isUtf8=true)
{
    // https://stackoverflow.com/questions/1193500/truncate-text-containing-html-ignoring-tags
    $printedLength = 0;
    $position = 0;
    $tags = array();

    // For UTF-8, we need to count multibyte sequences as one character.
    $re = $isUtf8
        ? '{</?([a-z]+)[^>]*>|&#?[a-zA-Z0-9]+;|[\x80-\xFF][\x80-\xBF]*}'
        : '{</?([a-z]+)[^>]*>|&#?[a-zA-Z0-9]+;}';

    while ($printedLength < $maxLength && preg_match($re, $html, $match, PREG_OFFSET_CAPTURE, $position))
    {
        list($tag, $tagPosition) = $match[0];

        // Print text leading up to the tag.
        $str = substr($html, $position, $tagPosition - $position);
        if ($printedLength + strlen($str) > $maxLength)
        {
            print(substr($str, 0, $maxLength - $printedLength));
            $printedLength = $maxLength;
            break;
        }

        print($str);
        $printedLength += strlen($str);
        if ($printedLength >= $maxLength) break;

        if ($tag[0] == '&' || ord($tag) >= 0x80)
        {
            // Pass the entity or UTF-8 multibyte sequence through unchanged.
            print($tag);
            $printedLength++;
        }
        else
        {
            // Handle the tag.
            $tagName = $match[1][0];
            if ($tag[1] == '/')
            {
                // This is a closing tag.

                $openingTag = array_pop($tags);
                assert($openingTag == $tagName); // check that tags are properly nested.

                print($tag);
            }
            else if ($tag[strlen($tag) - 2] == '/')
            {
                // Self-closing tag.
                print($tag);
            }
            else
            {
                // Opening tag.
                print($tag);
                $tags[] = $tagName;
            }
        }

        // Continue after the tag.
        $position = $tagPosition + strlen($tag);
    }

    // Print any remaining text.
    if ($printedLength < $maxLength && $position < strlen($html))
        print(substr($html, $position, $maxLength - $printedLength));

    // Close any open tags.
    while (!empty($tags))
        printf('</%s>', array_pop($tags));
}

function getDescription($body) {
  $string_pp = substr($body, 0, 255);

  $string = substr(strip_tags($string_pp), 0, 67);
  $last_space = strrpos($string, ' ');
  $last_word = substr($string, $last_space);
  $first_chunk = substr($string, 0, $last_space) . '...';

  return $first_chunk;
}

function projectThumbnail($image) {
  return substr_compare($image, '.gif', strlen($image)-strlen('.gif'), strlen('.gif')) === 0 ? str_replace('-optimized', '', $image) : str_replace('-optimized', '-thumbnail', $image);
}

function projectHero($image) {
  return substr_compare($image, '.gif', strlen($image)-strlen('.gif'), strlen('.gif')) === 0 ? str_replace('-optimized', '', $image) : $image;
}

function slugify($string) {
  return substr(str_replace('+', '-', urlencode(strtolower(preg_replace("#[[:punct:]]#", "-", $string)))), 0, 50);
}
