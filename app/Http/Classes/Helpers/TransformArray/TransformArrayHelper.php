<?php

namespace App\Http\Classes\Helpers\TransformArray;

class TransformArrayHelper
{
    public static function setFieldByCondition(array $dataMain, array $dataSet, string $fieldCondName, string $fieldAddName, $defaultValue = null) {
        if (count($dataMain) > 0)
            foreach ($dataMain as $index => &$item) {
                $item[$fieldAddName] = (isset($dataSet[$item[$fieldCondName]]))
                    ? $dataSet[$item[$fieldCondName]]
                    : $defaultValue;
            }
        return $dataMain;
    }

    public static function setMainFieldItem(array $data, string $mainFieldName) {
        $result = [];
        if (count($data) > 0)
            foreach ($data as $index => $item) {
                $result[$item[$mainFieldName]] = $item;
            }
        return $result;
    }

    public static function setMainFieldToItemField(array $data, string $mainFieldName, string $equalFieldName, string $defValue = '') {
        $result = [];
        if (count($data) > 0)
            foreach ($data as $index => $item) {
                $result[$item[$mainFieldName]] = $item[$equalFieldName] ?? $defValue;
            }
        return $result;
    }

    public static function getArrayUniqueByField(array $dataArray, string $field): array
    {
        return array_values(array_unique(array_column($dataArray, $field)));
    }

    public static function getSumByField(array $dataArray, string $field): float|int
    {
        return array_sum(array_values(array_column($dataArray, $field)));
    }

    public static function compareSimpleArray(array $data1, array $data2) : array {
        $arrayDiff = [
            ...array_diff($data1, $data2),
            ...array_diff($data2, $data1)
        ];
        return $arrayDiff;
    }

    public static function countArrayValues(array $data) : int {
        $count = 0;
        if (count($data)>0)
            foreach ($data as $index => $item) {
                $count += count($item);
            }
        return $count;
    }

    public static function addIndexByFieldName(array $data, string $fieldName, string $indexName = 'idx') : array {
        $simpleString = null;
        $simpleCounter = 0;
        if (count($data))
            foreach ($data as $index => &$item) {
                if ($item[$fieldName]!==$simpleString) {
                    $simpleCounter = 0;
                    $simpleString = $item[$fieldName];
                } else
                    $simpleCounter++;
                $item[$indexName] = $simpleCounter;
            }
        return $data;
    }

    public static function removeHtmlTags(array $data, string $field): array
    {
        foreach ($data as &$item)
        {
            if(array_key_exists($field,$item)){
                $item[$field] = strip_tags(htmlspecialchars_decode($item[$field]));
            }
        }
        return $data;
    }
    public static function callbackSearchFirstInArray(array $array, callable $callback): ?array
    {
        foreach ($array as $item)
        {
            if($callback($item)){
                return $item;
            }
        }
        return null;
    }

    public static function callbackSearchAllInArray(array $array, callable $callback): array
    {
        $result = [];
        foreach ($array as $item)
        {
            if($callback($item)){
                $result[] = $item;
            }
        }
        return $result;
    }

    public static function callbackArrayMerge(array $array1, array $array2, callable $callback): array
    {
        $result = [];
        foreach ($array1 as $item1)
        {
            foreach ($array2 as $item2)
            {
                if($callback($item1,$item2)){
                    $result[] = array_merge($item1,$item2);
                }
            }
        }
        return $result;
    }

    public static function getElementByNestedKeys(array $data, array $keys)
    {
        foreach($keys as $key) {
            if (is_array($data) && array_key_exists($key, $data)) {
                $data = $data[$key];
            } else {
                return null;
            }
        }
        return $data;
    }
}
