<?php

namespace App\Repositories\Contracts;

use App\Url;

interface UrlRepositoryInterface
{
    public function save(string $url) : string;
    public function getByUuid(string $uuid): array;
    public function updateHitByUuid(string $uuid): int;
    public function updateByUuid(string $uuid, array $dataToUpdate): int;
}
