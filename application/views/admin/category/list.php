<div class="container top">

    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url("admin/dashboard"); ?>">
                <?php echo ucfirst($this->uri->segment(1)); ?>
            </a> 
            <span class="divider">/</span>
        </li>
        <li class="active">
            <?php echo ucfirst($this->uri->segment(2)); ?>
        </li>
    </ul>

    <div class="page-header users-header">
        <h2>
            <?php echo ucfirst($this->uri->segment(2)); ?> 
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
            echo '<strong>Well done!</strong> new category created with success.';
            echo '</div>';

            $this->session->set_userdata('flash_message', '');
            //echo $this->session->flashdata('flash_message');
        } else if ($this->session->flashdata('flash_message') == 'update') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> category updated with success.';
            echo '</div>';
            $this->session->set_userdata('flash_message', '');
        } else if ($this->session->flashdata('flash_message') == 'delete') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> category deleted with success.';
            echo '</div>';
            $this->session->set_userdata('flash_message', '');
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
            <div class="well">

                <?php
                $attributes = array('class' => 'form-inline reset-margin', 'id' => 'myform');

//save the columns names in a array that we will use as filter         
                $options_category = array();
                foreach ($category as $array) {
                    foreach ($array as $key => $value) {
                        $options_category[$key] = $key;
                    }
                    break;
                }

                echo form_open('admin/category', $attributes);

                echo form_label('Search:', 'search_string');
                ?>
                <select name="order" class="span2">
                    <option <?php echo ($order == 'category_name') ? 'selected="selected"' : "" ?> value="category_name">Category Name</option>
                    <option <?php echo ($order == 'status') ? 'selected="selected"' : "" ?> value="status">Status</option>
                </select>
                <?php
                echo form_input('search_string', $search_string_selected);

                echo form_label('Order by:', 'order');
//echo form_dropdown('order', $options_category, $order, 'class="span2"');

                $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go');

                $options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
                echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="span1"');

                echo form_submit($data_submit);
                if ($search_string_selected) {
                    echo '<a style="margin-left: 12px;vertical-align: middle;" class="btn" href="' . site_url("admin/category/") . '">Reset</a>';
                }
                echo form_close();
                ?>

            </div>

            <table class="table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
<!--                        <th class="header">#</th>-->
                        <th class="yellow header headerSortDown">Category Name</th>
                        <th class="yellow header headerSortDown">Path</th>
                        <th class="yellow header headerSortDown">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($category as $key => $row) {
                        echo '<tr>';
//                        echo '<td>' . $key . '</td>';
                        echo '<td>' . $row['category_name'] . '</td>';
                        echo '<td>' . $row['path'] . '</td>';
                        echo '<td>' . $row['status'] . '</td>';
                        echo '<td class="crud-actions">
                  <a  href="' . site_url("admin") . '/category/update/' . $row['category_id'] . '" class="btn btn-info">view & edit</a>  
                  <a href="' . site_url("admin") . '/category/delete/' . $row['category_id'] . '" class="btn btn-danger complexConfirm">delete</a>
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