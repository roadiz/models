<?php
declare(strict_types=1);

namespace RZ\Roadiz\Core\AbstractEntities;

/**
 * Trait which describe a positioned entity
 */
trait PositionedTrait
{
    /**
     * @return float
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set position as a float to enable increment and decrement by O.5
     * to insert a node between two others.
     *
     * @param float $newPosition
     * @return $this
     */
    public function setPosition($newPosition)
    {
        if ($newPosition > -1) {
            $this->position = (float) $newPosition;
        }

        return $this;
    }
}
