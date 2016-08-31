<?php

/**
 * Created by PhpStorm.
 * User: duranchen
 * Date: 8/2/16
 * Time: 10:17 PM
 */
namespace App\Model;

class SessionStorage
{
    function __construct($cookieName ='PHP_SESS_ID'){
        session_name($cookieName);
    }

    function set($key,$value){
        $_SESSION[$key] = $value;
    }

    function get($key) {
        return $_SESSION[$key];
    }

}
use Illuminate\Database\Eloquent\Model;