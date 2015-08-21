<div class="container top">
    <script>
        $(function() {
            $("#joining_date").datepicker({dateFormat: "yy-mm-dd"});
            $("#end_date").datepicker({dateFormat: "yy-mm-dd"});
        });
    </script>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url("admin/dashboard"); ?>">
                <?php echo ucfirst($this->uri->segment(1)); ?>
            </a>
            <span class="divider">/</span>
        </li>
        <li class="active">
            Report List<?php //echo ucfirst($this->uri->segment(2));                        ?>
        </li>
    </ul>
    <fieldset>
        <div class="page-header users-header">
            <h2>
                Report List<?php //echo ucfirst($this->uri->segment(2));                       ?>
            </h2>
        </div>

        <div class="quickLink">
            <a href="<?php echo base_url(); ?>admin/report" title="report">
                <img alt="report" src="<?php echo base_url(); ?>/assets/img/admin/ico/categoryico.png" />
                <span>Sales Report</span>
            </a>
        </div>
        <div class="quickLink">
            <a href="<?php echo base_url(); ?>admin/report_today" title="report">
                <img alt="report" src="<?php echo base_url(); ?>/assets/img/admin/ico/categoryico.png" />
                <span>Sales Today Report</span>
            </a>
        </div>
        <div class="quickLink">
            <a href="<?php echo base_url(); ?>admin/purchase_report" title="Purchase Report">
                <img alt="Purchase Report" src="<?php echo base_url(); ?>/assets/img/admin/ico/categoryico.png" />
                <span>Purchase Report</span>
            </a>
        </div>
        <div class="quickLink">
            <a href="<?php echo base_url(); ?>admin/purchase_report_today" title="Purchase Report Today">
                <img alt="Purchase Report Today" src="<?php echo base_url(); ?>/assets/img/admin/ico/categoryico.png" />
                <span>Purchase Today Report</span>
            </a>
        </div>
    </fieldset>