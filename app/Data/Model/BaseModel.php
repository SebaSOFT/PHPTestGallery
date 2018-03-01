<?php
/**
 * User: SebaSOFT
 * Date: 1/3/2018
 */

namespace App\Data\Model;


abstract class BaseModel implements \JsonSerializable {

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    abstract public function jsonSerialize();
}