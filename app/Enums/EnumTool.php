<?php

namespace App\Enums;

use ReflectionClass;

/**
 *
 */
trait EnumTool
{
    /**
     * @param array|null $excepts
     * @param bool $as_string
     * @return array|string
     */
    public static function excepts(array $excepts = null, bool $as_string = false): array|string
    {
        $result = [];
        foreach (self::cases() as $role) {
            if (!$excepts || !in_array($role->value, $excepts, true)) {
                $result[] = $role->value;
            }
        }
        return $as_string ? implode('|', $result) : $result;
    }

    /**
     * @param array|null $expects
     * @param bool $as_string
     * @return array|string
     */
    public static function only(array $expects = null, bool $as_string = false): array|string
    {
        $result = [];
        foreach (self::cases() as $role) {
            if (!$expects || in_array($role->value, $expects, true)) {
                $result[] = $role->value;
            }
        }
        return $as_string ? implode('|', $result) : $result;
    }

    public static function getConstants(): array
    {
        $oClass = new ReflectionClass(__CLASS__);
        return $oClass->getConstants();
    }

    public static function getKeys(): array
    {
        return array_keys(self::getConstants());
    }

    public static function getValues(): array
    {
        return array_values(self::getConstants());
    }

    public static function list(bool $as_string = false): array|string
    {
        $result = [];
        foreach (self::cases() as $case) {
            $result[$case->name] = $case->value;
        }
        return $as_string ? implode('|', $result) : $result;
    }
}
