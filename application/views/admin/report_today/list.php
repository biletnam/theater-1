<div class="container top">

    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url("admin/dashboard"); ?>">
                <?php echo ucfirst($this->uri->segment(1)); ?>
            </a>
            <span class="divider">/</span>
        </li>
        <li class="active">
            Today Sale<?php //echo ucfirst($this->uri->segment(2));              ?>
        </li>
    </ul>

    <div class="page-header users-header">
        <h2>
            Today Sale<?php //echo ucfirst($this->uri->segment(2));               ?>

        </h2>
    </div>

    <div class="row">
        <div class="span12 columns">

            <table class="table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th class="header">#</th>
                        <th class="yellow header headerSortDown">Product Title</th>
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
                        echo '<td>' . $row ['order_detail_id'] . '</td>';
                        echo '<td>' . $row ['product_title'] . '</td>';
                        echo '<td>' . $row ['quantity'] . '</td>';
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
    </div>