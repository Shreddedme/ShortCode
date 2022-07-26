<?php

namespace App\Repository;

interface LinkRepository
{
    function getAll(): array;
    function save(array $link): void;
    function getByCode(string $code): array;
    function update(array $link): void;
    function delete(string $code): void;
}