<?php
declare(strict_types=1);

namespace RZ\Roadiz\Core\AbstractEntities;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Combined AbstractEntity and PositionedTrait.
 *
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(indexes={
 *     @ORM\Index(columns={"position"})
 * })
 */
abstract class AbstractPositioned extends AbstractEntity implements PositionedInterface
{
    use PositionedTrait;

    /**
     * @ORM\Column(type="float")
     * @Serializer\Groups({"position"})
     * @Serializer\Type("float")
     * @var float
     */
    protected $position = 0.0;
}
