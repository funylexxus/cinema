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
      <link rel ="stylesheet" href ="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">  
    <link rel="stylesheet" href="/cinema/css/main.css" />
    <title>Movies Form</title>
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
            <a class="nav-link" href="../../index.php"
              >Home <span class="sr-only">(current)</span></a
            >
          </li>

          <li class="nav-item">
            <a
              class="nav-link"
              href="/cinema/src/authorization/authorization-page.php"
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
                href="/cinema/src/movies_form/movies_form.php"
                >Movies form</a
              >
              <a
                class="dropdown-item"
                href="/cinema/src/sessions_form/sessions_form.php"
                >Sessions form</a
              >
            </div>
          </li>
        </ul>
      </div>
    </nav>

    <h1>Movies Form</h1>

    <main>
      <form action="movies_form.php" method="post">
        <label for="title">Title</label>
        <input id="title" type="text" name="title" placeholder="Title..." />

        <label for="description">Description</label>
        <input
          id="description"
          type="text"
          name="description"
          placeholder="Description..." />

        <label for="release_date">Release date</label>
        <input type="date" id="release-date" name="release_date" class="calendar-input" placeholder="Release date..." max="2026-12-31"/>
        <!-- <input
          id="release_date"
          type="text"
          name="release_date"
          placeholder="Release date..." /> -->

        <label for="duration">Duration</label>
        <input
          id="duration"
          type="text"
          name="duration"
          placeholder="Duration..." />

        <label for="rating">Rating</label>
        <input id="rating" type="text" name="rating" placeholder="Rating..." />

        <button type="submit">Submit</button>
      </form>
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
      <script src ="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>  
      <script src="/src/js/scripts.js"></script>
  </body>
</html>

<?php

require "movies-formQueries.php";
require "movies-formValidation.php";

$title = $_POST["title"];
$description = $_POST["description"];
$release_date = $_POST["release_date"];
$duration = filter_input(INPUT_POST, "duration", FILTER_SANITIZE_NUMBER_INT);
$rating = filter_input(INPUT_POST, "rating", FILTER_SANITIZE_NUMBER_INT);

if(isset($_POST['title'])) {
  if(($result = validateMovie($title, $description, $release_date, $duration, $rating)) != false) {
    echo "<p style='color: red;'>".nl2br($result)."</p>";
  } else {
    setMovie($title, $description, $release_date, $duration, $rating);
    header("Location: ../../index.php"); 
    exit();
  }
}

?>