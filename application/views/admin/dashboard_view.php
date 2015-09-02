<div class="container top">

    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url("admin"); ?>">
                <?php echo ucfirst($this->uri->segment(1)); ?>
            </a>
            <span class="divider">/</span>
        </li>
        <li>
            <?php echo ucfirst($this->uri->segment(2)); ?>
    </ul>

    <div class="page-header">
        <h2>
            <?php echo ucfirst($this->uri->segment(2)); ?>
        </h2>
        <h3 style="margin-top:5px;">Welcome <a href="<?php echo base_url(); ?>admin/user/update/<?php echo $this->session->userdata['user_id'] ?>"><?php echo $this->session->userdata['username']; ?></a> to Theater Admin.</h3>
    </div>
    <div class="quickLink">
        <a href="<?php echo base_url(); ?>admin/category" title="Category">
            <img alt="Add Category" src="<?php echo base_url(); ?>/assets/img/admin/ico/categoryico.png" />
            <span>Category</span>
        </a>
    </div>
    <div class="quickLink">
        <a href="<?php echo base_url(); ?>admin/products" title="products">
            <img alt="Add products" src="<?php echo base_url(); ?>/assets/img/admin/ico/categoryico.png" />
            <span>Products</span>
        </a>
    </div>
    <div class="quickLink">
        <a href="<?php echo base_url(); ?>admin/user" title="User">
            <img alt="Add User" src="<?php echo base_url(); ?>/assets/img/admin/ico/user.png" />
            <span>Users</span>
        </a>
    </div>
    <div class="quickLink">
        <a href="<?php echo base_url(); ?>admin/company" title="Company">
            <img alt="Add Company" src="<?php echo base_url(); ?>/assets/img/admin/ico/company.png" />
            <span>Company</span>
        </a>
    </div>
    <div class="quickLink">
        <a href="<?php echo base_url(); ?>admin/material" title="material">
            <img alt="Add material" src="<?php echo base_url(); ?>/assets/img/admin/ico/categoryico.png" />
            <span>Raw Material</span>
        </a>
    </div>

    <div class="quickLink">
        <a href="<?php echo base_url(); ?>admin/purchase_material" title="Purchase Material">
            <img alt="Purchase Material" src="<?php echo base_url(); ?>/assets/img/admin/ico/categoryico.png" />
            <span>Purchase Material</span>
        </a>
    </div>
    <div class="quickLink">
        <a href="<?php echo base_url(); ?>admin/uom" title="Unit of Measurement">
            <img alt="Unit of Measurement" src="<?php echo base_url(); ?>/assets/img/admin/ico/categoryico.png" />
            <span>Unit of Measurement</span>
        </a>
    </div>
    <div class="quickLink">
        <a href="<?php echo base_url(); ?>admin/operator_list" title="operator_list">
            <img alt="Add operator list" src="<?php echo base_url(); ?>/assets/img/admin/ico/categoryico.png" />
            <span>Operator List</span>
        </a>
    </div>

    <div class="quickLink">
        <a href="<?php echo base_url(); ?>admin/report" title="report">
            <img alt="report" src="<?php echo base_url(); ?>/assets/img/admin/ico/categoryico.png" />
            <span>Report</span>
        </a>
    </div>
    <div class="quickLink">
        <a href="<?php echo base_url(); ?>admin/report_list" title="report">
            <img alt="report" src="<?php echo base_url(); ?>/assets/img/admin/ico/categoryico.png" />
            <span>Report List</span>
        </a>
    </div>

</div>


<?php //echo '<pre>';print_r($this->session->userdata);?>

