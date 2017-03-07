<?php

$truncate_filter = new Twig_SimpleFilter('truncate', function ($string, $limit) {
    if (strlen($string) > $limit) {
        return substr($string, 0, $limit - 3) . '...';
    } else {
        return $string;
    }
});
$this->twig->addFilter($truncate_filter);