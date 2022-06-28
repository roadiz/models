<?php

declare(strict_types=1);

namespace RZ\Roadiz\Core\AbstractEntities;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Comparable;

interface LeafInterface extends PositionedInterface, Comparable
{
    /**
     * @return Collection<static>
     */
    public function getChildren(): Collection;

    /**
     * @param static $child
     * @return static
     */
    public function addChild(LeafInterface $child);

    /**
     * @param static $child
     * @return static
     */
    public function removeChild(LeafInterface $child);

    /**
     * @return static
     */
    public function getParent(): ?LeafInterface;

    /**
     * @return static[]
     */
    public function getParents(): array;

    /**
     * @param static|null $parent
     * @return static
     */
    public function setParent(LeafInterface $parent = null);

    /**
     * Gets the leaf depth.
     *
     * @return int
     */
    public function getDepth(): int;
}
