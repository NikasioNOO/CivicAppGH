<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 12/09/2015
 * Time: 06:53 PM
 */

namespace CivicApp\Entities\Auth;

use CivicApp\Entities;
use Illuminate\Support\Collection;
use CivicApp\Entities\Base\BaseEntity;
class Role extends BaseEntity
{


    /**
     * @return int
     */
    protected $_id;
    /**
     * @var string
     */
    protected $_role_name;

    /**
     * @var Collection
     */
    protected $_pages;




    function __construct(Collection $pages)
    {
        $this->setters = ['id', 'role_name','pages'];
        $this->getters = ['id', 'role_name','pages'];

        $this->_id = 0;
        $this->_pages = $pages;

    }

}