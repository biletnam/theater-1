<div class="container top">

    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url("admin/dashboard"); ?>">
                <?php echo ucfirst($this->uri->segment(1)); ?>
            </a>
            <span class="divider">/</span>
        </li>
        <li class="active">
            Purchase Today Report<?php //echo ucfirst($this->uri->segment(2));                   ?>
        </li>
    </ul>

    <div class="page-header users-header">
        <h2>
            Purchase Today Report<?php //echo ucfirst($this->uri->segment(2));                    ?>
            <?php
            $attributes = array('class' => 'form-horizontal', 'id' => '');
            echo validation_errors();
            echo form_open_multipart('admin/purchase_report_today/exportcsv', $attributes);
            ?>
            <input type="hidden" name="do_export" value="do_export">
            <button style="float: right;" class="btn btn-primary" type="submit">Export CSV</button>
            <?php echo form_close(); ?>
        </h2>
    </div>

    <div class="row">
        <div class="span12 columns">

            <table class="table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th class="header">#</th>
                        <th class="yellow header headerSortDown">Name</th>
                        <th class="yellow header headerSortDown">Quantity</th>
                        <th class="yellow header headerSortDown">Cost</th>
                        <th class="yellow header headerSortDown">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($today_sale as $key => $row) {
                        $date = date('m/d/Y', $row['datetime']);
                        echo '<tr>';
                        echo '<td>' . $row ['item_row_material_purchase_details_id'] . '</td>';
                        echo '<td>' . $row ['name'] . '</td>';
                        echo '<td>' . $row ['qty'] . '</td>';
                        echo '<td>' . $row['cost'] . '</td>';
                        echo '<td>' . $date . '</td>';
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
        <a class="btn" href="<?php echo site_url('admin') ?>/report_list">Back</a>
    </div>