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

<body>
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
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newSceneModal">
              <i class="fa fa-plus"></i>
              Scene
            </button>
            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#newSceneModal">
              <i class="fa fa-plus"></i>
              Item
            </button>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#newSceneModal">
              <i class="fa fa-plus"></i>
              Trap
            </button>
          </div>
          <div class="float-sm-right col-sm-3">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="switch" name="name">
              <label class="custom-control-label" for="switch">Show colors</label>
            </div>
          </div>
        </div>
      </div>
    </div>

    <ul class="list-group mt-20 row" id="sortable" data-url="<?=$router->pathFor('item-dropped')?>">
      <?php foreach($scenes as $scene) { ?>
      <li class="list-group-item row" data-id="<?=$scene->getId()?>">

        <div class="float-sm-left col-sm-9">
          <p><i class="fa fa-arrows"></i> <b>[ID:
              <?=$scene->getId()?>]</b>
            <?=$scene->getText()?>
          </p>
        </div>
        <div class="btn-group float-sm-right col-sm-3">
          <button class="align-middle btn btn-warning">Edit</button>
          <button class="align-middle btn btn-danger">Delete</button>
        </div>
      </li>
      <?php } ?>
    </ul>
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
            <div class="form-group">
              <label for="inputText">Text</label>
              <textarea class="form-control" id="inputText" rows="3" placeholder="Describe the scene..."></textarea>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputItem">Item</label>
                <select id="inputItem" class="form-control">
                  <option selected>Choose...</option>
                  <option>...</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="inputTrap">Trap</label>
                <select id="inputTrap" class="form-control">
                  <option selected>Choose...</option>
                  <option>...</option>
                </select>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Sign in</button>
          </form>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>

  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/snackbar.min.js"></script>
  <script src="js/script.js"></script>
</body>

</html>
