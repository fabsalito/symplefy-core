<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

// enable debug mode
$app['debug'] = true;

// define data
$people = array(
    1 => array(
        'date'      => '2011-03-29',
        'author'    => 'igorw',
        'title'     => 'Using Silex',
        'body'      => '...',
    ),
    2 => array(
        'date'      => '2014-03-03',
        'author'    => 'c.lsalin',
        'title'     => 'Using Silex :D',
        'body'      => '...',
    ),
    3 => array(
        'date'      => '2008-02-08',
        'author'    => 'franca',
        'title'     => 'Growing',
        'body'      => '...',
    ),
);

//// RESTful definitions
// GET (read)
$app->get('/people/{id}', function(Request $request, $id) use($people) {
    if (null == $id){
        return new Response(json_encode($people), 200);
    }
    else{
        if (array_key_exists($id, $people)){
            $response[] = $people[$id]['date'];
            $response[] = $people[$id]['author'];
            $response[] = $people[$id]['title'];
            $response[] = $people[$id]['body'];

            return new Response(json_encode($response), 200);
        }
        else{
            return new Response('Object not found!', 404);
        }

        
    }
})->value('id', null);

// POST (create)
$app->post('/people', function(Request $request) use($people) {

    // get previous length
    $prevLength = count($people);

    // define new people
    $newPeople['date'] = $request->get('date');
    $newPeople['author'] = $request->get('author');
    $newPeople['title'] = $request->get('title');
    $newPeople['body'] = $request->get('body');

    // create a new people
    $people[] = $newPeople;

    // print_r($people);

    return new Response('Create new people! (before = '. $prevLength . ' | now = '. count($people) .')', 201);
    // return new Response('Create new people!', 201);
});

// PUT (update)
$app->put('/people/{id}', function(Request $request, $id) use($people) {
    return new Response('Update ID = '. $request->get('id') . '!', 202);
});

// DELETE (delete)
$app->delete('/people/{id}', function($id) use($people) {
    return new Response('Delete ID = '. $id . '!', 202);
});

// run app
$app->run();
