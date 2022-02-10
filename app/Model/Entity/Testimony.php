<?php
namespace App\Model\Entity;

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
        $this->date = date("Y-m-d H:i:s");

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
     * returns the testimonies
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $field
     * @return PDOStatement
     */
    public static function getTestimonies($where = null, $order = null, $limit = null, $fields = "*")
    {
        return (new Database("depoimentos"))->select($where, $order, $limit, $fields);
    }
}