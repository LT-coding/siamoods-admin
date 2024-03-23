<?php

namespace App\Enums;

/**
 *
 */
enum RoleType: string
{
    use EnumTool;

    case developer = 'developer';
    case haySell='haySell';

    case admin = 'Ադմին';
    case editor = 'Խմբագիր';
    case account = 'Հաշիվ';


    /**
     * @param bool $as_string
     * @return array|string
     */
    public static function adminPanelRoles(bool $as_string = false): array|string
    {
        $result= [
            self::admin,
            self::editor
        ];

        return $as_string ? implode('|', $result) : $result;
    }

    /**
     * @param bool $as_string
     * @return array|string
     */
    public static function rolesNames(bool $as_string = false): array|string
    {
        $result= [
            self::admin->value,
            self::editor->value,
            self::account->value
        ];
        return $as_string ? implode('|', $result) : $result;
    }

    /**
     * @param bool $as_string
     * @return array|string
     */
    public static function roles(bool $as_string = false): array|string
    {
        $result= [
            self::admin->name,
            self::editor->name,
            self::account->name
        ];
        return $as_string ? implode('|', $result) : $result;
    }

    /**
     * @param bool $as_string
     * @return array|string
     */
    public static function adminRoles(bool $as_string = false): array|string
    {
        $result= [
            self::admin->name,
            self::editor->name,
        ];
        return $as_string ? implode('|', $result) : $result;

    }

    /**
     * @param bool $as_string
     * @return array|string
     */
    public static function adminRolesList(bool $as_string = false): array|string
    {
        $result= [
            self::admin->name => self::admin->value,
            self::editor->name => self::editor->value
        ];

        return $as_string ? implode('|', $result) : $result;
    }
}
