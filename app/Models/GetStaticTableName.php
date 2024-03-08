<?php

namespace App\Models;

trait GetStaticTableName
{
    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public static function getConnect()
    {
        return with(new static)->getConnectionName();
    }
}
