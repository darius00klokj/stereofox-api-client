<?php
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace SFAPI\Api\Api;

/**
 * Checks if we need to release the cache
 *
 * @author darius
 */
class CheckCache extends Api{
    //put your code here

    const ACTION = 'cache_check';

    public function get(){
        $this->setDoCache(false);
        $resp = (object) $this->request([]);
        return $resp;
    }
}