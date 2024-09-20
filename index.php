<?php
// require_once 'lib/mustache/Autoloader.php';
require_once 'src/movies_form/movies-formQueries.php';
// Mustache_Autoloader::register();

// data
$movies = getMovies();

print_r($movies);
echo $movies;

// Initialize Mustache
// $m = new Mustache_Engine;

// Load the template
// $template = Mustache('movies_template.mustache');

// Render the template with data
// echo $m->render($template, ['movies' => $movies]);
?>
