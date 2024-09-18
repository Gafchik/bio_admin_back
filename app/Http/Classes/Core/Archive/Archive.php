<?php

namespace App\Http\Classes\Core\Archive;

use App\Http\Classes\Structure\CDateTime;
use ZipArchive;

class Archive implements ArchiveInterface
{
    private string $zipName;

    public function __construct()
    {
        $this->zipName = storage_path('framework/MyZip_' . CDateTime::getCurrentDateTimeStamp());
    }

    public function createZipArchive(array $data): string
    {
        $zip = new ZipArchive;
        $zip->open($this->zipName, ZipArchive::CREATE);

        foreach ($data as $name => $item){
            $function = $item['outputFunction'];
            $zip->addFromString($name.$item['mime'],$item['class']->$function());
        }

        $zip->close();
        $zipContents = file_get_contents($this->zipName);
        unlink($this->zipName);

        return $zipContents;
    }
}
