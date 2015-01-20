<?php
    /*
     * Generate link for browser
     */
     
    $link_repo = \thebuggenie\core\framework\Context::getModule('vcs_integration')->getSetting('browser_url_' . \thebuggenie\core\framework\Context::getCurrentProject()->getID());
    
    if (\thebuggenie\core\framework\Context::getModule('vcs_integration')->getSetting('vcs_mode_' . \thebuggenie\core\framework\Context::getCurrentProject()->getID()) != \thebuggenie\core\entities\VCSIntegration::MODE_DISABLED)
    {
        echo '<a href="'.$link_repo.'" target="_blank" class="button button-blue">'.image_tag('cfg_icon_vcs_integration.png', null, false, 'vcs_integration').__('Source code').'</a>';
    }

?>
