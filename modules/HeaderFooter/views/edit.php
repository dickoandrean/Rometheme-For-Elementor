<?php

$post = sanitize_text_field($_GET['post']);
$post_data = get_post($post);
$key = get_post_meta($post, 'rometheme_template_type', true);
$active = get_post_meta($post, 'rometheme_template_active', true);

?>

<div class="modal fade" id="ModalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="edit_form" method="POST" action="#">
                <span id='errfrmMsg' style='margin:0 auto;'></span>
                <input name="id" id="id" type="text" value="<?php echo esc_attr($post); ?>" hidden>
                <input id="action" type="text" name="action" value="updatepost" hidden>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Header or Footer</h5>
                    <button type="button" onclick="to_header_footer_url()" class="btn-close" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column gap-3">
                    <div class="mb-3 row">
                        <label for="inputTitle" class="col-sm-2 col-form-label">Title</label>
                        <div class="col-sm-10">
                            <input value="<?php echo esc_attr($post_data->post_title) ?>" name="title" type="text" class="form-control" id="inputTitle">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="inputType" class="col-sm-2 col-form-label">Type</label>
                        <div class="col-sm-10">
                            <select name="type" class="form-select" id="inputType">
                                <option value="header" <?php echo esc_html(($key == 'header') ? 'selected' : ''); ?>>Header</option>
                                <option value="footer" <?php echo esc_html(($key == 'footer') ? 'selected' : ''); ?>>Footer</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex flex-row justify-content-end gap-3">
                        <span>Active</span>
                        <label class="switch">
                            <input name="active" id="switch" type="checkbox" value="true" <?php echo esc_html(($active == 'true') ? 'checked' : ''); ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="modal-footer">
                        <button onclick="to_header_footer_url()" type="button" class="btn btn-secondary">Close</button>
                        <button id="submit" onclick="update_post()" name="submit" value="submit" type="button" class="btn btn-primary">Save
                            changes</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>

<script>
    var myModal = new bootstrap.Modal(document.getElementById('ModalEdit'), {
        keyboard: false,
        backdrop: 'static'
    });
    myModal.show();
</script>