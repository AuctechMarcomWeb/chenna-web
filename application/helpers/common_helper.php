<?php
if (!function_exists('slugify'))
{
    function slugify($text)
{
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text); // remove special chars like &, @, etc.
    $text = preg_replace('/\s+/', '-', $text); // replace spaces with hyphen
    $text = trim($text, '-');
    return $text;
}
}
?>