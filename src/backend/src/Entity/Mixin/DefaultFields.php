<?php

declare(strict_types=1);

namespace Entity\Mixin;

/**
 * Trait DefaultFields
 *
 * @package Entity\Mixin
 */
trait DefaultFields
{
    /**
     * @var string
     *
     * @ORM\Column(name="uuid", type="string", length=36, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $uuid;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updatedAt;

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->updatedAt = new \DateTime('now');

        if ($this->createdAt == null) {
            $this->createdAt = new \DateTime('now');
        }
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setCreatedAt($value)
    {
        if (!$value) {
            return $this;
        }

        if ($value instanceof \DateTime) {
            $this->createdAt = $value;
        } else {
            $this->createdAt = date_create_from_format('Y-m-d H:i:s', $value);
        }

        return $this;
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setUpdatedAt($value)
    {
        if (!$value) {
            return $this;
        }

        if ($value instanceof \DateTime) {
            $this->updatedAt = $value;
        } else {
            $this->updatedAt = date_create_from_format('Y-m-d H:i:s', $value);
        }

        return $this;
    }
}
