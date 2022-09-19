<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TheBRKPost</title>
  <link rel="stylesheet" href="./styles.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body>

  <nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">TheBRKPost</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="?page=timeline">Your timeline</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?page=yourtweets">Your tweets</a>
          </li>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?page=publicprofiles">Public Profiles</a>
          </li>


        </ul>
       
          <?php if ($_SESSION['id']) { ?>
              <a class="btn btn-outline-danger" href="?function=deleteAccount">Delete Account</a>
              <a class="btn btn-outline-success" href="?function=logout">Logout</a>
              
          <?php } else { ?>
           
          <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#myModal" type="button">Login/Signup</button>
            
          <?php } ?>
        </div>
      </div>
    </div>
  </nav>