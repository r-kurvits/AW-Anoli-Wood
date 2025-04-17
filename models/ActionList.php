<?php
namespace app\models;

class ActionList
{
    const ACTION_ADMIN_USER = 1;
    const ACTION_FREE_USER = 2;
    const ACTION_PREMIUM_USER = 3;
    const ACTION_SHOW_RUNNER = 4;

    public static function getPermissions() {
        return [
            self::ACTION_ADMIN_USER,
            self::ACTION_PREMIUM_USER,
            self::ACTION_FREE_USER,
            self::ACTION_SHOW_RUNNER,
        ];
    }

    public static function getLabels() {
        return [
            self::ACTION_FREE_USER => "Free user",
            self::ACTION_PREMIUM_USER => "Premium user",
            self::ACTION_ADMIN_USER => "Admin user",
            self::ACTION_SHOW_RUNNER => "Show runner"
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
