<?php
if (false) {

    class XFCP_ThemeHouse_Options_Extend_XenForo_ControllerAdmin_Option extends XenForo_ControllerAdmin_Option
    {
    }
}

class ThemeHouse_Options_Extend_XenForo_ControllerAdmin_Option extends XFCP_ThemeHouse_Options_Extend_XenForo_ControllerAdmin_Option
{

    /**
     *
     * @see XenForo_ControllerAdmin_Option::actionIndex()
     */
    public function actionIndex()
    {
        $response = parent::actionIndex();

        if ($response instanceof XenForo_ControllerResponse_View) {
            $addOns = $this->_getAddOnModel()->getAllAddOns();

            $addOnId = $this->_input->filterSingle('addon_id', XenForo_Input::STRING);

            if (!empty($GLOBALS['XenForo_Route_PrefixAdmin_Options']) && !$addOnId) {
                $addOnId = XenForo_Helper_Cookie::getCookie('edit_addon_id');
            }

            if ($addOnId) {
                XenForo_Helper_Cookie::setCookie('edit_addon_id', $addOnId);
            } else {
                XenForo_Helper_Cookie::deleteCookie('edit_addon_id');
            }

            $groupCount = count($response->params['groups']);

            if ($addOnId && !empty($addOns[$addOnId])) {
                XenForo_Helper_Cookie::setCookie('edit_addon_id', $addOnId);

                $addOn = $addOns[$addOnId];

                $response->params['addOnSelected'] = $addOnId;

                if ($addOnId) {
                    foreach ($response->params['groups'] as $groupKey => $group) {
                        if ($addOnId != $group['addon_id']) {
                            unset($response->params['groups'][$groupKey]);
                        }
                    }
                }

                $this->canonicalizeRequestUrl(XenForo_Link::buildAdminLink('add-ons/options', $addOn));
            } else {
                $this->canonicalizeRequestUrl(
                    XenForo_Link::buildAdminLink('add-ons/options',
                        array(
                            'addon_id' => ''
                        )));
            }

            $response->params['addOns'] = $addOns;
            $response->params['groupCount'] = $groupCount;
        }

        return $response;
    }

    /**
     *
     * @see XenForo_ControllerAdmin_Option::_getGroupAddEditResponse()
     */
    protected function _getGroupAddEditResponse(array $group)
    {
        $response = parent::_getGroupAddEditResponse($group);

        if ($response instanceof XenForo_ControllerResponse_View) {
            $addOnId = $this->_input->filterSingle('addon_id', XenForo_Input::STRING);

            if (!empty($GLOBALS['XenForo_Route_PrefixAdmin_Options']) && !$addOnId) {
                $addOnId = XenForo_Helper_Cookie::getCookie('edit_addon_id');
            }

            if ($addOnId && empty($group['addon_id'])) {
                $template['addon_id'] = $addOnId;
                $response->params['addOnSelected'] = $addOnId;

                if (empty($group['group_id'])) {
                    $groupId = str_replace(' ', '_', lcwords(str_replace('_', ' ', $addOnId)));
                    $info = $this->_getOptionModel()->getOptionGroupById($groupId);
                    if (!$info) {
                        $addOn = $this->_getAddOnModel()->getAddOnById($addOnId);
                        $group['new_group_id'] = $groupId;

                        $response->params['masterTitle'] = new XenForo_Phrase(
                            'th_default_option_group_title_for_x_options',
                            array(
                                'title' => $addOn['title']
                            ));

                        $response->params['masterDescription'] = new XenForo_Phrase(
                            'th_default_option_group_description_for_x_options',
                            array(
                                'title' => $addOn['title']
                            ));
                        $group['display_order'] = 2000;
                        $response->params['group'] = $group;
                    }
                }
            }
        }

        return $response;
    }


    /**
     *
     * @see XenForo_ControllerAdmin_Option::actionSaveGroup()
     */
    public function actionSaveGroup()
    {
        $response = parent::actionSaveGroup();

        if ($response instanceof XenForo_ControllerResponse_Redirect) {
            $addOnId = $this->_input->filterSingle('addon_id', XenForo_Input::STRING);

            if ($addOnId) {
                XenForo_Helper_Cookie::setCookie('edit_addon_id', $addOnId);
            }
        }

        return $response;
    }

    /**
     *
     * @see XenForo_ControllerAdmin_Option::_getOptionAddEditResponse()
     */
    protected function _getOptionAddEditResponse(array $option, array $relations = array())
    {
        $response = parent::_getOptionAddEditResponse($option, $relations);

        if ($response instanceof XenForo_ControllerResponse_View) {
            $addOnId = $this->_input->filterSingle('addon_id', XenForo_Input::STRING);

            if (!empty($GLOBALS['XenForo_Route_PrefixAdmin_Options']) && !$addOnId) {
                $addOnId = XenForo_Helper_Cookie::getCookie('edit_addon_id');
            }

            if (count($relations) == 1) {
                $groupIds = array_keys($relations);
                $groupId = reset($groupIds);

                $group = $this->_getOptionGroupOrError($groupId);

                $response->params['group'] = $group;
            }

            if ($addOnId && empty($option['addon_id'])) {
                $template['addon_id'] = $addOnId;
                $response->params['addOnSelected'] = $addOnId;

                if (empty($option['option_id']) && isset($groupId)) {
                    $option['new_option_id'] = $groupId . '_';

                    $response->params['option'] = $option;
                }
            }
        }

        return $response;
    }

    /**
     *
     * @see XenForo_ControllerAdmin_Option::actionSaveOption()
     */
    public function actionSaveOption()
    {
        $response = parent::actionSaveOption();

        if ($response instanceof XenForo_ControllerResponse_Redirect) {
            $addOnId = $this->_input->filterSingle('addon_id', XenForo_Input::STRING);

            if ($addOnId) {
                XenForo_Helper_Cookie::setCookie('edit_addon_id', $addOnId);
            }
        }

        return $response;
    }

    /**
     * Get the phrase model.
     *
     * @return XenForo_Model_Phrase
     */
    protected function _getPhraseModel()
    {
        return $this->getModelFromCache('XenForo_Model_Phrase');
    }
}

if (function_exists('lcfirst') === false) {

    /**
     * Make a string's first character lowercase
     *
     * @param string $str
     * @return string the resulting string.
     */
    function lcfirst($str)
    {
        $str[0] = strtolower($str[0]);
        return (string) $str;
    }
}

if (function_exists('lcwords') === false) {

    function lcwords($str)
    {
        $str = explode(" ", $str);
        $i = 0;
        while ($i < count($str)) {
            $str[$i] = lcfirst($str[$i]);
            $i++;
        }
        return implode(" ", $str);
    }
}