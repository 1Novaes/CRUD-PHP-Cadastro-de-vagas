<?php

namespace App\Entity;

use \App\Db\Database;
use PDO;

class Vaga
{

    public $id;
    public $titulo;
    public $descricao;
    public $ativo;
    public $data;

    /**
     * Método responsavel por cadastrar a vaga no banco;
     * @return boolean
     */

    public function cadastrar()
    {
        // Definir a Data
        $this->data = date('Y-m-d H:i:s');

        // Inserir a vaga no banco e retornar o ID

        $obdatabase = new Database('vagas');


        $this->id = $obdatabase->insert([
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'ativo' => $this->ativo,
            'data' => $this->data

        ]);
        // Retornar sucesso
        return true;
    }
    /**
     * Método responsável por atualizar a avga no banco
     * @return boolean
     */
    public function atualizar()
    {
        return (new Database('vagas'))->update(' id = ' . $this->id, [
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'ativo' => $this->ativo,
            'data' => $this->data
        ]);
    }
    /**
     * Método esponsavel por excluir a vaga 
     * @return boolen
     */

    public function excluir()
    {
        return (new Database('vagas'))->delete(' id = ' . $this->id);
    }
    /**
     * Método responsável por obter as vagas do banco de dados
     * @param string $where
     * @param string $order
     * @param string $limit
     * @return array instancias de vaga ou vazio
     */
    public static function getVagas($where = null, $order = null, $limit = null)
    {
        return (new Database('vagas'))->select($where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }
    /**
     * Método responsavel por buscar uma vaga com base em seu id
     * @param integer $id
     * @return Vaga
     */
    public static function getVaga($id)
    {
        return (new Database('vagas'))->select(' id = ' . $id)->fetchObject(self::class);
    }
}