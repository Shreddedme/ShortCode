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
        $params = [
            'url' => $link['original_url'],
            'code' => $link['short_code'],
            'count' => $link['count_transition']
        ];
        $sql = 'INSERT INTO link_entity  (original_url, short_code, count_transition) VALUES (:url, :code, :count)';

        $statement = $this->connection->prepare($sql);
        $statement->execute($params);
    }

    function getByCode(string $code): array
    {
        $params['code'] = $code;
        $sql = 'SELECT * FROM link_entity WHERE short_code = :code';

        $statement = $this->connection->prepare($sql);
        $statement->execute($params);

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result[0] ?? [];
    }

    function update(array $link): void
    {
        $params = [
            'code' => $link ['short_code'],
            'count_transition' => $link['count_transition']
        ];
        $sql = 'UPDATE link_entity SET count_transition = :count_transition WHERE short_code = :code';

        $statement = $this->connection->prepare($sql);
        $statement->execute($params);
    }

    function delete(string $code): void
    {
        $params['code'] = $code;
        $sql = 'DELETE FROM link_entity WHERE short_code = :code';

        $statement = $this->connection->prepare($sql);
        $statement->execute($params);
    }
}