<?php

namespace App\Model\Entity;

use \PDOStatement;
use \WilliamCosta\DatabaseManager\Database;

class Testimony
{
    /**
     * testimony ID
     *
     * @var int
     */
    public $id;

    /**
     * testimony user name
     *
     * @var string
     */
    public $nome;

    /**
     * testimony message
     *
     * @var string
     */
    public $mensagem;

    /**
     * testimony date
     *
     * @var string
     */
    public $data;

    /**
     * register the actual instance on the database
     *
     * @return bool
     */
    public function register(): bool
    {
        //SETS THE DATE
        $this->data = date("Y-m-d H:i:s");

        //INSERTS THE DATA INTO THE DATABASE
        $this->id = (new Database("depoimentos"))->insert([
            "nome"     => $this->nome,
            "mensagem" => $this->mensagem,
            "data"     => $this->data
        ]);

        //SUCESS
        return true;
    }

    /**
     * update the actual instance on the database
     *
     * @return bool
     */
    public function update(): bool
    {
        //UPDATE THE DATA INTO THE DATABASE
        return (new Database("depoimentos"))->update("id = ".$this->id, [
            "nome"     => $this->nome,
            "mensagem" => $this->mensagem
        ]);
    }

    /**
     * deletes a testiomny from the DB
     *
     * @return bool
     */
    public function delete(): bool
    {
        //DELETE THE TESTIMONY FROM THE DATABASE
        return (new Database("depoimentos"))->delete("id = ".$this->id);
    }

    /**
     * returns a testimony by ID
     *
     * @param int $id
     * @return Testimony
     */
    public static function getTestimonyById(int $id): Testimony|false
    {
        return self::getTestimonies("id = ".$id)->fetchObject(self::class);
    }

    /**
     * returns the testimonies
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $field
     * @return PDOStatement
     */
    public static function getTestimonies(
        string|null $where = null,
        string|null $order = null,
        string|null $limit = null,
        string $fields = "*"
    ): PDOStatement|false {
        return (new Database("depoimentos"))->select($where, $order, $limit, $fields);
    }
}