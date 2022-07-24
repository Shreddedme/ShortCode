<?php

namespace App\Repository;

use PDO;

class DataBaseLinkRepository implements LinkRepository
{
    private PDO $connection;

    public function __construct()
    {
        $dbPort = 5437;
        $host = '192.168.1.108';
        $dbName = 'customer-activity';
        $dbUser = 'customer-activity';
        $dbPassword = 'customer-activity';
        $dsn = "pgsql:dbname=$dbName;host=$host;port=$dbPort";
        $this->connection = new PDO($dsn, $dbUser, $dbPassword);
    }

    function getAll(): array
    {
        $sql = 'SELECT * FROM link_entity';

        $statement = $this->connection->prepare($sql);
        $statement->execute([]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function save(array $link): void
    {

    }

    function clear(): void
    {
        // TODO: Implement clear() method.
    }

    function getByCode(string $code): array
    {
        $params['code'] = $code;
        $sql = 'SELECT * FROM link_entity WHERE short_code = :code';

        $statement = $this->connection->prepare($sql);
        $statement->execute($params);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function update(array $link): void
    {
        // TODO: Implement update() method.
    }

    function delete(string $code): void
    {
        // TODO: Implement delete() method.
    }
}