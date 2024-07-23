<?php
        
class Model_Word extends RedBean_SimpleModel {

    public function open() {
        
    }

    public function dispense() {
        
    }

    public function update() {
        
    }

    public function after_update() {
        
    }

    public function delete() {
        
    }

    public function after_delete() {
        
    }


    public function migrate()
    {
        R::exec('SET FOREIGN_KEY_CHECKS = 0;');
        R::nuke();

        $word = R::dispense('word');
        $word->import([
            'word' => '',
            'translation' => '',
            'transcription' => '',
            'repeatable' => 1,
            'learned' => 0
        ]);

        R::store($word);
        R::wipe('word');
    }



    public function addWord($wordData)
    {
        $wordData['repeatable'] = 1;
        $wordData['learned'] = 0;
        $model = R::dispense('word');
        $model->import($wordData);

        R::store($model);
    }


    public function words()
    {
        $totalPages = R::count('word');
        $currentPage = $_GET["page"] ?? 1;
        if ($currentPage < 1 OR $currentPage > $totalPages) $currentPage = 1;
        $limit = 12;
        $offset = ($currentPage - 1) * $limit;  
        $pagingData = pager([
            'total' => $totalPages,
            'limit' => $limit,
            'current' => $currentPage
        ]); 
        $pages = R::find("word", "order by id desc limit $limit offset $offset");

        $obj = new stdClass();
        $obj->pager = $totalPages > $limit ? $pagingData : null;
        $obj->data = $pages;
        return $obj;
    }



    public function learned()
    {
        $totalPages = R::count('word', 'learned = ?', [1]);
        $currentPage = $_GET["page"] ?? 1;
        if ($currentPage < 1 OR $currentPage > $totalPages) $currentPage = 1;
        $limit = 12;
        $offset = ($currentPage - 1) * $limit;  
        $pagingData = pager([
            'total' => $totalPages,
            'limit' => $limit,
            'current' => $currentPage
        ]); 
        $pages = R::find("word", "learned = 1 order by id desc limit $limit offset $offset");

        $obj = new stdClass();
        $obj->pager = $totalPages > $limit ? $pagingData : null;
        $obj->data = $pages;
        return $obj;
    }



    public function unlearned()
    {
        $totalPages = R::count('word', 'learned = ?', [0]);
        $currentPage = $_GET["page"] ?? 1;
        if ($currentPage < 1 OR $currentPage > $totalPages) $currentPage = 1;
        $limit = 12;
        $offset = ($currentPage - 1) * $limit;  
        $pagingData = pager([
            'total' => $totalPages,
            'limit' => $limit,
            'current' => $currentPage
        ]); 
        $pages = R::find("word", "learned = 0 order by id desc limit $limit offset $offset");

        $obj = new stdClass();
        $obj->pager = $totalPages > $limit ? $pagingData : null;
        $obj->data = $pages;
        return $obj;
    }


    public function randomize($prevID = 0)
    {
        return R::findOne("word", "repeatable = 1 AND id != ".$prevID." ORDER BY RANDOM()");
    }


    public function addToLearned($wordID)
    {
        $word = R::load('word', $wordID);
        $word->learned = 1;
        $word->repeatable = 0;
        R::store($word);
    }


    public function addToNotLearned($wordID)
    {
        $word = R::load('word', $wordID);
        $word->learned = 0;
        $word->repeatable = 1;
        R::store($word);
    }


    public function doNotShow($wordID)
    {
        $word = R::load('word', $wordID);
        $word->repeatable = 0;
        R::store($word);
    }

    public function repeatableToggle($wordID, $isTrue)
    {
        $word = R::load('word', $wordID);
        $word->repeatable = $isTrue;
        R::store($word);
    }
}