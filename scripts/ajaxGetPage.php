<?php

require_once '../inc/config.inc.php';
$page = "hp";

//access rule: if TRUE - user can see this page, else - he can't
$access_rule = true;

//pages that requires access check
$access_pages = [
    "admin",
    "subsub/subpage"
];

if ($connect) {

    $url = $_POST["url"];

    if ($url !== "/") {
        try {
            $uri_parts = explode('/', trim($url, ' /'));
            $page = array_shift($uri_parts);
            $get_values = array();

            if (count($uri_parts) % 2) {
                throw new Exception();
            }

            for ($i = 0; $i < count($uri_parts); $i++) {
                $get_values[$uri_parts[$i]] = $uri_parts[++$i];
            }

            $_GET = $get_values;

            if (substr_count($page, ".") == 1) {
                $page = str_replace(".", "/", $page);
            }

            if (!file_exists(realpath('../pages/' . $page . '.php'))) {
                throw new Exception();
            }
        } catch (Exception $ex) {
            $page = "404";
            $_GET = array();
        }
    }

    if (in_array($page, $access_pages) && !$access_rule) {
        $page = "access_error";
    }
} else {
    $page = "connect_error";
}

include '../pages/' . $page . '.php';


