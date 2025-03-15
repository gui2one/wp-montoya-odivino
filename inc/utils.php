<?php

function js_file_make_module($file_tag)
{
    add_filter('script_loader_tag', function ($tag, $handle) use ($file_tag) {
        if ($handle !== $file_tag) {
            return $tag;
        }
        return str_replace('src=', 'type="module" src=', $tag);
    }, 10, 2);
}
