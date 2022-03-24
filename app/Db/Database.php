<?php

namespace App\Db;

use \PDO;
use \PDOException;

class Database
{
    // Credenciais para a criação do banco
    const HOST =   'localhost';
    const DB_NAME = 'wdev_vagas';
    const USER = 'root';
    const PASSWORD = '';

    /**
     * Tabela a ser manipulada
     * @var string
     */
    private $table;

    /**
     * Instancia de conexão com o banco de dados
     * @var PDO
     */
    private $connection;

    /**
     * Define a tabela e instancia a conexão 
     * @param $table ou pode ser null
     */

    public function __construct($table = null)
    {
        $this->table = $table;
        $this->setConnection();
    }

    /**
     * Método responsável por criar uma conexão com o banco de dados
     */
    public function setConnection()
    {
        //Tratando o erro
        try {
            $this->connection = new PDO("mysql:host=" . self::HOST . ";dbname=" . self::DB_NAME, self::USER, self::PASSWORD);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            //Aqui é apenas um exemplo , devemos mostrar o erro de forma mais amigavel ao usuario
            die('ERROR:' . $e->getMessage());
        };
    }

    /**
     * Método responsável por executar queries dentro do banco de dados
     * @param String $query
     * @param String $params
     * @return PDOStatement
     */

    public function execute($query, $params = [])
    {
        try {
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        } catch (PDOException $e) {
            //Aqui é apenas um exemplo , devemos mostrar o erro de forma mais amigavel ao usuario
            die('ERROR:' . $e->getMessage());
        };
    }

    /**
     * Método responsavel por inserir os dados no banco.
     * @param array $values [field => value]
     * @return interger - ID
     */
    public function insert($values)
    {
        // Dados da query
        $fields = array_keys($values);
        $binds = array_pad([], count($fields), '?');


        // Monta a query
        $query = 'INSERT INTO ' . $this->table . '(' . implode(',', $fields) . ') VALUES (' . implode(',', $binds) . ')';

        // Executa o insert
        $this->execute($query, array_values($values));

        // Retorna o id inserido
        return $this->connection->lastInsertId();
    }

    /**
     * Método responsável por executar uma consulta no banco
     * @param string $where
     * @param string $order
     * @param string $limit
     * @return PDOStatement
     */
    public function select($where = null, $order = null, $limit = null, $fields = '*')
    {
        // Dados da query

        $where = strlen($where) ? 'WHERE' . $where : '';
        $order = strlen($order) ? 'ORDER BY' . $order : '';
        $limit = strlen($limit) ? 'LIMIT' . $limit : '';

        // Monta a query
        $query = 'SELECT ' . $fields . ' FROM ' . $this->table . ' ' . $where . ' ' . $order . ' ' . $limit;


        // Executa a query
        return $this->execute($query);
    }

    /**
     * Método responsável por fazer atualizaçoes no banco de dados
     * @param string $where
     * @param array $values
     * @return boolean
     */
    public function update($where, $values)
    {
        // Dados da query
        $fields = array_keys($values);

        // Monta a query
        $query = 'UPDATE ' . $this->table . ' SET ' . implode('=?, ', $fields) . '=? WHERE ' . $where;

        //EXECUTA A QUER
        $this->execute($query, array_values($values));
        return true;
    }
    /**
     * Método responsável por excluir dados do banco
     * @return boolean;
     */
    public function delete($where)
    {
        //Monta a query
        $query = 'DELETE FROM ' . $this->table . ' WHERE ' . $where;


        //Monta a query
        $this->execute($query);

        //Retorna sucesso
        return true;
    }
}