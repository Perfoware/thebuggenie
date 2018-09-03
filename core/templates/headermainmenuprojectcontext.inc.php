<?php

    use thebuggenie\core\framework;

?>
<nav class="header_menu project_context" id="project_menu">
    <ul>
        <?php $page = (in_array($tbg_response->getPage(), array('project_dashboard', 'project_scrum_sprint_details', 'project_timeline', 'project_team', 'project_roadmap', 'project_statistics', 'vcs_commitspage'))) ? $tbg_response->getPage() : 'project_dashboard'; ?>
        <li class="with-dropdown <?php if (in_array($tbg_response->getPage(), array('project_dashboard', 'project_scrum_sprint_details', 'project_timeline', 'project_team', 'project_roadmap', 'project_statistics', 'vcs_commitspage'))): ?>selected<?php endif; ?>">
            <?php echo link_tag(make_url($page, array('project_key' => framework\Context::getCurrentProject()->getKey())), fa_image_tag('columns') . tbg_get_pagename($tbg_response->getPage()) . fa_image_tag('caret-down', ['class' => 'dropdown-indicator']), ['class' => 'dropper']); ?>
            <ul id="project_information_menu" class="tab_menu_dropdown popup_box">
                <?php include_component('project/projectinfolinks', array('submenu' => true)); ?>
            </ul>
        </li>
        <?php if ($tbg_user->canSearchForIssues()): ?>
            <li class="with-dropdown <?php if (in_array($tbg_response->getPage(), array('project_issues', 'viewissue'))): ?>selected<?php endif; ?>">
                <?php echo link_tag(make_url('project_issues', array('project_key' => framework\Context::getCurrentProject()->getKey())), fa_image_tag('file-text-o') . __('Issues') . fa_image_tag('caret-down', ['class' => 'dropdown-indicator']), ['class' => 'dropper']); ?>
                <ul id="issues_menu" class="tab_menu_dropdown popup_box">
                    <li><?php echo link_tag(make_url('project_open_issues', array('project_key' => framework\Context::getCurrentProject()->getKey())), fa_image_tag('search') . __('Open issues for this project')); ?></li>
                    <li><?php echo link_tag(make_url('project_closed_issues', array('project_key' => framework\Context::getCurrentProject()->getKey())), fa_image_tag('search') . __('Closed issues for this project')); ?></li>
                    <li><?php echo link_tag(make_url('project_wishlist_issues', array('project_key' => framework\Context::getCurrentProject()->getKey())), fa_image_tag('search') . __('Wishlist for this project')); ?></li>
                    <li><?php echo link_tag(make_url('project_milestone_todo_list', array('project_key' => framework\Context::getCurrentProject()->getKey())), fa_image_tag('search') . __('Milestone todo-list for this project')); ?></li>
                    <li><?php echo link_tag(make_url('project_most_voted_issues', array('project_key' => framework\Context::getCurrentProject()->getKey())), fa_image_tag('search') . __('Most voted for issues')); ?></li>
                    <li><?php echo link_tag(make_url('project_month_issues', array('project_key' => framework\Context::getCurrentProject()->getKey())), fa_image_tag('search') . __('Issues reported this month')); ?></li>
                    <li><?php echo link_tag(make_url('project_last_issues', array('project_key' => framework\Context::getCurrentProject()->getKey(), 'units' => 30, 'time_unit' => 'days')), fa_image_tag('search') . __('Issues reported last 30 days')); ?></li>
                    <li class="header"><?php echo __('Recently watched issues'); ?></li>
                    <?php if (array_key_exists('viewissue_list', $_SESSION) && is_array($_SESSION['viewissue_list'])): ?>
                        <?php foreach ($_SESSION['viewissue_list'] as $k => $i_id): ?>
                            <?php
                            try
                            {
                                $an_issue = \thebuggenie\core\entities\tables\Issues::getTable()->getIssueById($i_id);
                                if (!$an_issue instanceof \thebuggenie\core\entities\Issue)
                                {
                                    //unset($_SESSION['viewissue_list'][$k]);
                                    continue;
                                }
                            }
                            catch (\Exception $e)
                            {
                                //unset($_SESSION['viewissue_list'][$k]);
                            }
                            echo '<li>'.link_tag(make_url('viewissue', array('project_key' => $an_issue->getProject()->getKey(), 'issue_no' => $an_issue->getFormattedIssueNo())), $an_issue->getFormattedTitle(true, false), array('title' => $an_issue->getFormattedTitle(true, true))).'</li>';
                            ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if (!isset($an_issue)): ?>
                        <li class="disabled" href="javascript:void(0);"><?php echo __('No recent issues'); ?></li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>
        <?php framework\Event::createNew('core', 'templates/headermainmenu::projectmenulinks', framework\Context::getCurrentProject())->trigger(); ?>
    </ul>
    <?php if (!framework\Context::getCurrentProject()->isArchived() && !framework\Context::getCurrentProject()->isLocked() && $tbg_user->canReportIssues(framework\Context::getCurrentProject())): ?>
        <div class="reportissue_button_container">
            <?php echo javascript_link_tag(fa_image_tag('plus') . '<span>'.__('Report an issue').'</span>', array('onclick' => "TBG.Issues.Add('" . make_url('get_partial_for_backdrop', array('key' => 'reportissue', 'project_id' => framework\Context::getCurrentProject()->getId())) . "');", 'class' => 'button button-lightblue', 'id' => 'reportissue_button')); ?>
        </div>
        <script type="text/javascript">
            var TBG;

            require(['domReady', 'thebuggenie/tbg', 'jquery'], function (domReady, tbgjs, jQuery) {
                domReady(function () {
                    TBG = tbgjs;
                    var hash = window.location.hash;

                    if (hash != undefined && hash.indexOf('report_an_issue') == 1) {
                        jQuery('#reportissue_button').trigger('click');
                    }
                });
            });
        </script>
    <?php endif; ?>
</nav>
