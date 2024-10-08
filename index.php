<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/cinema/config_session.php';
require_once $_SERVER["DOCUMENT_ROOT"] . "/cinema/src/authorization/checkAuthorization.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/cinema/constants.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/cinema/src/sessions_form/session-formQueries.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/cinema/src/movies_form/movies-formQueries.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/cinema/src/authorization/rolesValidation.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/cinema/src/authorization/roleQueries.php";
if (checkAuthorization() != false) header("Location: /cinema/src/authorization/authorization-page.php");

$roleName = getRoleName($_SESSION["role_id"]);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteSession'])) {
  $delete_ids = $_POST['delete_ids'] ?? [];

  foreach ($delete_ids as $id) {
    deleteSession($id);
  }

  // Optionally, redirect to refresh the page after deletion
  header("Location: " . $_SERVER['PHP_SELF']);
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_ids'])) {
  $delete_ids = $_POST['delete_ids'];

  foreach ($delete_ids as $id) {
    // Confirm related session deletion here if necessary
    deleteMovie($id);
  }

  // Optionally, redirect to refresh the page after deletion
  header("Location: " . $_SERVER['PHP_SELF']);
  exit();
}
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
          <a class="nav-link" href="/cinema/index.php">Home <span class="sr-only">(current)</span></a>
        </li>

        <li class="nav-item">
          <a
            class="nav-link"
            href="/cinema/src/authorization/authorization-page.php">Authorization</a>
        </li>
        <?php if (isAdmin($roleName) || isEmployee($roleName)): ?>
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
                href="/cinema/src/movies_form/movies_form.php">Movies form</a>
              <a class="dropdown-item" href="/cinema/src/sessions_form/sessions_form.php">Sessions form</a>
            </div>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>

  <?php
  require_once "./src/movies_form/movies-formQueries.php";
  require_once "./src/sessions_form/session-formQueries.php";

  $sessionsArray = getSessions();
  $moviesArray = getMovies();

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['filterSessions'])) {
      $hall_number = $_POST['Hall_number'];
      $price = $_POST['Price'];

      // Фильтрация массива
      $sessionsArray = array_filter($sessionsArray, function ($session) use ($hall_number, $price) {
        $matchHall = empty($hall_number) || $session['hall_number'] == $hall_number;
        $matchPrice = empty($price) || $session['price'] == $price;
        return $matchHall && $matchPrice;
      });
    } elseif (isset($_POST['resetSessions'])) {
      // Сброс фильтров
      $sessionsArray = getSessions();
    }

    if (isset($_POST['filterMovies'])) {
      $title = $_POST['Title'] ?? '';
      $rating = $_POST['Rating'] ?? '';

      $moviesArray = array_filter($moviesArray, function ($movie) use ($title, $rating) {
        $matchTitle = empty($title) || stripos($movie['title'], $title) !== false;
        $matchRating = empty($rating) || $movie['rating'] === $rating;
        return $matchTitle && $matchRating;
      });
    } elseif (isset($_POST['resetMovies'])) {
      $moviesArray = getMovies();
    }
  }

  ?>

  <h1>Tables</h1>
  <div class="content">
    <div class="container">
      <h2 class="mb-5">Movies Table</h2>

      <form method="post">
        <input type="text" name="Title" placeholder="Title" value="<?php echo isset($_POST['Title']) ? htmlspecialchars($_POST['Title']) : ''; ?>">
        <input type="text" name="Rating" placeholder="Rating" value="<?php echo isset($_POST['Rating']) ? htmlspecialchars($_POST['Rating']) : ''; ?>">
        <button type="submit" name="filterMovies">Фильтровать</button>
        <button type="submit" name="resetMovies">Сбросить фильтры</button>
      </form>

      <div class="table-responsive">
        <form method="POST" id="deleteMoviesForm">
          <table class="table custom-table">
            <thead>
              <tr>
                <?php if (isAdmin($roleName) || isEmployee($roleName)): ?>
                  <th scope="col"></th>
                <?php endif; ?>
                <th scope="col">Id</th>
                <th scope="col">Title</th>
                <th scope="col">Release date</th>
                <th scope="col">Duration</th>
                <th scope="col">Rating</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($moviesArray as $row): ?>
                <tr>
                  <?php if (isAdmin($roleName) || isEmployee($roleName)): ?>
                    <th scope="row">
                      <label class="control control--checkbox">
                        <input type="checkbox" name="delete_ids[]" value="<?php echo $row['id']; ?>" />
                        <div class="control__indicator"></div>
                      </label>
                    </th>
                  <?php endif; ?>
                  <td><?php echo $row['id']; ?></td>
                  <td><?php echo htmlspecialchars($row['title']); ?></td>
                  <td><?php echo htmlspecialchars($row['release_date']); ?></td>
                  <td><?php echo htmlspecialchars($row['duration']); ?></td>
                  <td><?php echo htmlspecialchars($row['rating']); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <?php if (isAdmin($roleName) || isEmployee($roleName)): ?>
            <button type="button" onclick="confirmMoviesDeletion()" class="btn btn-danger">Delete Selected</button>
          <?php endif; ?>
        </form>

        <script>
          function confirmMoviesDeletion() {
            const selectedIds = document.querySelectorAll('input[name="delete_ids[]"]:checked');
            if (selectedIds.length === 0) {
              alert("Please select at least one movie to delete.");
              return;
            }

            const confirmation = confirm("Do you want to delete the selected movies and their related sessions?");
            if (confirmation) {
              document.getElementById('deleteMoviesForm').submit();
            }
          }
        </script>
      </div>
    </div>

    <div class="container">
      <h2 class="mb-5">Sessions Table</h2>

      <form method="post">
        <input type="text" name="Hall_number" placeholder="Hall number" value="<?php echo isset($_POST['Hall_number']) ? htmlspecialchars($_POST['Hall_number']) : ''; ?>">
        <input type="text" name="Price" placeholder="Price" value="<?php echo isset($_POST['Price']) ? htmlspecialchars($_POST['Price']) : ''; ?>">
        <button type="submit" name="filterSessions">Фильтровать</button>
        <button type="submit" name="resetSessions">Сбросить фильтры</button>
      </form>

      <div class="table-responsive">
        <form method="POST" id="deleteSessionsForm">
          <table class="table custom-table">
            <thead>
              <tr>
                <?php if (isAdmin($roleName) || isEmployee($roleName)): ?>
                  <th scope="col"></th>
                <?php endif; ?>
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
                  <?php if (isAdmin($roleName) || isEmployee($roleName)): ?>
                    <th scope="row">
                      <label class="control control--checkbox">
                        <input type="checkbox" name="delete_ids[]" value="<?php echo $row['id']; ?>" />
                        <div class="control__indicator"></div>
                      </label>
                    </th>
                  <?php endif; ?>
                  <td><?php echo $row['id']; ?></td>
                  <td><?php echo htmlspecialchars($row['movie_id']); ?></td>
                  <td><?php echo htmlspecialchars($row['hall_number']); ?></td>
                  <td><?php echo htmlspecialchars($row['start_time']); ?></td>
                  <td><?php echo htmlspecialchars($row['price']); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <?php if (isAdmin($roleName) || isEmployee($roleName)): ?>
            <button type="submit" onclick="confirmSessionDeletion()" name="deleteSession" class="btn btn-danger">Delete Selected</button>
          <?php endif; ?>
        </form>
        <script>
          function confirmSessionDeletion() {
            const selectedIds = document.querySelectorAll('input[name="delete_ids[]"]:checked');
            if (selectedIds.length === 0) {
              alert("Please select at least one session to delete.");
              return;
            } else document.getElementById('deleteSessionsForm').submit();
          }
        </script>
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