<?php

namespace Yosimar\Corona\Core;

use PDO;
use PDOException;
use Dotenv\Dotenv;

class Database
{

    private static ?PDO $instance = NULL;

    public static function connect(): ?PDO
    {
        try {
            if (!self::$instance) {
                $dotenv = Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT'] . '/corona');
                $dotenv->load();
                $dsn = "mysql:host=" . $_ENV['HOST'] . ";dbname=" . $_ENV['DATABASE'] . ";charset=utf8;";

                self::$instance = new PDO(
                    $dsn,
                    $_ENV['USERNAME'],
                    $_ENV['PASSWORD'],
                    [PDO::ATTR_PERSISTENT => true]
                );

                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

                return self::$instance;
            } else {
                return self::$instance;
            }
        } catch (PDOException $e) {
            error_log("DATABASE::connect -> Error en la conexion con la base de datos" . $e);
            return null;
        }
    }
}