<?php

namespace App\Enums;

/**
 *
 */
enum RoleType: string
{
    use EnumTool;

    case developer = 'Developer';
    case admin = 'Admin';
    case account = 'Account';


    /**
     * @param bool $as_string
     * @return array|string
     */
    public static function adminRoles(bool $as_string = false): array|string
    {
        $result= [
            self::admin
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
            self::admin->value => self::admin->value
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
            self::account->name
        ];
        return $as_string ? implode('|', $result) : $result;
    }

    /**
     * @param bool $as_string
     * @return array|string
     */
    public static function adminPanelPermissionRoles(bool $as_string = false): array|string
    {
        $result= [
            self::developer->name,
            self::admin->name,
        ];
        return $as_string ? implode('|', $result) : $result;
    }
}
