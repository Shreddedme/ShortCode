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
        $this->rewriteFile($oldData);
//        $serialized = json_encode($oldData);
//        file_put_contents(self::FILE_PATH, $serialized);
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

    function update(array $link): void
    {
        $oldData = $this->getAll();
        foreach ($oldData as &$elem) {
            if ($elem['shortCode'] == $link['shortCode']) {
                $elem = $link;
            }
        }
        $this->rewriteFile($oldData);
    }

    function delete(string $code): void
    {
        $data = $this->getAll();

        foreach ($data as $key=>$item) {
            if ($item['shortCode'] === $code) {
               unset($data[$key]);
            }
        }
        $this->rewriteFile($data);
    }

    private function rewriteFile(array $data): void
    {
        $serialized = json_encode($data);
        file_put_contents(self::FILE_PATH, $serialized);
    }
}
