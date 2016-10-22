<?php

set_time_limit(0);

require_once __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/../app/app.php';


$response = $application->run(new \Application\Request\HttpRequest($_SERVER));
$response->flush();


function pa($arr) {
    echo '<pre>';
    print_r($arr);
    echo "</pre>";
}