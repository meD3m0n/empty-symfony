<?php
namespace Maverick\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Maverick\ApiBundle\Entity\AuditedBaseEntity
 *
 * @ORM\MappedSuperclass
 */
abstract class AuditedBaseEntity extends BaseEntity
{
    /**
     * @var $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     * @Assert\NotBlank()
     */
    protected $createdAt;

    /**
     * @var integer $createdByUserId
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="created_by_user_id", referencedColumnName="PK_idUserProfile", nullable=true)
     */
    protected $createdByUserId;

    /**
     * @var $modifiedAt
     *
     * @ORM\Column(name="modified_at", type="datetime", nullable=false)
     * @Assert\NotBlank()
     */
    protected $modifiedAt;

    /**
     * @var integer $modifiedByUserId
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="modified_by_user_id", referencedColumnName="PK_idUserProfile", nullable=true)
     */
    protected $modifiedByUserId;

    /**
     * Get createdAt
     *
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt
     *
     * @param mixed $createdAt - Created At
     *
     * @return DateTime
     */
    public function setCreatedAt($createdAt)
    {
        $this->setDateTime('createdAt', $createdAt);
    }

    /**
     * Get createdByUserId
     *
     * @return integer
     */
    public function getCreatedByUserId()
    {
        if ($this->createdByUserId instanceof User) {
            return $this->createdByUserId->getId();
        }

        return $this->createdByUserId;
    }

    /**
     * Set createdByUserId
     *
     * @param integer $createdByUserId - Created By User Id
     *
     * @return integer
     */
    public function setCreatedByUserId($createdByUserId)
    {
        $this->createdByUserId = $createdByUserId;
    }

    /**
     * Get modifiedAt
     *
     * @return DateTime
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * Set modifiedAt
     *
     * @param DateTime $modifiedAt - Modified At
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->setDateTime('modifiedAt', $modifiedAt);
    }

    /**
     * Get modifiedByUserId
     *
     * @return integer
     */
    public function getModifiedByUserId()
    {
        if ($this->modifiedByUserId instanceof User) {
            return $this->modifiedByUserId->getId();
        }

        return $this->modifiedByUserId;
    }

    /**
     * Set modifiedByUserId
     *
     * @param integer $modifiedByUserId - Modified By User Id
     *
     * @return integer
     */
    public function setModifiedByUserId($modifiedByUserId)
    {
        $this->modifiedByUserId = $modifiedByUserId;
    }

    /**
     * Serialise
     *
     * @return array
     */
    public function serialise()
    {
        $data = array(
            'created_at' => $this->getDateTimeStr('createdAt'),
            'created_by_user_id' => $this->getCreatedByUserId(),
            'modified_at' => $this->getDateTimeStr('modifiedAt'),
            'modified_by_user_id' => $this->getModifiedByUserId()
        ) + parent::serialise();

        return $data;
    }
}
