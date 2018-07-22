<?php

namespace Shapecode\Devliver\Entity;

/**
 * Interface TagInterface
 *
 * @package Shapecode\Devliver\Entity
 * @author  Nikita Loges
 * @company tenolo GbR
 */
interface TagInterface extends BaseEntityInterface
{

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     */
    public function setName(string $name): void;
}
