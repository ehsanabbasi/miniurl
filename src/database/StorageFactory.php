<?php
namespace Miniurl\Database;

use Miniurl\Database\Storage\MysqlStorage;
use Miniurl\Database\Storage\RedisStorage;
use Predis;
use PDO;

class StorageFactory extends AbstractStorageFactory
{
    const REDIS = 'redis';
    const MYSQL = 'mysql';

    public static function getStorage(array $config)
    {
        $database = null;
        switch ($config['databaseType']) {
            case self::MYSQL:
                $database = new MysqlStorage($config, new PDO($config));
                break;
            case self::REDIS:
            default:
                Predis\Autoloader::register();
                $database = new RedisStorage($config, new Predis\Client($config));
                break;
        }
        return $database;
    }
}
