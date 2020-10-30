<?php


namespace Entity;

use Core\TurnoverObject\TurnoverObject;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Entity\Mixin\DefaultFields;

/**
 * @ORM\Entity()
 * @ORM\Table(name="php_instance")
 * @ORM\HasLifecycleCallbacks
 */
class PhpInstance extends TurnoverObject
{
    const STATUS_ACTIVE = 'active';
    const STATUS_DEACTIVE = 'deactive';

    use DefaultFields;

    /**
     * @var string
     *
     * @ORM\Column(name="php_version", type="string")
     */
    protected string $phpVersion;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string")
     */
    protected string $status;

    /**
     * @var string
     *
     * @ORM\Column(name="public_url", type="string")
     */
    protected string $publicUrl;
}