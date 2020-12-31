<?php
include_once("config.php");
include_once("bd.php");

class User
{
    public $id;
    public $fullname;
    public $login;
    public $password;
    public $email;
    public $profile;

    /**
     * User constructor.
     * @param $id
     * @param $fullname
     * @param $login
     * @param $password
     * @param $email
     * @param $profile
     */
    public function __construct($id, $fullname, $login, $password, $email, $profile)
    {
        $this->id = $id;
        $this->fullname = $fullname;
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
        $this->profile = $profile;
    }

}
?>
