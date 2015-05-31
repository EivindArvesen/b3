<?php

function theme_path() {
    return base_path().'/public/themes/'.Config::get('bbb_config.theme');;
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
        echo '<'.$element.' class="active">'.ucfirst(strtolower($lastm)).'</'.$element.'>';
    } else {
        echo '<'.$element.'><a href="/blog/'.$group[0].'/'.$group[1].'/'.$last.'">'.ucfirst(strtolower($lastm)).'</a></'.$element.'>';
    }

}
