<?php

namespace App\Http\Classes\Core\Archive;

interface ArchiveInterface
{
    public function createZipArchive(array $data): string;
}
