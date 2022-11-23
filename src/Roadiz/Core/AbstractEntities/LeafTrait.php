<?php

declare(strict_types=1);

namespace RZ\Roadiz\Core\AbstractEntities;

use Doctrine\Common\Collections\Collection;

trait LeafTrait
{
    use PositionedTrait;

    /**
     * @return Collection<static>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    /**
     * @param Collection<static> $children
     * @return $this
     */
    public function setChildren(Collection $children): static
    {
        $this->children = $children;
        /** @var static $child */
        foreach ($this->children as $child) {
            $child->setParent($this);
        }
        return $this;
    }

    /**
     * @param LeafInterface $child
     * @return $this
     */
    public function addChild(LeafInterface $child): static
    {
        if (!$this->getChildren()->contains($child)) {
            $this->getChildren()->add($child);
            $child->setParent($this);
        }

        return $this;
    }
    /**
     * @param LeafInterface $child
     * @return $this
     */
    public function removeChild(LeafInterface $child): static
    {
        if ($this->getChildren()->contains($child)) {
            $this->getChildren()->removeElement($child);
            $child->setParent(null);
        }

        return $this;
    }

    /**
     * @return static|null
     */
    public function getParent(): ?static
    {
        return $this->parent;
    }

    /**
     * @param static|null $parent
     * @return $this
     */
    public function setParent($parent = null): static
    {
        if ($parent === $this) {
            throw new \InvalidArgumentException('An entity cannot have itself as a parent.');
        }

        $this->parent = $parent;
        $this->parent?->addChild($this);

        return $this;
    }

    /**
     * Return every tag’s parents.
     *
     * @return static[]
     */
    public function getParents(): array
    {
        $parentsArray = [];
        $parent = $this;

        do {
            $parent = $parent->getParent();
            if ($parent !== null) {
                $parentsArray[] = $parent;
            }
        } while ($parent !== null);

        return array_reverse($parentsArray);
    }

    /**
     * Gets the nodes' depth.
     *
     * @return int
     */
    public function getDepth(): int
    {
        if ($this->getParent() === null) {
            return 0;
        }
        return $this->getParent()->getDepth() + 1;
    }
}
