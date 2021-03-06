<?php
declare(strict_types=1);

namespace RZ\Roadiz\Core\AbstractEntities;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Combined AbstractDateTimed and PositionedTrait.
 *
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(indexes={
 *     @ORM\Index(columns={"position"}),
 *     @ORM\Index(columns={"created_at"}),
 *     @ORM\Index(columns={"updated_at"})
 * })
 */
abstract class AbstractDateTimedPositioned extends AbstractDateTimed implements PositionedInterface
{
    use PositionedTrait;

    /**
     * @ORM\Column(type="float")
     * @Serializer\Groups({"position"})
     * @var float
     * @Serializer\Type("float")
     */
    protected $position = 0.0;
}
