<?php
namespace app\models;

class ActionList
{
    const ACTION_ADMIN_USER = 1;
    const ACTION_FREE_USER = 2;

    public static function getPermissions() {
        return [
            self::ACTION_ADMIN_USER,
            self::ACTION_FREE_USER,
        ];
    }

    public static function getLabels() {
        return [
            self::ACTION_FREE_USER => "Free user",
            self::ACTION_ADMIN_USER => "Admin user",
        ];
    }

    public static function getLabel($id) {
        $actionLabels = self::getLabels();

        if(isset($actionLabels[$id])) {
            return $actionLabels[$id];
        }

        return "Invalid action name.";
    }
}
