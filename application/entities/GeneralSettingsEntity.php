<?php
namespace app\application\entities;
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
    public function __construct($name=null, $value=null,$id = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
    }


}

