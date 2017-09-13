<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 10/09/2015
 * Time: 09:31 PM
 */

namespace CivicApp\Entities\Base;


trait AttributesTrait {
    function  __set($var_name, $var_value)
    {


        $propertyName = '_'.$var_name;


        if(method_exists($this, $propertyName))
        {

            $this->$propertyName($var_value);
        }
        elseif(property_exists($this, $propertyName ) &&
             in_array($var_name,$this->setters))
        {
            /*
            if(isset($this->setters[$var_name]))
            {
                if(!$var_value instanceof $this->setters[$var_name])
                    throw new EntityIlegalException('Ilegal Object set to attribute, it must be '.$this->setters[$var_name]);
            }
            */

            $this->$propertyName = $var_value;
        }
        else
            throw new IlegalProperyEntityException("Ilegal Property Setter  for ".$var_name);


    }

    function  __get($var_name)
    {
        $propertyName = '_'.$var_name;

        if(method_exists($this, $propertyName))
        {

            return $this->$propertyName();
        }

        if(property_exists($this, $propertyName ) &&
            in_array($var_name,$this->getters))
        {

            return $this->$propertyName;
        }

        throw new IlegalProperyEntityException("Ilegal Property Getter  for ".$var_name);

    }

}