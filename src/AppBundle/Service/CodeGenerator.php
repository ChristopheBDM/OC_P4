<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 28/08/2017
 * Time: 20:10
 */

namespace AppBundle\Service;


class CodeGenerator
{
    public function random()
    {
        $string = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1).substr(md5(time()),1);
        return $string;
    }
}
