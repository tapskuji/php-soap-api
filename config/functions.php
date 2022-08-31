<?php

function url_for($script_path) {
    if($script_path[0] != '/') {
        $script_path = "/" . $script_path;
    }
    return WWW_ROOT . $script_path;
}

function safe_html($string = "") {
    return htmlspecialchars($string);
}

function redirect($location) {
    header('Location: ' . $location);
    exit();
}