<?php

//name="url"
//comment-form-url

include 'simple_html_dom.php';


$backlinks = file("backlinks.csv");
$h = fopen("res.csv", "w");

foreach ($backlinks as $link) {
    $ok = 'bad';
    $link = str_replace("\n", "", $link);
    $link = str_replace("\r", "", $link);
    $html = file_get_html($link);
    $parse = parse_url($link);
    if(isset($host[$parse['host']])) {
        continue;
    }
    @$host[$parse['host']]=1;
    
    if ($html) {
        
        if (strpos($html, 'comment-form-url') !== FALSE) {
            $ok = 'good';
        }

        if (strpos($html, 'name="url"') !== FALSE) {
            $ok = 'good';
        }
        
        if (strpos($html, 'nofollow') !== FALSE) {
            $ok = 'nofollow';
        }
        
       
    }
    if($ok == 'good' OR $ok == 'nofollow') {
		fwrite($h, $link . ";" . $ok . "\n");
    }
}


