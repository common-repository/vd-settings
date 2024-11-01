jQuery(document).ready(function () {
    jQuery('input.upload_media').click(function () {
        var button_id = jQuery(this).attr('id');
        var eti_field = 'upload_' + button_id;
        tb_show('', 'media-upload.php?type=image&TB_iframe=true&ETI_field='+eti_field);

        window.send_to_editor = function (html) {
            var imgurl = jQuery(html).attr('src');
            jQuery('#thumb_'+button_id).show().attr('src', imgurl);
            jQuery('#'+eti_field).val(imgurl);
            tb_remove();
        }
        return false;
    });
});

function deleteMedia(field, img){
    jQuery('#'+field).val('');
    jQuery('#'+img).remove();
}