<?php
if (!function_exists('slugify'))
{
    function slugify($string)
    {

        $string = strtolower($string);


        $string = preg_replace('/[^a-z0-9]+/', '-', $string);


        $string = preg_replace('/-+/', '-', $string);


        $string = trim($string, '-');

        return $string;
    }
}
?>