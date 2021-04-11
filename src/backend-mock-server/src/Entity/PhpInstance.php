<?php


namespace Entity;

use Core\TurnoverObject\TurnoverObject;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Entity\Mixin\DefaultFields;

/**
 * @property string $phpVersion
 * @property string $status
 * @property string $publicUrl
 *
 * @ORM\Entity()
 * @ORM\Table(name="php_instance")
 * @ORM\HasLifecycleCallbacks
 */
class PhpInstance extends TurnoverObject
{
    const STATUS_ACTIVE = 'activate';
    const STATUS_DEACTIVE = 'deactivate';

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

    protected string $runUrl;
    protected string $shortVersion;

    public function getRunUrl(): string
    {
        return '/php-instance/' . $this->uuid . '/run/';
    }

    public function getShortVersion(): string
    {
        $versionElements = explode('.', $this->phpVersion);
        return $versionElements[0] . '.' . $versionElements[1];
    }
}