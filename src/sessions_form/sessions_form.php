<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/cinema/config_session.php';
require_once $_SERVER["DOCUMENT_ROOT"] . "/cinema/src/authorization/checkAuthorization.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/cinema/src/sessions_form/session-formQueries.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/cinema/src/sessions_form/session-formValidation.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/cinema/src/authorization/rolesValidation.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/cinema/src/authorization/roleQueries.php";

if (checkAuthorization() != false) header("Location: /cinema/src/authorization/authorization-page.php");
$roleName = getRoleName($_SESSION["role_id"]);
if (!isAdmin($roleName) && !isEmployee($roleName)) exit();


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'session') {
  $movie_id = $_POST['movie_id'];
  $hall_number = $_POST['hall_number'];
  $start_time = $_POST['start_time'];
  $price = $_POST['price'];

  if (isset($_POST['movie_id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (($result = validateSession($movie_id, $hall_number, $start_time, $price)) != false) {
      $error_message = "<p style='color: red;'>" . nl2br($result) . "</p>";
    } else {
      setSession($movie_id, $hall_number, $start_time, $price);
      header("Location: \\cinema/index.php");
      exit();
    }
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
    crossorigin="anonymous" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.min.css" />
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="/cinema/css/main.css" />
  <title>Form</title>
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
            <a
              class="dropdown-item"
              href="/cinema/src/sessions_form/sessions_form.php">Sessions form</a>
            <?php if (isAdmin($roleName)): ?>
              <a
                class="dropdown-item"
                href="/cinema/src/users_form/users_form.php">Users form</a>
            <?php endif; ?>
          </div>
        </li>
      </ul>
    </div>
  </nav>

  <h1>Sessions Form</h1>
  <main>
    <form action="sessions_form.php" method="post">

      <label for="movie_id">Movie ID</label>

      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Select movie title
        </button>

        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <?php
          require_once $_SERVER['DOCUMENT_ROOT'] . "/cinema/src/movies_form/movies-formQueries.php";
          $moviesArray = getMovies();

          $selectedMovieId = '';
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $selectedMovieId = $_POST['movie_id'] ?? '';
          }
          ?>

          <?php foreach ($moviesArray as $row): ?>
            <button class="dropdown-item" type="button" onclick="selectMovie('<?php echo htmlspecialchars($row['id']); ?>', '<?php echo htmlspecialchars($row['title']); ?>')">
              <?php echo htmlspecialchars($row['title']); ?>
            </button>
          <?php endforeach; ?>
        </div>

        <?php if ($selectedMovieId): ?>
          <div>
            <p>Selected Movie ID: <?php echo htmlspecialchars($selectedMovieId); ?></p>
          </div>
        <?php endif; ?>
      </div>

      <input
        id="movie_id"
        type="text"
        name="movie_id"
        placeholder="Movie Id..."
        readonly />

      <script>
        function selectMovie(id, title) {
          document.getElementById('movie_id').value = id;
          document.getElementById('dropdownMenuButton').innerText = title;
        }
      </script>

      <label for="hall_number">Hall number</label>
      <input
        id="hall_number"
        type="text"
        name="hall_number"
        placeholder="Hall number..." />

      <label for="start_time">Start time</label>
      <input
        id="start_time"
        type="text"
        name="start_time"
        placeholder="Start time..." />

      <label for="price">Price</label>
      <input id="price" type="text" name="price" placeholder="Price..." />
      <input type="hidden" name="action" value="session" />
      <button type="submit">Submit</button>
    </form>
    <?php
    if (isset($error_message)) {
      echo $error_message;
    }
    ?>
  </main>

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