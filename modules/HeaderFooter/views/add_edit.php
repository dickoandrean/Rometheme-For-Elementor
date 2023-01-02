<div class="w-100 p-3">
    <div class="mb-4" align="center">
        <h2>Create Header & Footer Template</h2>
        <div class="mb-4" style="max-width: 35rem ;">
            <span class="text-wrap">Add header & footer template to use them across your website.</span>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalAddNew"><?php esc_html_e('Add New', 'romethemekit-plugin') ?></button>
    </div>
    <div class="w-100">
        <table class="table shadow table-sm">
            <thead class="bg-white">
                <tr>
                    <td class="text-center" scope="col">No</td>
                    <td scope="col">Title</td>
                    <td scope="col">Author</td>
                    <td scope="col">Type</td>
                    <td scope="col">Date</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $index = 0;
                $post_type = new WP_Query(['post_type' => 'rometheme_template']);
                if ($post_type->have_posts()) {
                    while ($post_type->have_posts()) {
                        $index = $index + 1;
                        $post_type->the_post();
                        $id_post =  intval(get_the_ID());
                        $type = get_post_meta($id_post, 'rometheme_template_type', true);
                        $active = get_post_meta($id_post, 'rometheme_template_active', true);
                        $delete = get_delete_post_link($id_post, '', false);
                        $edit_link = get_edit_post_link($id_post, 'display');
                        $edit_elementor = str_replace('action=edit', 'action=elementor', $edit_link);
                        $status = (get_post_status($id_post) == 'publish') ? 'Published' : 'Draft';
                        echo '<tr>';
                        echo '<td class="text-center">' . esc_html__($index) . '</td>';
                        echo '<td><div>' . esc_html(get_the_title());
                        echo ($active == 'true') ? '<span class="badge rounded-pill text-bg-success mx-3">Active</span>' : '<span class="badge rounded-pill mx-3 text-bg-secondary">Inactive</span>';
                        echo '</div>';
                        echo '<smal style="font-size: 13px;"><a class="link" href="' . esc_url($edit_link) . '">Edit</a>&nbsp;|&nbsp; <a class="link" href="' . esc_url($edit_elementor) . '">Edit with Elementor</a> &nbsp;|&nbsp;<a class="link" href="' . esc_url($delete) . '">Trash</a></small>';
                        echo '</td>';
                        echo '<td>' . get_the_author() . '</td>';
                        echo '<td>' . esc_html__(ucwords($type), 'romethemekit-plugin') . '</td>';
                        echo '<td><small>' . esc_html($status) . '</small><br><small>' . esc_html(get_the_date('Y/m/h') . ' at ' . get_the_date('H:i a')) . '</small></td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td class="text-center" colspan="4">' . esc_html('No Data') . '</td></tr>';
                }
                ?>
            </tbody>
            <tfoot>
                <tr class="bg-white">
                    <td scope="col"></td>
                    <td scope="col">Title</td>
                    <td scope="col">Author</td>
                    <td scope="col">Type</td>
                    <td scope="col">Date</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ModalAddNew" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="add-new-post" method="POST">
                <input id="action" name="action" type="text" value="addNewPost" hidden>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php esc_html_e('Add New Header or Footer', 'romethemekit-plugin') ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column gap-3">
                    <div class="mb-3 row">
                        <label for="inputTitle" class="col-sm-2 col-form-label">Title</label>
                        <div class="col-sm-10">
                            <input name="title" type="text" class="form-control" id="inputTitle">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="inputType" class="col-sm-2 col-form-label">Type</label>
                        <div class="col-sm-10">
                            <select name="type" class="form-select" id="inputType">
                                <option value="header"><?php esc_html_e('Header', 'romethemekit-plugin') ?></option>
                                <option value="footer"><?php esc_html_e('Footer', 'romethemekit-plugin') ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex flex-row justify-content-end gap-3">
                        <span>Active</span>
                        <label class="switch">
                            <input name="active" id="switch" type="checkbox" value="true" checked>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button onclick="add_new_post()" class="btn btn-primary">Save
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

    body {
        background-color: #f0f0f1;
    }
</style>