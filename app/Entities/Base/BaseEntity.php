<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 13/09/2015
 * Time: 11:34 PM
 */

namespace CivicApp\Entities\Base;

use CivicApp\Entities\Base;

abstract class BaseEntity {

    use AttributesTrait;

    public $setters;
    public $getters;



}