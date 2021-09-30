<?php
declare(strict_types=1);

namespace RZ\Roadiz\Core\AbstractEntities;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Serializer\Annotation as SymfonySerializer;

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
     * @SymfonySerializer\Groups({"id"})
     * @var int|string|null
     * @Serializer\Type("integer")
     */
    protected $id;

    /**
     * @return int|string|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int|string|null $id
     * @return AbstractEntity
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
}
