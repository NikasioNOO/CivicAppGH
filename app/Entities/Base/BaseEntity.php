<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 13/09/2015
 * Time: 11:34 PM
 */

namespace CivicApp\Entities\Base;

use CivicApp\Entities\Base;
use Illuminate\Contracts\Support\Jsonable;

abstract class BaseEntity implements Jsonable, \JsonSerializable  {

    use AttributesTrait;

    public $setters;
    public $getters;

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int $options
     *
     * @return string
     */
    public function toJson($options = 0)
    {

        $array = [];
        foreach($this->getters as $attribute)
        {
            $attributeName = '_'.$attribute;
            $array[$attribute] = $this->$attributeName;
        }

        return $array;
    }


    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    function jsonSerialize()
    {
        $array = [];
        foreach($this->getters as $attribute)
        {
            $attributeName = '_'.$attribute;
            $array[$attribute] = $this->$attributeName;
        }

        return $array;
    }


}