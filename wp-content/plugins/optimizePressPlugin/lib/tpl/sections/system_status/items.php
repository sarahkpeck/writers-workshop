<div class="op-bsw-grey-panel-content op-bsw-grey-panel-no-sidebar cf"<?php if ($open === true) echo ' style="display: block !important;"'; ?>>

<?php if (count($items) > 0) : ?>
    <table width="100%">
        <?php foreach ($items as $key => $data) : ?>
        <tr class="status-row status-row-<?php echo $key; ?>">
            <td class="status-label" valign="top" width="33%"><?php echo $data['label']; ?>:</td>
            <td class="status-check system-status-<?php echo $data['status']; ?> status-<?php echo $key; ?>" valign="top"><?php echo $data['message']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <textarea class="op-system-status-section op-status-section-<?php echo esc_attr($section); ?>" style="display: none;">

## <?php echo $label; ?> ##

<?php
        foreach ($items as $data) {
            if (isset($data['raw_message'])) {
                echo $data['label'] . ": " . $data['raw_message'] . "\n";
            } else {
                echo $data['label'] . ": " . $data['message'] . "\n";
            }
        }
?>
    </textarea>
<?php else : ?>
    <p><?php _e('No data', OP_SN); ?>
<?php endif; ?>
    <div class="clear"></div>
</div>