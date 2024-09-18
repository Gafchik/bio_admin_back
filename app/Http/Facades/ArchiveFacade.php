<?php

namespace App\Http\Facades;

use App\Http\Classes\Core\Archive\ArchiveInterface;
use Illuminate\Support\Facades\Facade;

class ArchiveFacade extends Facade
{
    /**
     * @method static string createZipArchive(array $data);
     * @see ArchiveInterface
     */
    protected static function getFacadeAccessor()
    {
        return 'archive_facade';
    }
}
