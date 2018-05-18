<?php
// PHP Simple HTML DOM Parser
require_once('./simple_html_dom.php');

$url = 'https://no1s.biz/';

$url_list = [];

crawle($url, $url_list);

function crawle($url, $url_list) {
    $html = file_get_html($url);
    mb_language('Japanese');
    $contents = file_get_contents($url);
    $content = mb_convert_encoding($contents, 'UTF-8', 'auto');
    $html = str_get_html($content);
    foreach ($html->find('a') as $list) {
        if (!preg_match("/^https\:\/\/no1s\.biz\//", $list->href)) continue;
        if (array_search($list->href, $url_list)) continue;
        $url_list[] = $list->href;
        $html->clear();
        unset($html);
        crawle($list->href, $url_list);
    }
}

$url_list_2 = array_unique($url_list);

foreach ($url_list_2 as $url_2) {
    $contents = file_get_contents($url);
    $content = mb_convert_encoding($contents, 'UTF-8', 'auto');
    $html = str_get_html($content);
    echo $url_2 . " " . $html->find('title', 0);
}

