<?php
require '../vendor/autoload.php';

// adding an external config file
require '../functions.php';

require '../data/generated-conf/config.php';

$config['displayErrorDetails'] = true;

$app = new \Slim\App(["settings" => $config]);

$container = $app->getContainer();
$container['view'] = new \Slim\Views\PhpRenderer("../app/views/");

$app->group('', function () use ($app) {
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
        $items = \ItemQuery::create()->findByIsTrap(false);
        $traps = \ItemQuery::create()->findByIsTrap(true);
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
            $trap = new \Item();
            $trap->setName($params['name']);
            $trap->setDescription($params['description']);
            $trap->setDamage($params['damage']);
            $trap->setIsTrap(true);

            $trap->save();
        } elseif ($params['type'] == 'item') {
            $item = new \Item();
            $item->setName($params['name']);
            $item->setDescription($params['description']);
            $item->setDamage($params['damage']);
            $item->setIsTrap(false);

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
            if (isset($params['parent_choice'])) {
                $scene->setParentSceneId($params['parent_choice']);
            } else {
                $scene->setParentSceneId(0);
            }

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
})->add(function ($request, $response, $next) {
    if (loggedIn()) {
        // signed in, show them what they want
        return $next($request, $response);
    } else {
        // not signed in, redirect to login
        return $response->withRedirect($this->router->pathFor('signin'));
    }
});

$app->group('', function () use ($app) {
    $app->get('/signin', function ($request, $response, $args) {
        $scenes = \SceneQuery::create()->orderByPlacement()->find();
        return $this->view->render($response, 'signin.php', ['router'=>$this->router, 'scenes'=>$scenes]);
    })->setName('signin');

    $app->post('/signin', function ($request, $response, $args) {
        $p = $request->getParsedBody();

        $pass = "";

        if ($p['email'] == 'admin@gmail.com' && $p['password'] == $pass) {
            logIn();

            return $response->withJson(['success'=>true, 'route'=>$this->router->pathFor('home')]);
        }

        return $response->withJson(['success'=>false]);
    });
})->add(function ($request, $response, $next) {
    if (!loggedIn()) {
        // not signed in, show them what they want
        return $next($request, $response);
    } else {
        // signed in, redirect to home
        return $response->withRedirect($this->router->pathFor('home'));
    }
});

$app->run();
