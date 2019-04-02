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

function getAllArray()
{
    $traps = \TrapQuery::create()->find();
    $items = \ItemQuery::create()->find();
    $scenes = \SceneQuery::create()->find();

    return ['traps'=>$traps->toArray(), 'items'=>$items->toArray(), 'scenes'=>$scenes->toArray()];
}

// get all items and traps and scenes
$app->get('/json', function ($request, $response, $args) {
    return $response->withJson(getAllArray());
})->setName('json');

$app->post('/scene-info', function ($request, $response, $args) {
    $params = $request->getParsedBody();
    if (isset($params['id'])) {
        $scene = \SceneQuery::create()->findOneById($params['id']);
        if ($scene == null) {
            return $response->withJson(['success'=>false, 'msg'=>'Null Scene']);
        }

        return $response->withJson(['success'=>true, 'scene'=>$scene->toArray(), 'info'=>getAllArray()]);
    }

    return $response->withJson(['success'=>false]);
})->setName('scene-info');

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
        if (isset($params['scene_id'])) {
            $scene = \SceneQuery::create()->findOneById($params['scene_id']);
        } else {
            $scene = new \Scene();
        }
        $scene->setItemId($params['item_choice']);
        $scene->setTrapId($params['trap_choice']);
        $scene->setDescription($params['description']);
        $scene->setParentSceneId($params['parent_choice']);


        $scene->save();
        if (!isset($params['scene_id'])) {
            \Scene::orderPlacement($scene->getId(), 1);
        }
        $params['id'] = $scene->getId();
    }

    return $response->withJson(['success'=>true, 'params'=>$params]);
})->setName('add');

// delete scene
$app->post('/delete-scene', function ($request, $response, $args) {
    $params = $request->getParsedBody();

    if (isset($params['id'])) {
        $scene = \SceneQuery::create()->findOneById($params['id']);
        if ($scene == null) {
            return $response->withJson(['success'=>false, 'msg'=>'Null Scene']);
        }

        $children = \SceneQuery::create()->findByParentSceneId($scene->getId());

        foreach ($children as $child) {
            $child->setParentSceneId(0);
        }

        $scene->delete();
        $children->save();

        return $response->withJson(['success'=>true]);
    }

    return $response->withJson(['success'=>false, 'msg'=>'No ID']);
})->setName('delete-scene');

$app->run();
