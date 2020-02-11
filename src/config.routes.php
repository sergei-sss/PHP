<?php

use Core\Router;

Router::addHandler(
    '/',
    'GET',
    fn($app) => (new \Controller\FilmsController($app))->showPage(
        __DIR__ . '/app/views/pages/index.html'
    )
);
Router::addHandler(
    '/films',
    'GET',
    fn($app) => (new \Controller\FilmsController($app))->getFilms()
);
Router::addHandler(
    '/films',
    'POST',
    fn($app) => (new \Controller\FilmsController($app))->createFilm()
);
Router::addHandler(
    '/genres',
    'GET',
    fn($app) => (new \Controller\GenresController($app))->getGenres()
);
Router::addHandler(
    '/genres',
    'POST',
    fn($app) => (new \Controller\GenresController($app))->createGenre()
);