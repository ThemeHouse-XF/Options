<?php
if (false) {

    class XFCP_ThemeHouse_Options_Extend_XenForo_Route_PrefixAdmin_AddOns extends XenForo_Route_PrefixAdmin_AddOns
    {
    }
}

class ThemeHouse_Options_Extend_XenForo_Route_PrefixAdmin_AddOns extends XFCP_ThemeHouse_Options_Extend_XenForo_Route_PrefixAdmin_AddOns
{

    /**
     *
     * @see XenForo_Route_PrefixAdmin_AddOns::match()
     */
    public function match($routePath, Zend_Controller_Request_Http $request, XenForo_Router $router)
    {
        $parts = explode('/', $routePath, 3);

        switch ($parts[0]) {
            case 'options':
                $parts = array_slice($parts, 1);
                $routePath = implode('/', $parts);
                return $router->getRouteMatch('XenForo_ControllerAdmin_Option', $routePath, 'options');
        }

        if (count($parts) > 1) {
            switch ($parts[1]) {
                case 'options':
                    $action = $router->resolveActionWithStringParam($routePath, $request, 'addon_id');
                    $parts = array_slice($parts, 2);
                    $routePath = implode('/', $parts);
                    return $router->getRouteMatch('XenForo_ControllerAdmin_Option', $routePath, 'options');
            }
        }

        return parent::match($routePath, $request, $router);
    }
}