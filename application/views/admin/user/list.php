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
            <?php /* ?> <a style="margin-right:30px;" href="<?php echo site_url("admin").'/'.$this->uri->segment(2); ?>/exportcsv" class="btn btn-info">Export User</a> <?php */ ?>
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
            echo '<strong>Well done!</strong> new user created with success.';
            echo '</div>';
        } else if ($this->session->flashdata('flash_message') == 'update') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> user updated with success.';
            echo '</div>';
        } else if ($this->session->flashdata('flash_message') == 'delete') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> user deleted with success.';
            echo '</div>';
        } else {
            echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Oh snap!</strong> change a few things up and try submitting again.';
            echo '</div>';
        }
    }
    //echo "permission->".user_access($this->session->userdata('user_id'),'delete_users');
    ?>
    <div class="row">
        <div class="span12 columns">
            <div class="well">

                <?php
                $attributes = array('class' => 'form-inline reset-margin', 'id' => 'myform');

//save the columns names in a array that we will use as filter
                $options_keyword = array();
                foreach ($user as $array) {
                    foreach ($array as $key => $value) {
                        $options_keyword[$key] = $key;
                    }
                    break;
                }

                echo form_open('admin/user', $attributes);

                echo form_label('Search:', 'search_string');
                echo form_input('search_string', $search_string_selected);
                ?>
                <select name="order" class="span2">
                    <option <?php echo ($order == 'firstname') ? 'selected="selected"' : "" ?> value="firstname">Firstname</option>
                    <option <?php echo ($order == 'lastname') ? 'selected="selected"' : "" ?> value="lastname">Lastname</option>
                    <option <?php echo ($order == 'username') ? 'selected="selected"' : "" ?> value="username">Username</option>
                    <option <?php echo ($order == 'primary_email') ? 'selected="selected"' : "" ?> value="primary_email">Primary E-mail</option>
                    <option <?php echo ($order == 'status') ? 'selected="selected"' : "" ?> value="status">Status</option>
                </select>
                <?php
                echo form_label('Order by:', 'order');
// echo form_dropdown('order', $options_keyword, $order, 'class="span2"');

                $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go');

                $options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
                echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="span1"');

                echo form_submit($data_submit);
                if ($search_string_selected) {
                    echo '<a style="margin-left: 12px;vertical-align: middle;" class="btn" href="' . site_url("admin/user/") . '">Reset</a>';
                }
                echo form_close();
                ?>

            </div>

            <table class="table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th class="header">#</th>
                        <th class="yellow header headerSortDown">Firstname</th>

                        <th class="yellow header headerSortDown">Lastname</th>
                        <th class="yellow header headerSortDown">Username</th>
                        <th class="yellow header headerSortDown">Primary E-mail</th>

                        <th class="yellow header headerSortDown">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($user as $row) {
                        echo '<tr>';
                        echo '<td>' . $row ['user_id'] . '</td>';
                        echo '<td>' . $row ['firstname'] . '</td>';

                        echo '<td>' . $row ['lastname'] . '</td>';
                        echo '<td>' . $row['username'] . '</td>';
                        echo '<td>' . $row['primary_email'] . '</td>';

                        echo '<td>' . $row['status'] . '</td>';
                        echo '<td style="text-align:center;" class="crud-actions">';

                        echo '<a  href="' . site_url("admin") . '/user/update/' . $row['user_id'] . '" class="btn btn-info">view & edit</a>

                </td>';
                        echo '</tr>';
                    }
                    /* <a href="'.site_url("admin").'/user/delete/'.$row['user_id'].'" class="btn btn-danger complexConfirm">delete</a> */
                    ?>
                </tbody>
            </table>

            <?php
            $this->session->set_userdata('redirect_url', current_url());
            echo '<div class="pagination">' . $this->pagination->create_links() . '</div>';
            ?>

        </div>
    </div>