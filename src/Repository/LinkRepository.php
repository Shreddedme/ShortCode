<?php

namespace App\Repository;

interface LinkRepository
{
    function getByCode(string $code): array;
    function save(array $link): void;
    function clear(): void;
}