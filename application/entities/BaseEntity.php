<?php

namespace app\application\entities;

class BaseEntity
{
    private $created;
    private $modified;


    public static function FromArray($data) {
        if (empty($data)) {
            throw new \Exception('Provided array has no data!');
        }
        $instance = new static();
        foreach ($data as $key=>$value) {
            if (property_exists(new static(),$key)) {
                $instance->$key = $value;
            }
        }
        return $instance;
    }
}
