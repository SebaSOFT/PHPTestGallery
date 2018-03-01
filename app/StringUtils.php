<?php
/**
 * User: SebaSOFT
 * Date: 28/2/2018
 */

namespace App;


class StringUtils {

    /**
     * @param string|null $name
     * @return mixed|null The Slug
     */
    public static function slugify($name = null) {
        if(!is_string($name)){
            return $name;
        }
        return str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower($name))));
    }
}