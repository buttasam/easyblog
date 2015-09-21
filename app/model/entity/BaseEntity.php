<?php
namespace App\Model\Entities;

use YetORM;

class BaseEntity extends YetORM\Entity
{
    /** @return array */
    function toArray() {
        $ref = static::getReflection();
        $values = array();
        foreach ($ref->getEntityProperties() as $name => $property) {
            if ($property instanceof YetORM\Reflection\MethodProperty) {
                $value = $this->{'get' . $name}();
            } else {
                $value = $this->$name;
            }
            if (!($value instanceof YetORM\EntityCollection || $value instanceof YetORM\Entity)) {
                $values[$name] = $value;
            }
        }
        return $values;
    }
}