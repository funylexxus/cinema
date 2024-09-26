<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/cinema/config_session.php'; //where needed start_session();
require_once $_SERVER['DOCUMENT_ROOT'] . "/cinema/constants.php";
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Contact</title>
    <meta charset="UTF-8" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.min.css" />
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="">Navbar</a>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown"
        aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="/cinema/index.php"
              >Home <span class="sr-only">(current)</span></a
            >
          </li>

          <li class="nav-item">
            <a
              class="nav-link"
              href="/cinema/src/authorization/authorization-page.html"
              >Authorization</a
            >
          </li>

          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="navbarDropdownMenuLink"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false">
              Tables Forms
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a
                class="dropdown-item"
                href="/cinema/src/movies_form/movies_form.html"
                >Movies form</a
              >
              <a class="dropdown-item" href="/cinema/src/sessions_form/sessions_form.html">Sessions form</a>
            </div>
          </li>
        </ul>
      </div>
    </nav>

    <?php
      require "./src/movies_form/movies-formQueries.php";
      require "./src/sessions_form/session-formQueries.php";

      $sessionsArray = getSessions();
      $moviesArray = getMovies();
    ?>

    <h1>Tables</h1>
    <!--шаблонизаторы это кринж все нормальные ребята используют циклы-->
    <div class="content">
      <div class="container">
        <h2 class="mb-5">Movies Table</h2>

        <div class="table-responsive">
        <table class="table custom-table">
    <thead>
        <tr>
            <th scope="col">
                <label class="control control--checkbox">
                    <input type="checkbox" class="js-check-all" />
                    <div class="control__indicator"></div>
                </label>
            </th>
            <th scope="col">id</th>
            <th scope="col">Title</th>
            <th scope="col">Release date</th>
            <th scope="col">Duration</th>
            <th scope="col">Rating</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($moviesArray as $row): ?>
            <tr>
                <th scope="row">
                    <label class="control control--checkbox">
                        <input type="checkbox" />
                        <div class="control__indicator"></div>
                    </label>
                </th>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo htmlspecialchars($row['release_date']); ?></td>
                <td><?php echo htmlspecialchars($row['duration']); ?></td>
                <td><?php echo htmlspecialchars($row['rating']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
        </div>
      </div>

      <div class="container">
        <h2 class="mb-5">Sessions Table</h2>

        <div class="table-responsive">
          <table class="table custom-table">
            <thead>
              <tr>
                <th scope="col">
                  <label class="control control--checkbox">
                    <input type="checkbox" class="js-check-all" />
                    <div class="control__indicator"></div>
                  </label>
                </th>
                <th scope="col">Id</th>
                <th scope="col">Movie id</th>
                <th scope="col">Hall number</th>
                <th scope="col">Start time</th>
                <th scope="col">Price</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($sessionsArray as $row): ?>
                <tr>
                  <th scope="row">
                    <label class="control control--checkbox">
                        <input type="checkbox" />
                        <div class="control__indicator"></div>
                    </label>
                  </th>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['movie_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['hall_number']); ?></td>
                    <td><?php echo htmlspecialchars($row['start_time']); ?></td>
                    <td><?php echo htmlspecialchars($row['price']); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <script
      src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
      integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
      crossorigin="anonymous"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
      integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
      crossorigin="anonymous"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
      integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
      crossorigin="anonymous"></script>
  </body>
</html>
