<?php

use app\controllers\LoggedInController;

require '../vendor/autoload.php';

// adding an external config file
require '../functions.php';

require '../data/generated-conf/config.php';

$config['displayErrorDetails'] = true;

$app = new \Slim\App(["settings" => $config]);

$container = $app->getContainer();
$container['view'] = new \Slim\Views\PhpRenderer("../app/views/");

$app->get('/', function ($request, $response, $args) {
    $scenes = \SceneQuery::create()->orderByPlacement()->find();
    return $this->view->render($response, 'home.php', ['router'=>$this->router, 'scenes'=>$scenes]);
})->setName('home');

$app->post('/item-dropped', function ($request, $response, $args) {
    $params = $request->getParsedBody();
    \Scene::orderPlacement($params['id'], intval($params['new_index']));

    return $response->withJson(['success'=>true, 'from'=>$oldIndex, 'to'=>$newIndex]);
})->setName('item-dropped');

// get all items and traps and scenes
$app->get('/json', function ($request, $response, $args) {
    $params = $request->getParsedBody();
    $traps = \TrapQuery::create()->find();
    $items = \ItemQuery::create()->find();
    $scenes = \SceneQuery::create()->find();

    return $response->withJson(['traps'=>$traps->toArray(),
  'items'=>$items->toArray(), 'scenes'=>$scenes->toArray()]);
})->setName('json');

// add new row to database
$app->post('/add', function ($request, $response, $args) {
    $params = $request->getParsedBody();

    if ($params['type'] == 'trap') {
        $trap = new \Trap();
        $trap->setName($params['name']);
        $trap->setDescription($params['description']);
        $trap->setDamage($params['damage']);

        $trap->save();
    } elseif ($params['type'] == 'item') {
        $item = new \Item();
        $item->setName($params['name']);
        $item->setDescription($params['description']);

        $item->save();
    } elseif ($params['type'] == 'scene') {
        $scene = new \Scene();
        $scene->setItemId($params['item_choice']);
        $scene->setTrapId($params['trap_choice']);
        $scene->setDescription($params['description']);
        $scene->setParentSceneId($params['parent_choice']);


        $scene->save();
        \Scene::orderPlacement($scene->getId(), 1);
        $params['id'] = $scene->getId();
    }

    return $response->withJson(['success'=>true, 'params'=>$params]);
})->setName('add');

$app->run();
