<div class="op-bsw-grey-panel-content op-bsw-grey-panel-no-sidebar cf">

    <p class="op-micro-copy"><?php _e('If you are experiencing issues with your LiveEditor pages, sometimes Style Sheets (CSS) or Javascript (JS) files from installed plugins can cause problems.  Tick any relevant boxes below to disable any Javascript or CSS from installed plugins from rendering on LiveEditor pages. ', OP_SN); ?></p>
    <p class="op-micro-copy"><?php _e('<strong>Please note:</strong> If you are using plugins to render elements or functionality to your LiveEditor pages it is not recommended that you disable CSS or JS as this may stop the plugin from functioning on those pages.  We also do not recommend disabling any OptimizePress or OptimizeMember plugins as these have been tested for compatibility.', OP_SN); ?></p>
    <?php if (count($plugins) > 0) : ?>
    <table width="100%">
        <tr>
            <th align="left"><?php _e('Plugin name', OP_SN); ?></th>
            <th width="10%"><?php _e('CSS', OP_SN); ?></th>
            <th width="10%"><?php _e('JS', OP_SN); ?></th>
        </tr>
        <?php $hasActive = false; ?>
        <?php foreach ($plugins as $pluginId => $plugin) : if (!is_plugin_active($pluginId)) { continue; } ?>
        <?php $hasActive = true; ?>
        <tr>
            <?php $pluginId = substr($pluginId, 0, strpos($pluginId, '/')); ?>
            <td><?php echo $plugin['Name']; ?></td>
            <td align="center">
                <input type="checkbox" name="op[sections][external_plugins][css][]" value="<?php echo esc_attr($pluginId); ?>" <?php checked(true, is_array(op_get_option('op_external_plugins_css')) && in_array($pluginId, op_get_option('op_external_plugins_css'))); ?> />
            </td>
            <td align="center">
                <input type="checkbox" name="op[sections][external_plugins][js][]" value="<?php echo esc_attr($pluginId); ?>" <?php checked(true, is_array(op_get_option('op_external_plugins_js')) && in_array($pluginId, op_get_option('op_external_plugins_js'))); ?> />
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php endif; ?>

    <?php if (false === $hasActive) : ?>
    <p><em><?php _e('No active plugins', OP_SN); ?></em></p>
    <?php endif; ?>
</div>