<?php

function theme_path() {
    return base_path().'/public/themes/'.Config::get('bbb_config.theme');
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
        if (is_numeric($lastm)) {
            echo '<'.$element.' class="active">'.ucfirst(strtolower(ltrim($lastm, '0'))).ordinal_suffix($lastm).'</'.$element.'>';
        } else {
            echo '<'.$element.' class="active">'.ucfirst(strtolower(ltrim($lastm, '0'))).'</'.$element.'>';
        }
    } else {
        echo '<'.$element.'><a href="/blog/'.$group[0].'/'.$group[1].'/'.$last.'">'.ucfirst(strtolower(ltrim($lastm, '0'))).ordinal_suffix($lastm).'</a></'.$element.'>';
    }

}
