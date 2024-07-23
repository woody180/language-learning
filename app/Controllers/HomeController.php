<?php namespace App\Controllers;

use \R as R;
use App\Engine\Libraries\Languages;

class HomeController {
    
    public function index($req, $res) {
        
        // Render view
        return $res->render('welcome', [
            'word' => initModel('word')->randomize(),
            'lang' => Languages::class
        ]);
    }
}