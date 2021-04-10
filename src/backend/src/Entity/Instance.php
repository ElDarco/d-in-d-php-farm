<?php


namespace Entity;

use Core\TurnoverObject\TurnoverObject;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Entity\Mixin\DefaultFields;

/**
 * @property string $version
 * @property string $status
 * @property string $publicUrl
 * @property string $lang
 *
 * @ORM\Entity()
 * @ORM\Table(name="instance")
 * @ORM\HasLifecycleCallbacks
 */
class Instance extends TurnoverObject
{
    const STATUS_ACTIVE = 'activate';
    const STATUS_DEACTIVE = 'deactivate';

    use DefaultFields;

    /**
     * @var string
     *
     * @ORM\Column(name="version", type="string")
     */
    protected string $version;

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

    /**
     * @var string
     *
     * @ORM\Column(name="lang", type="string")
     */
    protected string $lang;

    protected string $runUrl;
    protected string $shortVersion;

    public function getRunUrl(): string
    {
        return '/instance/' . $this->uuid . '/run/';
    }

    public function getShortVersion(): string
    {
        $versionElements = explode('.', $this->version);
        return $versionElements[0] . '.' . $versionElements[1];
    }
}
