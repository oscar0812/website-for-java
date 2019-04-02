<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/snackbar.min.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body data-form-url="<?=$router->pathFor('add')?>" data-scene-info="<?=$router->pathFor('scene-info')?>" data-json="<?=$router->pathFor('json')?>">
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="<?=$router->pathFor('home')?>">Java</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarToggler">
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <li class="nav-item active">
          <a class="nav-link" href="<?=$router->pathFor('home')?>">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?=$router->pathFor('json')?>">Json</a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search">
      </form>
    </div>
  </nav>
  <div class="container mt-20">
    <div class="sticky-top mpt-5">
      <div class="card">
        <div class="card-body row">
          <div class="float-sm-left col-sm-9">
            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#newItemModal">
              <i class="fa fa-plus"></i>
              Item
            </button>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#newTrapModal">
              <i class="fa fa-plus"></i>
              Trap
            </button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newSceneModal">
              <i class="fa fa-plus"></i>
              Scene
            </button>
          </div>
          <div class="float-sm-right col-sm-3">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="switch" name="name">
              <label class="custom-control-label" for="switch" data-toggle="tooltip" data-placement="top" data-html="true" title="Green - Parent<br>Pink - Children">Show colors</label>
            </div>
          </div>
        </div>
      </div>
    </div>

    <ul class="list-group mt-20 row" id="sortable" data-url="<?=$router->pathFor('item-dropped')?>">
      <li class="list-group-item row invisible">
        <div class="float-sm-left col-sm-9">
          <p><i class="fa fa-arrows"></i> <b>[ID:
              <span class="scene-id">1</span>]</b>
              <span class="scene-description"></span>
          </p>
        </div>
        <div class="btn-group float-sm-right col-sm-3">
          <button class="align-middle btn btn-warning">Edit</button>
          <button class="align-middle btn btn-danger">Delete</button>
        </div>
      </li>
      <?php foreach($scenes as $scene) { ?>
      <li class="list-group-item row" data-id="<?=$scene->getId()?>" data-parent-id="<?=$scene->getParentSceneId()?>">

        <div class="float-sm-left col-sm-9">
          <p><i class="fa fa-arrows"></i> <b>[ID:
              <span class="scene-id"><?=$scene->getId()?></span>]</b>
              <span class="scene-description"><?=$scene->getDescription()?></span>
          </p>
        </div>
        <div class="btn-group float-sm-right col-sm-3">
          <button class="align-middle btn btn-warning edit-btn" data-toggle="modal" data-target="#editSceneModal">Edit</button>
          <button class="align-middle btn btn-danger delete-btn" data-toggle="modal" data-target="#deleteSceneModal">Delete</button>
        </div>
      </li>
      <?php } ?>
    </ul>
  </div>

  <div class="modal" id="newItemModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Create New Item</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label>Name</label>
              <input class="form-control" placeholder="Item name" name="name">
              <label>Description</label>
              <textarea class="form-control" rows="3" placeholder="Describe the item..." name="description"></textarea>
              <input type="hidden" name="type" value="item">
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
          </form>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>

  <div class="modal" id="newTrapModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Create New Trap</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <form>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Name</label>
                <input class="form-control" placeholder="Trap name" name="name">
              </div>
              <div class="form-group col-md-6">
                <label>Damage</label>
                <input class="form-control" placeholder="30.00" name="damage">
              </div>
            </div>
            <div class="form-group">
              <label>Description</label>
              <textarea class="form-control" rows="3" placeholder="Describe the trap..." name="description"></textarea>
              <input type="hidden" name="type" value="trap">
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
          </form>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>

  <div class="modal" id="newSceneModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Create New Scene</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <form>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Item</label>
                <select class="form-control" name="item_choice">
                </select>
              </div>
              <div class="form-group col-md-6">
                <label>Trap</label>
                <select class="form-control" name="trap_choice">
                </select>
              </div>
            </div>
            <div class="form-group">
              <label>Parent Scene</label>
              <select class="form-control" name="parent_choice">
                <option value="0" selected>None</option>
              </select>
            </div>
            <div class="form-group">
              <label>Text</label>
              <textarea class="form-control" rows="3" placeholder="Describe the scene..." name="description"></textarea>
            </div>
            <input type="hidden" name="type" value="scene">
            <button type="submit" class="btn btn-primary">Create</button>
          </form>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>

  <div class="modal" id="editSceneModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Scene</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <form>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Item</label>
                <select class="form-control" name="item_choice">
                </select>
              </div>
              <div class="form-group col-md-6">
                <label>Trap</label>
                <select class="form-control" name="trap_choice">
                </select>
              </div>
            </div>
            <div class="form-group">
              <label>Parent Scene</label>
              <select class="form-control" name="parent_choice">
                <option value="0" selected>None</option>
              </select>
            </div>
            <div class="form-group">
              <label>Text</label>
              <textarea class="form-control" rows="3" placeholder="Describe the scene..." name="description"></textarea>
            </div>
            <input type="hidden" name="type" value="scene">
            <input type="hidden" name="scene_id" value="0">
            <button type="submit" class="btn btn-primary">Update</button>
          </form>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>

  <div class="modal" id="deleteSceneModal" data-url="<?=$router->pathFor('delete-scene')?>">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Are You Sure?</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <p>Are you super sure you want to delete this scene? You <b>can't</b> go back!</p>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger delete-btn">Delete</button>
        </div>

      </div>
    </div>
  </div>

  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/snackbar.min.js"></script>
  <script src="js/js.cookie.js"></script>

  <script src="js/script.js"></script>
</body>

</html>
