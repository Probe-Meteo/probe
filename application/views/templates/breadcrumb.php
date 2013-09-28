<?php
/**
 * Breadcrumb template
 *
 * @category Template
 * @package  Probe
 * @author   Édouard Lopez <dev+probe@edouard-lopez.com>
 * @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
 * @link     http://probe.com/doc
 * @param array $breadcrumb
 * array(
 *     '0' => 'i18n.key-text',
 *     '1' => array(
 *         'status'  =>  'active',
 *         'url'     =>  '/viewer',
 *         'i18n'    =>  '*.view.label'
 *     )
 * )
 */
?>
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <?php if (isset($breadcrumb)): ?>
    <ul class="nav breadcrumb">
    <?php foreach ($breadcrumb as $key => $step): ?>
        <?php if (is_array($step)): ?>
        <li class="<?=isset($step['status']) ? $step['status'] : 'disabled';?>">
            <a href="<?=$step['url']?>"><?=i18n($step['i18n'], true)?></a>
        <?php else: ?>
        <li>
            <?= i18n($step); ?>
        <?php endif;?>

        <span class="divider">/</span>
        </li>
    <?php endforeach ?>
    </ul>
    <?php endif ?>

    <ul id="access-profile" class="breadcrumb nav pull-right">
        <li class="divider-vertical"></li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <?=i18n('profile.request:settings.label')?> <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a href="/profile/me"><?=i18n('profile.request.label')?></a>
                </li>
                <li>
                    <a href="/profile/settings"><?=i18n('profile.request:settings.label')?></a>
                </li>
                <li class="divider"></li>
<!--                <li class="nav-header">Nav header</li-->
                <li>
                    <?php if ($isAuthentified):?>
                        <a href="/logout"><?=i18n('logout.request.label')?></a>
                    <?php else:?>
                        <a href="/login"><?=i18n('login.request.label')?></a>
                    <?php endif;?>
                </li>
            </ul>
        </li>
    </ul>
</div>

    </div>
</div>
