<?php
/**
 * Created by PhpStorm.
 * User: zxp86021
 * Date: 2017/8/3
 * Time: 下午 3:41
 */

namespace App\Traits;


trait NumberToZH
{
    public function convert($num)
    {
        $zh = array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九');

        return $zh[$num];
    }
}