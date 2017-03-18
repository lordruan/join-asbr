<?php
class Database
{
    public static $db;

    public function __construct()
    {
        $db_host = "172.17.141.224";
        $db_nome = "joinasbr";
        $db_usuario = "root";
        $db_senha = "";
        $db_driver = "mysql";


        try
        {
            # Atribui o objeto PDO à variável $db.
            self::$db = new PDO("$db_driver: host=$db_host; dbname=$db_nome", $db_usuario, $db_senha);
            # Garante que o PDO lance exceções durante erros.
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            # Garante que os dados sejam armazenados com codificação UFT-8.
            self::$db->exec('SET NAMES utf8');
        }
        catch (PDOException $e)
        {
            die("Connection Error: " . $e->getMessage());
        }
    }
    public static function conexao()
    {
        if (!self::$db)
        {
            new Database();
        }
        return self::$db;
    }

    public function getAll($table = null)
    {
        if (!is_null($table)){
            try {
                $sql = sprintf("SELECT * FROM %s", $table);
                $stm = self::$db->prepare($sql);
                $stm->execute();
                $dados = $stm->fetchAll(PDO::FETCH_OBJ);
                return [true,$dados];
            } catch (PDOException $e) {
                return [false,$e];
            }
        }
    }
    public function inserir($table = null, $campos = null,$dados = null)
    {
        if (!is_null($table))
        if (!is_null($campos))
        if (!is_null($dados))
        {
            try {
                $sql = sprintf("Insert Into %s (%s) VALUES (%s)", $table, $campos, $dados);
                $stm = self::$db->prepare($sql);
                $stm->execute();
                $retorno = self::$db->lastInsertId();
                return [true,$retorno];
            } catch (PDOException $e) {
                return [false,$e];
            }
        }
    }
    public function executar($sql=null)
    {
        if (!is_null($sql)){
            try {
                $stm = self::$db->prepare($sql);
                $stm->execute();
                $dados = $stm->fetchAll(PDO::FETCH_OBJ);
                return [true,$dados];
            } catch (PDOException $e) {
                return [false,$e];
            }
        }
    }

}
