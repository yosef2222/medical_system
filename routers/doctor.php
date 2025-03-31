<?php
function route($method, $urlList, $requestData)
{
    $router = $urlList[1];
    if (file_exists(realpath(dirname(__FILE__)) . '/' . $router . '.php')) {
        include_once realpath(dirname(__FILE__)) . '/' . $router . '.php';
        excute(getMethod(), $urlList, $requestData);
    } else if ($router == "logout") {
        include_once realpath(dirname(__FILE__)) . '/' . 'login' . '.php';
        excute(getMethod(), $urlList, $requestData);
    } else {
        echo "router is:" . $router . " this is";

        echo "\nnot found";
    }
}
