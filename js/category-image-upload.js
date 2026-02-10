jQuery(document).ready(function($) {
    var mediaUploader;

    $('.upload-category-image').click(function(e) {
        e.preventDefault();
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#category_image').val(attachment.url);
            $('#category-image-preview').html('<img src="' + attachment.url + '" style="max-width: 100%; height: auto;" />');
        });
        mediaUploader.open();
    });

    $('.remove-category-image').click(function(e) {
        e.preventDefault();
        $('#category_image').val('');
        $('#category-image-preview').html('');
    });
});
