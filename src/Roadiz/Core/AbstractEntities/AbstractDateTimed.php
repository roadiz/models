<?php
declare(strict_types=1);

namespace RZ\Roadiz\Core\AbstractEntities;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * An AbstractEntity with datetime fields to keep track of time with your items.
 *
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(indexes={
 *     @ORM\Index(columns={"created_at"}),
 *     @ORM\Index(columns={"updated_at"})
 * })
 */
abstract class AbstractDateTimed extends AbstractEntity
{
    /**
     * @ORM\Column(type="datetime", name="created_at", nullable=true)
     * @var \DateTime|null
     * @Serializer\Groups("timestamps")
     */
    protected $createdAt;

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return AbstractDateTimed
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }
    /**
     * @ORM\Column(type="datetime", name="updated_at", nullable=true)
     * @var \DateTime|null
     * @Serializer\Groups("timestamps")
     */
    protected $updatedAt;

    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return AbstractDateTimed
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->setUpdatedAt(new \DateTime("now"));
    }
    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->setUpdatedAt(new \DateTime("now"));
        $this->setCreatedAt(new \DateTime("now"));
    }
    /**
     * Set creation and update date to *now*.
     *
     * @return AbstractEntity
     */
    public function resetDates()
    {
        $this->setCreatedAt(new \DateTime("now"));
        $this->setUpdatedAt(new \DateTime("now"));

        return $this;
    }
}
