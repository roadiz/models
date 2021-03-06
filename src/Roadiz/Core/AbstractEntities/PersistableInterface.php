<?php
declare(strict_types=1);

namespace RZ\Roadiz\Core\AbstractEntities;

/**
 * Base entity interface which deals with identifier.
 *
 * Every database entity should implements that interface.
 */
interface PersistableInterface
{
    /**
     * Get entity unique identifier.
     *
     * @return int|string|null
     */
    public function getId();
}
