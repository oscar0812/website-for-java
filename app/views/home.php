<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/snackbar.min.css">
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
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </nav>
  <div class="container">
    <ul class="list-group mt-20" id="sortable" data-url="<?=$router->pathFor('item-dropped')?>">
      <?php foreach($scenes as $scene) { ?>
      <li class="list-group-item" data-id="<?=$scene->getId()?>">
        <span><?=$scene->getText()?></span>
        <div class="btn-group float-sm-right">
          <button class="align-middle btn btn-warning">Edit</button>
          <button class="align-middle btn btn-danger">Delete</button>
        </div>
      </li>
      <?php } ?>
    </ul>
  </div>

  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/snackbar.min.js"></script>
  <script src="js/script.js"></script>
</body>

</html>
