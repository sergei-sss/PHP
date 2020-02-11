<?php

namespace Entity;

use PDO;

abstract class Entity implements IEntities
{
    private int $id = 0;

    protected ?PDO $pdo;

    /**
     * Entity constructor.
     * @param PDO|null $pdo
     */
    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo;
    }

    public function isExists(): bool
    {
        return boolval($this->id);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return static
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }
}