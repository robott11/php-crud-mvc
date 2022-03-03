<?php

namespace App\Model\Entity;

use \PDOStatement;
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
     * register the instance on the database
     *
     * @return bool
     */
    public function register(): bool
    {
        //INSERT THE INSTANCE ON DB
        $this->id = (new Database("usuarios"))->insert([
            "nome"  => $this->nome,
            "email" => $this->email,
            "senha" => $this->senha
        ]);

        //SUCCESS
        return true;
    }

    /**
     * update the actual instance on the database
     *
     * @return bool
     */
    public function update(): bool
    {
        return (new Database("usuarios"))->update("id = ".$this->id, [
            "nome"  => $this->nome,
            "email" => $this->email,
            "senha" => $this->senha
        ]);
    }

    /**
     * delete a user on the database
     *
     * @return bool
     */
    public function delete(): bool
    {
        return (new Database("usuarios"))->delete("id = ".$this->id);
    }

    /**
     * returns a user based on his ID
     *
     * @param int $id
     * @return User
     */
    public static function getUserById(int $id): User|false
    {
        return self::getUsers("id = ".$id)->fetchObject(self::class);
    }

    /**
     * returns a user based on his email
     *
     * @param string $email
     * @return User
     */
    public static function getUserByEmail(string $email): User|false
    {
        return self::getUsers("email = '".$email."'")->fetchObject(self::class);
    }

    /**
     * returns the users
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $field
     * @return PDOStatement
     */
    public static function getUsers(
        string|null $where = null,
        string|null $order = null,
        string|null $limit = null,
        string $fields = "*"
    ): PDOStatement|false {
        return (new Database("usuarios"))->select($where, $order, $limit, $fields);
    }
}
