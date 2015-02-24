<div class="op-bsw-grey-panel-content op-bsw-grey-panel-no-sidebar cf">

    <p class="op-micro-copy"><?php _e('If you are experiencing issues with your LiveEditor pages, sometimes Style Sheets (CSS) or Javascript (JS) files from your theme can cause problems.  Tick any relevant boxes below to disable any Javascript or CSS from installed plugins from rendering on LiveEditor pages.', OP_SN); ?></p>
    <table width="100%">
        <tr>
            <th align="left"><?php _e('Theme name', OP_SN); ?></th>
            <th width="10%"><?php _e('CSS', OP_SN); ?></th>
            <th width="10%"><?php _e('JS', OP_SN); ?></th>
        </tr>
        <tr>
            <td><?php echo $theme->name; ?></td>
            <td align="center">
                <?php op_checkbox_field('op[sections][external_theme_css]', 1, checked(1, op_get_option('op_external_theme_css'), false)); ?>
            </td>
            <td align="center">
                <?php op_checkbox_field('op[sections][external_theme_js]', 1, checked(1, op_get_option('op_external_theme_js'), false)); ?>
            </td>
        </tr>
    </table>
</div>