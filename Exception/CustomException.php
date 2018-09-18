<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomException
 *
 * @author MSI
 */
class CustomException extends Exception
{
    private $params;
    
    public function __construct($params) {
        $this->setParams($params);
    }

    public function setParams($params = [])
    {
        $this->params = $params;
    }
    
    public function getParams()
    {
        return $this->params;
    }
}
