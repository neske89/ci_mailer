<?php


namespace Application\Entities;


class SentEmailEntity extends BaseEntity
{
    /*** @var string */
    public $id;
    /*** @var string */
    public $to_email;
    /*** @var string */
    public $subject;
    /*** @var string */
    public $body;

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

