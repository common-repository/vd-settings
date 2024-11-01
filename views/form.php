<div class="settings">
    <div class="main_title">Viaduct Essential Options</div>
    <form class="settings" method="post" enctype="multipart/form-data">
        <?php
        wp_nonce_field('vd_settings_form_submit', 'vd_form_generate_nonce');
        foreach ($config as $config_key => $config_value):
            if ($config_value['type'] == 'checkbox') :
                ?>
                <p>
                    <input id="vd_eo_<?php echo $config_key; ?>" type="checkbox" name="vd_eo[<?php echo $config_key; ?>]" value="true" <?php echo!empty($options[$config_key]) ? 'checked' : ''; ?>/>
                    <label for="vd_eo_<?php echo $config_key; ?>">
                        <?php echo $config_value['label']; ?></label>
                    <span title="<?php echo $config_value['annotation']; ?>" class="tooltip"><em>?</em></span>
                </p>
            <?php elseif ($config_value['type'] == 'text') : ?>
                <p>
                    <input id="vd_eo_<?php echo $config_key; ?>" type="text" name="vd_eo[<?php echo $config_key; ?>]" value="<?php echo!empty($options[$config_key]) ? $options[$config_key] : ''; ?>" />
                    <label for="vd_eo_<?php echo $config_key; ?>">
                        <?php echo $config_value['label']; ?>
                    </label>
                    <span title="<?php echo $config_value['annotation']; ?>" class="tooltip"><em>?</em></span>	
                </p>
            <?php elseif ($config_value['type'] == 'select') : ?>
                <p>	
                    <select id="vd_eo_<?php echo $config_key; ?>" type="select" name="vd_eo[<?php echo $config_key; ?>]">
                        <?php
                        foreach ($config_value['value'] as $select_key => $select_value)
                            echo '<option value="' . $select_key . '" ' . selected($options[$select_key], $select_value, false) . '>' . $select_value . '</option>';
                        ?>
                    </select>
                    <label for="vd_eo_<?php echo $config_key; ?>">
                        <?php echo $config_value['label']; ?>
                    </label>
                    <span title="<?php echo $config_value['annotation']; ?>" class="tooltip"><em>?</em></span>	
                </p> 
            <?php elseif ($config_value['type'] == 'radio') : ?>
                <p>	
                <fieldset class="vd_fieldset_group">
                    <legend><?php echo $config_value['annotation']; ?></legend>
                    <?php
                    foreach ($config_value['value'] as $radio_key => $radio_value) {
                        $echo = '<p><label>';
                        $echo .= '<input id="vd_eo_' . $radio_key . '" '
                                . 'type="radio" name="vd_eo[' . $config_key . ']" value="'
                                . $radio_value . '" ';

                        if (isset($options[$config_key]) && !empty($options[$config_key]))
                            $echo .= checked($options[$config_key], $radio_value, false);

                        $echo .= '>' . $radio_value . ' ' . $config_value['description'];
                        $echo .= '</label></p>';

                        echo $echo;
                    }
                    ?>
                </fieldset>
                </p>
            <?php elseif ($config_value['type'] == 'file') : ?>
                <p>
                <fieldset class="vd_fieldset_group">
                    <legend><?php echo $config_value['annotation']; ?></legend>
                    <?php
                    $image_present = (isset($options[$config_key]) && ((int) $options[$config_key] > 0)) ? true : false;
                    if ($image_present) {
                        $image_url = wp_get_attachment_image($options[$config_key]);
                        echo $image_url;
                    }
                    ?>
                    </p>
                    <p>
                        <input type="hidden" name="vd_eo[<?php echo $config_key; ?>]" value="<?php echo $options[$config_key]; ?>" />
                        <input id="vd_eo_<?php echo $config_key; ?>" type="file" name="<?php echo $config_key; ?>" />
                </fieldset>
                </p>
            <?php elseif ($config_value['type'] == 'media') : ?> 
                <p>
                <fieldset class="vd_fieldset_group">
                    <legend><?php echo $config_value['annotation']; ?></legend>
                    <input id="upload_vd_eo_<?php echo $config_key; ?>" type="hidden" name="vd_eo[<?php echo $config_key; ?>]" value="<?php echo isset($options[$config_key]) ? $options[$config_key] : ''; ?>"/>  
                    <input id="vd_eo_<?php echo $config_key; ?>" type="button" class="button upload_media" value="Choose" />
                    <input type="button" class="button delete_media" value="Delete" onclick="deleteMedia('upload_vd_eo_<?php echo $config_key; ?>','thumb_vd_eo_<?php echo $config_key; ?>');return false"/>                    
                        <p>
                            <img src="<?php echo (isset($options[$config_key]))?$options[$config_key]:''; ?>" id="thumb_vd_eo_<?php echo $config_key; ?>" style="<?php if(empty($options[$config_key])) echo "display:none"?>">
                        </p>                    
                </fieldset>
                </p>
                <?php
            endif;
        endforeach;
        ?>
        <p><input type="submit" value="<?php _e('Save', 'vd_io_text_domain'); ?>" name="vd_eo_save"></p>
        <?php
        $message = isset($_POST['vd_eo_save']) ? "Your settings are successfully saved!" : "";
        echo '<div class="saved_message">' . $message . '</div>';
        ?>
    </form>
</div>
