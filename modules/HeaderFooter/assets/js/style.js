function update_post() {
    jQuery(($) => {
        data = $("#edit_form").serialize();
        $.ajax({
            type: 'post',
            url: rometheme_ajax_url.ajax_url,
            data: data,
            success: (data) => {
                alert('Update Data Succesfully');
                location.href = rometheme_url.header_footer_url;
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("The following error occured: " + textStatus, errorThrown);
            },
        });
    });
}

function add_new_post() {
    jQuery(($) => {
        data = $('#add-new-post').serialize();
        $.ajax({
            type: 'post',
            url: rometheme_ajax_url.ajax_url,
            data: data,
            success: (data) => {
                location.href = rometheme_url.header_footer_url;
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("The following error occured: " + textStatus, errorThrown);
            },
        });
    });
}

function to_header_footer_url() {
    location.href = rometheme_url.header_footer_url;
}