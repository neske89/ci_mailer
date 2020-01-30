<?php
namespace app\application\entities;
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
     * SentEmailEntity constructor.
     * @param string $to_email
     * @param string $subject
     * @param string $body
     * @param null $id
     */
    public function __construct($to_email, $subject, $body,$id = null)
    {
        $this->to_email = $to_email;
        $this->subject = $subject;
        $this->body = $body;
        $this->id = $id;
    }


}

