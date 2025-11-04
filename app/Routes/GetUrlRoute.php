<?php

use App\Engine\Libraries\Router;

$router = Router::getInstance();


$router->get('previous-page', function($req, $res) {


    return $res->send([
        'status' => 'success',
        'url' => getFlashData('previous_url')
    ]);

}, 'Middlewares/checkAjax');