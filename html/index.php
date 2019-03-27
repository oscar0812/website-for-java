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

$app->get('/json', function ($request, $response, $args) {
    $scenes = \SceneQuery::create()->orderByPlacement()->find();
    return $response->withJson($scenes->toArray());
})->setName('json');

$app->post('/item-dropped', function ($request, $response, $args) {
    $params = $request->getParsedBody();
    $oldIndex = -1;
    $newIndex = intval($params['new_index']);
    $scenes = \SceneQuery::create()->orderByPlacement()->find();

    $index = 1;
    foreach ($scenes as $scene) {
        if ($newIndex == $index && $scene->getId() != $params['id']) {
            // this is were the item is supposed to go, so just place the item
            // we are looking at in the next index
            $scene->setPlacement(++$index);
        }
        if ($scene->getId() == $params['id']) {
            // found the item we were looking for
            $oldIndex = $scene->getPlacement();
            $scene->setPlacement($newIndex);
            if ($newIndex <= $index) {
                // if we moved item back we have to increment the index to
                // push other elements one back
                $index++;
            }
        } else {
            // base case, just set index as incremental
            $scene->setPlacement($index++);
        }
    }

    $scenes->save();

    return $response->withJson(['success'=>true, 'from'=>$oldIndex, 'to'=>$newIndex]);
})->setName('item-dropped');

$app->run();
