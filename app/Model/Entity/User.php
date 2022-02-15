<?php
namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class User
{
    /**
     * user ID
     *
     * @var int
     */
    public $id;

    /**
     * user name
     *
     * @var string
     */
    public $nome;

    /**
     * user email
     *
     * @var string
     */
    public $email;

    /**
     * user password
     *
     * @var string
     */
    public $senha;

    /**
     * returns a user based on his email
     *
     * @param string $email
     * @return User
     */
    public static function getUserByEmail(string $email)
    {
        return (new Database("usuarios"))->select("email = '".$email."'")->fetchObject(self::class);
    }
}
