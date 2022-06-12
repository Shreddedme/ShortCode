<?php

namespace App\Repository;

class SessionLinkRepository implements LinkRepository
{
    public function __construct()
    {
        session_start();
    }

    public function clear(): void
    {
        $_SESSION['links'] = [];
    }

    function getByCode(string $code): array
    {
        return $_SESSION['links'];
    }

    function save(array $link): void
    {
        $_SESSION['links'][] = $link;
    }
}