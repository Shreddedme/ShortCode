<?php

namespace App\Repository;

interface LinkRepository
{
    function getAll(): array;
    function save(array $link): void;
    function clear(): void;
    function getByCode(string $code): array;
}