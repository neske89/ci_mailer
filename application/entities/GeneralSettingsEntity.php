<?php


namespace Application\Entities;


class GeneralSettingsEntity extends BaseEntity
{
    public $id;
    public $name;
    public $value;

    /**
     * GeneralSettingsEntity constructor.
     * @param $id
     * @param $name
     * @param $value
     */
    public function __construct($name, $value,$id = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
    }


}

