<?php
if (false) {

    class XFCP_ThemeHouse_Options_Extend_XenForo_Route_PrefixAdmin_Options extends XenForo_Route_PrefixAdmin_Options
    {
    }
}

class ThemeHouse_Options_Extend_XenForo_Route_PrefixAdmin_Options extends XFCP_ThemeHouse_Options_Extend_XenForo_Route_PrefixAdmin_Options
{

    /**
     *
     * @see XenForo_Route_PrefixAdmin_Options::match()
     */
    public function match($routePath, Zend_Controller_Request_Http $request, XenForo_Router $router)
    {
        $GLOBALS['XenForo_Route_PrefixAdmin_Options'] = $this;

        return parent::match($routePath, $request, $router);
    }
}