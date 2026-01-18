<?php

use App\Engine\Libraries\Router;
use App\Engine\Libraries\Validation;
use App\Engine\Libraries\Languages;
use League\Plates\Template\Func;

$router = Router::getInstance();

$router->get('/', 'HomeController@index');


$router->get('words/add', function($req, $res)
{
    return $res->render('add', [
        'title' => Languages::translate('translations.add_word'),
        'lang' => Languages::class
    ]);
});


$router->post('words/add', function($req, $res)
{

    $validation = new Validation();

    $errors = $validation
            ->with($req->body())
            ->rules([
                'word|Word' => 'required|string|min[2]|max[200]',
                'translation|Translation' => 'required|string|min[2]|max[200]',
                'transcription|Transcription' => 'string|min[2]|max[200]',
                'note|Note' => 'string|min[10]|max[400]',
                'repeatable|Repeatable' => 'numeric|max[1]',
                'learned|Learned' => 'numeric|max[1]',
            ])
            ->validate();

    if (!empty($errors)) {
        setFlashData('errors', $errors);
        setForm($req->body());
        return $res->redirect(baseUrl('words/add'));
    }

    $model = initModel('word'); // init model
    $model->addWord($req->body()); // save

    setFlashData('success', 'სიტყვა წარმატებით დაემატა');

    return $res->redirect(baseUrl('words'));
});



$router->delete('words/(:num)', function($req, $res, $x1, $x2) {
    
    initModel('word');
    $word = R::findOne('word', 'id = ?', [$x2]) ?? abort();

    R::trash($word);

    setFlashData('success', 'სიტყვა წაიშალა');

    return $res->redirectBack();
});


// Search
$router->get('search', function($req, $res)
{    
    return $res->render('words', [
        'title' => Languages::translate('translations.search_results'),
        'data' => initModel('word')->search(query('word')),
        'lang' => Languages::class
    ]);
});


$router->get('words/(:num)/edit', function($req, $res, $x1, $x2, $x3)
{
    initModel('word');
    $word = R::findOne('word', 'id = ?', [$x2]) ?? abort();
    return $res->render('edit', [
        'word' => $word,
        'lang' => Languages::class
    ]);
});

$router->put('words/(:num)', function($req, $res, $x1, $x2)
{
    initModel('word');
    $word = R::findOne('word', 'id = ?', [$x2]) ?? abort();
    $word->import($req->body());
    R::store($word);

    setFlashData('success', Languages::translate('translations.word_added'));
    
    return $res->redirectBack();
});


$router->put('words/learned/(:num)', function($req, $res, $x1, $x2, $x3) {
    initModel('word')->addToLearned($x3);

    return $res->send(Languages::translate('translations.moved_to_learned'));
});


$router->put('words/not-learned/(:num)', function($req, $res, $x1, $x2, $x3) {
    initModel('word')->addToNotLearned($x3);

    return $res->send(Languages::translate('translations.moved_from_learned'));
});


$router->put('words/(:num)/do-not-show', function($req, $res, $x1, $x2, $x3) {
    initModel('word')->doNotShow($x2);

    return $res->send(Languages::translate('translations.word_disabled'));
});


$router->put('words/(:num)/repeatable/(:num)', function($req, $res, $x1, $x2, $x3, $x4) {
    initModel('word')->repeatableToggle($x2, $x4);

    $message = $x4 == 1 ? Languages::translate('translations.word_enabled') : Languages::translate('translations.word_disabled');

    return $res->send($message);
});



$router->get('words', function($req, $res) {
    return $res->render('words', [
        'title' => Languages::translate('translations.all_words'),
        'data' => initModel('word')->words(),
        'lang' => Languages::class,
        'class' => 'all-words'
    ]);
});


$router->get('words/learned', function($req, $res) {

    return $res->render('words', [
        'title' => Languages::translate('translations.learned_words'),
        'data' => initModel('word')->learned(),
        'lang' => Languages::class,
        'class' => 'word-list-item'
    ]);
});


$router->get('words/unlearned', function($req, $res) {

    return $res->render('words', [
        'title' => Languages::translate('translations.unknown_words'),
        'data' => initModel('word')->unlearned(),
        'lang' => Languages::class,
        'class' => 'word-list-item'
    ]);
});


$router->get('words/randomize', function($req, $res)
{
    return $res->send(initModel('word')->randomize(query('word_id')));
}, 
['Middlewares/checkAjax']);



$router->get('get-word/(:num)', function($req, $res, $x1, $x2) {
    initModel('word');
    return $res->send( R::findOne('word', 'id = ?', [$x2]));
});



$router->get('generate-setence/(:num)', function($req, $res, $x1, $wordID) {

    $wordData = initModel('word')->getWord($wordID);
    $word = strtolower($wordData->word);

    // Load all txt files from books directory
    $allBooks = glob(APPROOT . '/db/books/*.txt');

    $matches = [];

    foreach ($allBooks as $bookFile) {
        $fileContent = file_get_contents($bookFile);

        // Split into sentences
        $sentences = preg_split('/(?<=[.?!])\s+/', $fileContent);

        // Collect sentences containing the word
        foreach ($sentences as $sentence) {
            if (stripos($sentence, $word) !== false) {
                $matches[] = trim($sentence);
            }
        }
    }

    // Pick one random sentence from all matches
    $result = '';
    if (!empty($matches)) $result = $matches[array_rand($matches)];

    return $res->send([
        'total'     => count($matches),
        'sentences' => $matches,   // all matched sentences
        'sentence'  => $result     // one random sentence
    ]);




}, ['Middlewares/checkAjax']);