<?php

namespace Maverick\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\ExecutionContext;

/**
* Maveric\ApiBundle\Entity\Notes
*
* @ORM\Table(name="notes")
* @ORM\Entity(repositoryClass="NotesRepository")
*/
class Notes extends BaseEntity
{
    /**
     * @var boolean $description
     *
     * @ORM\Column(name="description", type="string")
     */
    protected $description;

    //FIXME:: needs phone number validation based on country
    /**
     * @var boolean $for
     *
     * @ORM\Column(name="for", type="string")
     */
    protected $for;

    /**
     * @var boolean $for
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    protected $userId;

    /**
     * Get Description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set Description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get For
     *
     * @return string
     */
    public function getFor()
    {
        return $this->for;
    }

    /**
     * Set For
     *
     * @param string $for
     */
    public function setFor($for)
    {
        $this->for = $for;
    }

    /**
     * Is Editable Attribute
     *
     * @param string $attrSnake - Snake cased attribute name
     *
     * @return boolean
     */
    public function isEditableAttribute($attrSnake)
    {
        $editableAttributes = array(
            'description', 'for'
        );

        return in_array($attrSnake, $editableAttributes);
    }

    /**
     * Serialize
     *
     * @return array
     */
    public function serialise()
    {
        $data = array(
            'description' => $this->getDescription(),
            'for' => $this->getFor(),
        ) + parent::serialise();

        return $data;
    }
}
