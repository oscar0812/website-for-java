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
            hi
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
          <p><i class="fa fa-arrows"></i>
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

  <div class="invisible popup" pd-popup="addNewPerfume">
    <div class="popup-inner">
      <div class="row">
        <h2>Add New Perfume
      </div>
      <form id="add-new-perfume" class="row inner-scroll" method="POST" action="">
        <div class="col-md-12 col-sm-12">
          <div class="row">
            <p class="form-row col-sm-6">
              <label for="name">Name<abbr title="required" class="required">*</abbr></label>
              <input type="text" name="Perfume[name]" id="name" class="form-controller">
            </p>
            <p class="form-row col-sm-6">
              <label for="price">Price<abbr title="required" class="required">*</abbr></label>
              <input type="text" name="Perfume[price]" id="price" class="form-controller">
            </p>
          </div>
        </div>
      </form>
      <button class="btn btn-lg btn-success" type="submit">Submit</button>
      <a class="popup-close" pd-popup-close="addNewPerfume" href="#"> </a>
    </div>
  </div>

  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/snackbar.min.js"></script>
  <script src="js/script.js"></script>
</body>

</html>
