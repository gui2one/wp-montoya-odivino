<?php

include "".$_SERVER["DOCUMENT_ROOT"]."/wp-config.php";

function search_and_replace($search, $replace) {
    // echo "using ".shell_exec("where mysqldump");
    $cmd = "mysqldump -u ".DB_USER." --password=".DB_PASSWORD." -h ".DB_HOST." ".DB_NAME;

    $output = [];
    exec( $cmd, $output);
    $string =implode("\n",  $output);
    $string = str_replace($search, $replace, $string);
    // print_r($string);
    return $string;
}

?>