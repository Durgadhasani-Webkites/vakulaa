<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function url_title($str, $separator = '-', $lowercase = FALSE)
{
    if ($separator == 'dash')
    {
        $separator = '-';
    }
    else if ($separator == 'underscore')
    {
        $separator = '_';
    }

    $q_separator = preg_quote($separator);

    $trans = array(
        '.+?;'                 => '',
        '&'                 => 'and',
        '[^a-z0-9 _-]'          => '',
        '\s+'                   => $separator,
        '('.$q_separator.')+'   => $separator
    );

    $str = strip_tags($str);

    foreach ($trans as $key => $val)
    {
        $str = preg_replace("#".$key."#i", $val, $str);
    }

    if ($lowercase === TRUE)
    {
        $str = strtolower($str);
    }
    return strtolower(trim($str, $separator));
}