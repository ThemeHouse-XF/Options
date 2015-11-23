<?php

class ThemeHouse_Options_Listener_LoadClass extends ThemeHouse_Listener_LoadClass
{

    protected function _getExtendedClasses()
    {
        return array(
            'ThemeHouse_Options' => array(
                'controller' => array(
                    'XenForo_ControllerAdmin_Option'
                ), 
                'route_prefix' => array(
                    'XenForo_Route_PrefixAdmin_AddOns',
                    'XenForo_Route_PrefixAdmin_Options'
                ), 
            ), 
        );
    }

    public static function loadClassController($class, array &$extend)
    {
        $extend = self::createAndRun('ThemeHouse_Options_Listener_LoadClass', $class, $extend, 'controller');
    }

    public static function loadClassRoutePrefix($class, array &$extend)
    {
        $extend = self::createAndRun('ThemeHouse_Options_Listener_LoadClass', $class, $extend, 'route_prefix');
    }
}