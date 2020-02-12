<?php

namespace App\Entity;

use App\Entity\Filter\GenresFilter;
use App\Entity\Filter\IFilters;
use PDO;
use PDOStatement;

class Genre extends Entity
{
    private string $name;
    private PDOStatement $createStatement;
    private PDOStatement $updateStatement;
    private PDOStatement $deleteStatement;

    public function __construct(?PDO $pdo = null)
    {
        parent::__construct($pdo);
        if ($pdo instanceof PDO) {
            $this->createStatement = $pdo->prepare(
                'insert into cinema.genres (name) value (?)'
            );
            $this->updateStatement = $pdo->prepare(
                'update cinema.genres set name = ? where id = ?'
            );
            $this->deleteStatement = $pdo->prepare(
                'delete from cinema.genres where id = ?'
            );
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Genre
     */
    public function setName(string $name): Genre
    {
        $this->name = $name;
        return $this;
    }

    public static function getById(PDO $pdo, int $id): IEntities
    {
        return self::getByFilter($pdo, new GenresFilter($id))[0] ??
               new static();
    }

    public static function getByFilter(
        PDO $pdo,
        IFilters $filter
    ): array {
        $st = $pdo->prepare(
            'select id, name from cinema.genres where (id = :id or :id = \'\') 
                              and (id in (select genre_id from cinema.movies_genres where movie_id = :movie_id) or :movie_id = \'\');'
        );
        if ($st->execute($filter->fetch())) {
            return array_map(
                fn(array $row) => (new static($pdo))->build($row),
                $st->fetchAll()
            );
        }
        return [];
    }

    /**
     * @return array
     */
    public function fetchArray(): array
    {
        return [
            'id'   => $this->getId(),
            'name' => $this->name,
        ];
    }

    /**
     * @param array $row
     * @return $this
     */
    public function build(array $row): self
    {
        return (new static())->setId($row['id'])->setName($row['name']);
    }

    /**
     * @return bool
     */
    public function create(): bool
    {
        $success = $this->createStatement->execute([$this->name]);
        if ($success) {
            $this->setId($this->pdo->lastInsertId());
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        return $this->updateStatement->execute([$this->name, $this->getId()]);
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        return $this->deleteStatement->execute([$this->getId()]);
    }
}