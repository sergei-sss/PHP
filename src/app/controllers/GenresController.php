<?php

namespace Controller;

use Core\AppException;
use Core\Response;
use Entity\Filter\GenresFilter;
use Entity\Genre;

class GenresController extends AppController
{
    public function getGenres()
    {
        $genres = array_map(
            fn(Genre $genre): array => $genre->fetchArray(),
            Genre::getByFilter($this->app->getPdo(), new GenresFilter())
        );
        $this->app->getResponse()->setBody(
            json_encode($genres, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        )->setContentType(Response::CONTENT_TYPE_JSON);
    }

    /**
     * @throws AppException
     */
    public function createGenre()
    {
        $genre = new Genre($this->app->getPdo());
        $success = $genre->setName($_POST['name'])->create();
        if ($success) {
            $this->app->getResponse()->setBody(
                json_encode(
                    $genre->fetchArray(),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
                )
            );
        } else {
            throw new AppException('could not create genre');
        }
    }
}