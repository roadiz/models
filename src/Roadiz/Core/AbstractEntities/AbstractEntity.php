<?php
declare(strict_types=1);

namespace RZ\Roadiz\Core\AbstractEntities;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Base entity implementing PersistableInterface to offer a unique Id.
 *
 * @ORM\MappedSuperclass
 */
abstract class AbstractEntity implements PersistableInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @Serializer\Groups({"id"})
     * @var int
     * @Serializer\Type("integer")
     */
    protected $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return AbstractEntity
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
}
