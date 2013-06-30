<?php
namespace Maverick\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Maverick\ApiBundle\Entity\BaseEntity
 *
 * @ORM\MappedSuperclass
 */
abstract class BaseEntity
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var boolean $softDeleted;
     *
     * @ORM\Column(name="soft_deleted", type="boolean")
     */
    protected $softDeleted = false;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id
     * @param integer $id - Id
     *
     * @return integer
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Set softDeleted
     *
     * @param boolean $softDeleted - Soft Deleted
     *
     * @return boolean
     */
    public function setSoftDeleted($softDeleted)
    {
        $this->setBoolean('softDeleted', $softDeleted);
    }

    /**
     * Is softDeleted
     *
     * @return boolean
     */
    public function isSoftDeleted()
    {
        return $this->softDeleted;
    }

    /**
     * Set attributes from snake_cased array of key-value pairs
     *
     * @param array $attributes - Attributes
     *
     * @return boolean
     */
    public function setAttributes($attributes)
    {
        foreach ($attributes as $attrSnake => $value) {
            if ($this->isEditableAttribute($attrSnake)) {
                $attrCamel = str_replace(' ', '', ucwords(str_replace('_', ' ', $attrSnake)));
                $setter = 'set' . $attrCamel;
                try {
                    if ('' === $value) {
                        $value = null;
                    }
                    $this->$setter($value);
                } catch (NumberParseException $e) {
                    throw new ValidationError(array('mobile' => array('This value is not a valid mobile number')));
                } catch (BadAttributeException $e) {
                    throw $e;
                } catch (\Exception $e) {
                    throw new BadAttributeException($attrSnake);
                }
            } else {
                throw new BadAttributeException($attrSnake);
            }
        }

        return true;
    }

    /**
     * Get DateTime formatted string
     *
     * @param string $field - field name
     *
     * @return string
     */
    public function getDateTimeStr($field)
    {
        if (null === $this->$field) {
            return null;
        } else if ($this->$field instanceof \DateTime) {
            return $this->$field->format('Y-m-d H:i:s');
        } else {
            throw new \Exception("Value of '$field' should store either be null or DateTime object in getDateTimeStr");
        }
    }

    /**
     * Set DateTime field (Helper)
     *
     * @param string $field - field name
     * @param mixed  $value - string or DateTime object
     */
    public function setDateTime($field, $value)
    {
        if ($value instanceof \DateTime) {
            $this->$field = $value;
        } else if (!empty($value)) {
            $this->$field = new \DateTime($value);
        } else {
            $this->$field = null;
        }
    }

    /**
     * Get Date formatted string
     *
     * @param string $field - field name
     *
     * @return string
     */
    public function getDateStr($field)
    {
        $getter = 'get' . ucwords($field);
        $value = $this->$getter();
        if (null === $value) {
            return null;
        } else if ($value instanceof \DateTime) {
            return $value->format('Y-m-d');
        } else {
            throw new \Exception("Value of '$field' should store either be null or Date object in getDateStr");
        }
    }

    /**
     * Set Date
     * @param string $field - field name
     *
     * @param mixes  $value - string or DateTime Object
     */
    public function setDate($field, $value)
    {
        if ($value instanceof \DateTime) {
            $this->$field = $value;
        } else if (!empty($value)) {
            $dateTimeObj = \DateTime::createFromFormat('Y-m-d', $value);
            if ($dateTimeObj instanceof \DateTime) {
                $this->$field = $dateTimeObj;
            } else {
                throw new BadAttributeException('generated_at', 'Wrong format. Should be YYYY-MM-DD format');
            }
        } else {
            $this->$field = null;
        }
    }

    /**
     * Set field as Boolean (Helper)
     *
     * @param string $field - field name
     * @param mixed  $value - string
     */
    public function setBoolean($field, $value)
    {
        if (is_bool($value)) {
            $this->$field = $value;
        } else if (is_numeric($value)) {
            $this->$field = (bool) $value;
        } else if (null === $value || '' === $value) {
            $this->$field = null;
        } else {
            $this->$field = ('true' === $value);
        }
    }

    /**
     * Is Editable Attribute
     *
     * @param string $attrSnake - Snake cased attribute
     *
     * @return boolean
     */
    public abstract function isEditableAttribute($attrSnake);

    /**
     * Serialise
     *
     * @return array
     */
    public function serialise()
    {
        return array(
            'id' => $this->getId(),
            'soft_deleted' => $this->isSoftDeleted()
        );
    }

    /**
     * Set String
     *
     * @param string $field - field name
     * @param mixed  $value - Value
     */
    public function setString($field, $value)
    {
        if (is_string($value)) {
            $this->$field = trim($value);
        } else {
            $this->$field = $value;
        }
    }

    /**
     * Set Float
     *
     * @param string $field - Field Name
     * @param mixed  $value - Value
     */
    public function setFloat($field, $value)
    {
        if (is_numeric($value)) {
            $this->$field = floatval($value);
        } else {
            $this->$field = $value;
        }
    }

    /**
     * Set Integer
     *
     * @param string $field - Field Name
     * @param mixed  $value - Value
     */
    public function setInt($field, $value)
    {
        if (is_numeric($value)) {
            $this->$field = intval($value);
        } else {
            $this->$field = $value;
        }
    }

    /**
     * Set Sortable Version
     *
     * @param string $field - Field Name
     * @param string $value - Value
     */
    public function setSortableVersion($field, $value)
    {
        if (!is_null($value)) {
            $parts = explode('.', $value);
            $justifiedParts = array();
            foreach ($parts as $part) {
                $justifiedParts[] = str_pad($part, 4, ' ', STR_PAD_LEFT);
            }
            $this->$field = implode('.', $justifiedParts);
        } else {
            $this->$field = $value;
        }
    }

    /**
     * Get Sortable Version
     *
     * @param string $field - Field Name
     *
     * @return string
     */
    public function getSortableVersion($field)
    {
        $justifiedValue = $this->$field;
        if (!is_null($justifiedValue)) {
            return str_replace(' ', '', $justifiedValue);
        }

        return $justifiedValue;
    }
}
