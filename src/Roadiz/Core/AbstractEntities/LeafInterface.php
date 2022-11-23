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
    public function addChild(LeafInterface $child): static;

    /**
     * @param static $child
     * @return static
     */
    public function removeChild(LeafInterface $child): static;

    /**
     * @return static|null
     */
    public function getParent(): ?static;

    /**
     * @return static[]
     */
    public function getParents(): array;

    /**
     * @param static|null $parent
     * @return static
     */
    public function setParent($parent = null): static;

    /**
     * Gets the leaf depth.
     *
     * @return int
     */
    public function getDepth(): int;
}
