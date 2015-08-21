<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Theater Admin - <?php echo ucfirst($this->uri->segment(2)); ?></title>
        <meta charset="utf-8">
        <link href="<?php echo base_url(); ?>assets/css/admin/global.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/css/admin/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/css/admin/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/admin/style.css">
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">

        <script type="text/javascript"> var base_url = '<?php echo base_url(); ?>'</script>
<!--        <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>-->
        <script src="<?php echo base_url(); ?>assets/js/jquery-1.7.1.min.js"></script>
        <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/hogan.js"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.js"></script>
        <script src="<?php echo base_url() ?>assets/js/bootstrap.js"></script>
<!--        <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>-->
        <script src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.session.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/typeahead.js"></script>

    </head>
    <?php
    $CI = & get_instance();
//$CI->load->model('Imap_model');
//$m_count = $CI->Imap_model->get_mail_count();
    ?>
    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">

      <a class="brand"><!--<img src="<?php echo base_url(); ?>assets/images/admin/logo.png" />-->theater Admin</a>
                    <div class="brand logininfo">logged in as <a href="<?php echo base_url(); ?>admin/user/update/<?php echo $this->session->userdata['user_id'] ?>"><?php echo $this->session->userdata['username']; ?></a>&nbsp; <a href="<?php echo base_url(); ?>admin/logout">Logout</a></div>
                    <ul class="nav">
                        <li <?php
                        if ($this->uri->segment(2) == 'dashboard') {
                            echo 'class="active"';
                        }
                        ?>>
                            <a href="<?php echo base_url(); ?>admin/dashboard">Dashboard</a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">theater<b <?php //echo ($m_count > 0) ? 'style="margin-top:11px"' : ''                                                       ?> class="caret"></b></a>
                            <?php // if($m_count > 0){ ?>
                            <div class="tip_div"><span class="tip"><span class="tip_in"><?php //echo $m_count;                                                       ?></span></span></div>
                            <?php // }   ?>
                            <ul class="dropdown-menu">
                                <li <?php
                                if ($this->uri->segment(2) == 'category') {
                                    echo 'class="active"';
                                }
                                ?>>
                                    <a href="<?php echo base_url(); ?>admin/category">Category</a>
                                </li>
                                <li <?php
                                if ($this->uri->segment(2) == 'products') {
                                    echo 'class="active"';
                                }
                                ?>>
                                    <a href="<?php echo base_url(); ?>admin/products">Products</a>
                                </li>
                                <li <?php
                                if ($this->uri->segment(2) == 'company') {
                                    echo 'class="active"';
                                }
                                ?>>
                                    <a href="<?php echo base_url(); ?>admin/company">Company</a>
                                </li>
                                <li <?php
                                if ($this->uri->segment(2) == 'material') {
                                    echo 'class="active"';
                                }
                                ?>>
                                    <a href="<?php echo base_url(); ?>admin/material">Row Material</a>
                                </li>
                                <li <?php
                                if ($this->uri->segment(2) == 'operator_list') {
                                    echo 'class="active"';
                                }
                                ?>>
                                    <a href="<?php echo base_url(); ?>admin/operator_list">Operator List</a>
                                </li>
                                <li <?php
                                if ($this->uri->segment(2) == 'report') {
                                    echo 'class="active"';
                                }
                                ?>>
                                    <a href="<?php echo base_url(); ?>admin/report">Report</a>
                                </li>
                            </ul>
                        </li>


                        <li <?php
                        if ($this->uri->segment(2) == 'user') {
                            echo 'class="active"';
                        }
                        ?>>
                            <a href="<?php echo base_url(); ?>admin/user">User</a>
                        </li>

                        <?php /* ?> <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown">System <b class="caret"></b></a>
                          <ul class="dropdown-menu">

                          </ul>
                          </li><?php */ ?>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">System<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo base_url(); ?>admin/logout">Logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <ul style="margin-top: 10px;">
                        <li>
                            <?php
                            $session_arr = $this->session->all_userdata();
                            $user_id = $session_arr['user_id'];
                            ?>
                            <a href="<?php echo base_url(); ?>admin/operator_data" data-id="<?php echo $user_id; ?>" class="operator_detail">Operator detail</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>