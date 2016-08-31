<?php

/**
 * Created by PhpStorm.
 * User: duranchen
 * Date: 8/2/16
 * Time: 10:21 PM
 */

namespace App\Model;

class User
{
    protected $storage;

    function __construct(){
        $this->storage = new \App\Model\SessionStorage();
    }

    function setLanguage($language) {
        $this->storage->set('language',$language);
    }

    function getLanguage(){
        return $this->storage->get('language');
    }

}