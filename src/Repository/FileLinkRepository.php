<?php

namespace App\Repository;

class FileLinkRepository implements LinkRepository
{
    private CONST FILE_PATH = '/www/RunTime/file.txt';

    function getAll(): array
    {
        $data = file(self::FILE_PATH)[0] ?? '';
        return json_decode($data, true) ?? [];
    }

    function save(array $link): void
    {
        $oldData = $this->getAll();
        $oldData[] = $link;
        $serialized = json_encode($oldData);
        file_put_contents(self::FILE_PATH, $serialized);

    }

    function clear(): void
    {
        $oldData = [];
        file_put_contents(self::FILE_PATH, $oldData);
    }

    function getByCode(string $code): array
    {
        $links = $this->getAll();
        foreach ($links as $link) {
           if ($link['shortCode'] === $code) {
               return $link;
           }
        }

        return [];
    }

}
