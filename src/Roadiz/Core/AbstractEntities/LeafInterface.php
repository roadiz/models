<?php
declare(strict_types=1);

namespace RZ\Roadiz\Core\AbstractEntities;

use Doctrine\Common\Collections\Collection;

interface LeafInterface extends \IteratorAggregate, \Countable, PositionedInterface
{
    /**
     * @return Collection<LeafInterface>
     */
    public function getChildren(): Collection;

    /**
     * @param LeafInterface $child
     * @return LeafInterface
     */
    public function addChild(LeafInterface $child);

    /**
     * @param LeafInterface $child
     * @return LeafInterface
     */
    public function removeChild(LeafInterface $child);

    /**
     * @return LeafInterface
     */
    public function getParent(): ?LeafInterface;

    /**
     * @return LeafInterface[]
     */
    public function getParents(): array;

    /**
     * @param LeafInterface|null $parent
     * @return LeafInterface
     */
    public function setParent(LeafInterface $parent = null);

    /**
     * Gets the leaf depth.
     *
     * @return int
     */
    public function getDepth(): int;
}
