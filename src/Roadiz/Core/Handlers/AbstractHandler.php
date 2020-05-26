<?php
declare(strict_types=1);

namespace RZ\Roadiz\Core\Handlers;

use Doctrine\Persistence\ObjectManager;

abstract class AbstractHandler
{
    /** @var ObjectManager */
    protected $objectManager;

    /**
     * @return ObjectManager
     */
    public function getObjectManager()
    {
        return $this->objectManager;
    }

    /**
     * @param ObjectManager $objectManager
     * @return AbstractHandler
     */
    public function setObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        return $this;
    }

    /**
     * AbstractHandler constructor.
     *
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Clean positions for current entity siblings.
     *
     * @param bool $setPositions
     * @return int Return the next position after the **last** entity
     */
    public function cleanPositions($setPositions = true)
    {
        return 1;
    }
}
