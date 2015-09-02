<div class="container top">

    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url("admin/dashboard"); ?>">
                <?php echo ucfirst($this->uri->segment(1)); ?>
            </a>
            <span class="divider">/</span>
        </li>
        <li class="active">
            <?php echo strtoupper($this->uri->segment(2)); ?>
        </li>
    </ul>

    <div class="page-header users-header">
        <h2>
            <?php echo strtoupper($this->uri->segment(2)); ?>
            <a  href="<?php echo site_url("admin") . '/' . $this->uri->segment(2); ?>/add" class="btn btn-success">Add a new</a>
        </h2>
    </div>
    <?php
    //\\print_r($this->session->userdata('flash_message'));
    //print_r($this->session->flashdata('data'));
    //flash messages

    echo validation_errors();
    //echo $this->session->flashdata('flash_message');
    if ($this->session->flashdata('flash_message')) {
        if ($this->session->flashdata('flash_message') == 'add') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> new UOM created with success.';
            echo '</div>';
        } else if ($this->session->flashdata('flash_message') == 'update') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> UOM updated with success.';
            echo '</div>';
        } else if ($this->session->flashdata('flash_message') == 'delete') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> UOM deleted with success.';
            echo '</div>';
        } else {
            echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Oh snap!</strong> change a few things up and try submitting again.';
            echo '</div>';
        }
    }
    ?>
    <div class="row">
        <div class="span12 columns">
            <div class="well">    <?php
                $attributes = array('class' => 'form-inline reset-margin', 'id' => 'myform');
                $options_keyword = array();
                echo form_open('admin/uom', $attributes);
                echo form_label('Search:', 'search_string');
                echo form_input('search_string', $search_string_selected);
                ?>
                <select name="order" class="span2">
                    <option <?php echo ($order == 'uom') ? 'selected="selected"' : "" ?> value="uom">UOM</option>
                    <option <?php echo ($order == 'status') ? 'selected="selected"' : "" ?> value="status">Status</option>
                </select>
                <?php
                echo form_label('Order by:', 'order');
                $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go');
                $options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
                echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="span1"');
                echo form_submit($data_submit);
                if ($search_string_selected) {
                    echo '<a style="margin-left: 12px;vertical-align: middle;" class="btn" href="' . site_url("admin/uom/") . '">Reset</a>';
                }
                echo form_close();
                ?>
            </div>

            <table class="table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th class="header">#</th>
                        <th class="yellow header headerSortDown">UOM</th>
                        <th class="yellow header headerSortDown">Status</th>
                        <th class="yellow header headerSortDown">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($uom as $row) {
                        $status = ($row['status'] == 'Active') ? 'Inactive' : 'Active';
                        echo '<tr>';
                        echo '<td>' . $row['uom_id'] . '</td>';
                        echo '<td>' . $row['uom'] . '</td>';
                        echo '<td>' . $row['status'] . '</td>';
                        echo '<td style="width:215px;" class="crud-actions">
                  <a  href="' . site_url("admin") . '/uom/update/' . $row['uom_id'] . '" class="btn btn-info">view & edit</a>
                  <a href="' . site_url("admin") . '/uom/delete/' . $row['uom_id'] . '" class="btn btn-danger complexConfirm">delete</a>
                </td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
            <?php
            $this->session->set_userdata('redirect_url', current_url());
            echo '<div class="pagination">' . $this->pagination->create_links() . '</div>';
            ?>

        </div>
    </div>