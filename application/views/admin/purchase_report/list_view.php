<div class="container top">
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url("admin/dashboard"); ?>">
                <?php echo ucfirst($this->uri->segment(1)); ?>
            </a>
            <span class="divider">/</span>
        </li>
        <li class="active">
            <?php echo "Purchase Report"; ?>
        </li>
    </ul>

    <div class="page-header users-header" style="padding-bottom: 38px;">
        <h2>
            <?php echo "Purchase Report"; ?>
            <a  href="javascript:void(0)" class="sub_total">Sub Total : <?php echo $sub_total; ?></a><br>
            <a  href="javascript:void(0)" class="sub_total">Quantity : <?php echo $quantity; ?></a>
            <?php /* ?> <a style="margin-right:30px;" href="<?php echo site_url("admin").'/'.$this->uri->segment(2); ?>/exportcsv" class="btn btn-info">Export User</a> <?php */ ?>
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
                    foreach ($search_product as $row) {
                        $date = date('m/d/Y', $row['datetime']);
                        echo '<tr>';
                        echo '<td>' . $row ['item_row_material_purchase_details_id'] . '</td>';
                        echo '<td>' . $row ['name'] . '</td>';
                        echo '<td>' . $row ['qty'] . '</td>';
                        echo '<td>' . $row['cost'] . '</td>';
                        echo '<td>' . $date . '</td>';
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