<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/main.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/media.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/core.css">
        <!--<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/contact.css">-->
        <script src="<?php echo base_url(); ?>assets/js/jquery-1.7.1.min.js"></script>
<!--        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->
<!--        <script src="<?php echo base_url(); ?>assets/js/hogan.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/typeahead.js"></script>-->
        <script src="<?php echo base_url(); ?>assets/js/plugins.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/script_t.js"></script>
        <script type="text/javascript">var base_url = '<?php echo base_url(); ?>'</script>

        <!--<script src="a/j/libs/modernizr-2.5.3.min.js"></script>-->
        <style>
            @fontface{ font-family:Roboto; src:url(<?php echo base_url(); ?>assets/Roboto-Regular.ttf);}
        </style>
        <title>vidazen</title>
    </head>
    <body>
        <div id="wrap">
            <header>
                <div class="main_head">
                    <div class="log_head">
                        <nav class="log_right">
                            <ul>
                                <?php
                                //echo "<pre>"; print_r($this->session->all_userdata());
                                if (!$this->session->userdata('is_logged_in')) {
                                    ?>
                                    <li><a href="<?php echo site_url('signin/signin_user'); ?>">Login</a></li>
                                    <li><a href="<?php echo site_url('term') ?>">Terms</a></li>
                                    <li><a href="<?php echo site_url('privacy') ?>">Privacy</a></li>
                                    <li><a href="<?php echo site_url('safety') ?>">Safety</a></li>
    <!--                                    <li><a href="<?php echo site_url('signup/signup_user'); ?>">Register </a></li>-->
                                    <?php
                                } else {
                                    ?>

                                    <li><?php
                                        $email = $this->session->userdata('primary_email');
                                        echo "logged in as" . " " . $email;
                                        ?></li>
                                    <li><?php $user_email = base64url_encode($email); ?><a href="<?php echo site_url("home/change_password/{$user_email}"); ?>">Change password</a></li>
                                    <li><a href="<?php echo site_url('home/logout'); ?>">Logout </a></li>
                                <?php } ?>

                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="main_headmenu">
                    <div class="main_hemenu">
                        <h1 class="logo"><a href="<?php echo site_url('home'); ?>"><img src="<?php echo base_url(); ?>assets/images/logo.png" alt=""></a></h1>
                        <div class="group_main">
                            <nav class="group">
                                <h2 class="navheader slide-trigger">Menu <span></span></h2>
                                <ul class="navigation">
                                    <li><a href="<?php echo site_url('home'); ?>">Home</a></li>
                                    <li><a href="<?php echo site_url('affiliate'); ?>">Affiliates</a></li>
                                    <li><a href="#">Promote</a></li>
                                    <li><a href="<?php echo site_url('contactus') ?>">Contact</a></li>
                                    <li><a href="<?php echo site_url('help') ?>">Help</a></li>
                                </ul>
                            </nav>
                            <div class="post_add">
                                <a href="<?php echo base_url("ad_type") ?>">Post a new ad</a>
                                <?php
//                                $ci = & get_instance();
//                                $ci->load->model('common_model');
//                                $stack_state_id = $this->session->userdata('stack_state_id');
//                                $stack_city_id = $this->session->userdata('stack_city_id');
//                                if (isset($stack_state_id) && !empty($stack_state_id)) {
//                                    $whereState = " AND state_id='{$stack_city_id}'";
//                                    $state_name = $ci->common_model->getFieldData('state', 'state_name', $whereState);
//
//
                                ?>
                                   <!--<a href = "<?php //echo base_url("ad_type/$state_name")                                                                                   ?>">Post a new ad</a>-->
                                <?php
//                                } else if (isset($stack_city_id) && !empty($stack_city_id)) {
//                                    $whereCity = " AND city_id='{$stack_city_id}'";
//                                    $city_name = $ci->common_model->getFieldData('city', 'city_name', $whereCity);
//
                                ?>
                               <!--<a href = "<?php //echo base_url("ad_type/$city_name")                                                                                     ?>">Post a new ad</a>-->
                                <?php
                                //} else {
//
                                ?>
                               <!--<a href="<?php //echo base_url("ad_type")                                                                                    ?>">Post a new ad</a>-->
                                <?php //}          ?>


                            </div>
                        </div>
                        <div style="clear: both; float: right; font-size: 19px;">
                            <?php
                            $ci = & get_instance();
                            $ci->load->model('common_model');
                            $stack_state_id_selected = $this->session->userdata('stack_state_id');
                            $stack_city_id_selected = $this->session->userdata('stack_city_id');
                            if (!empty($stack_state_id_selected)) {
                                $where_state = " AND state_id='{$stack_state_id_selected}'";
                                $state_name = $ci->common_model->getFieldData('state', 'state_name', $where_state);
                                echo $classifieds = $state_name . ', <span style="color:bfc5ce">Free classifieds</span>';
                            } elseif (!empty($stack_city_id_selected)) {
                                $where_city = " AND city_id='{$stack_city_id_selected}'";
                                $city_name = $ci->common_model->getFieldData('city', 'city_name', $where_city);
                                echo $classifieds = $city_name . ', <span style="color:#bfc5ce">Free classifieds</span>';
                            } else {
                                if (isset($page_type)) {
                                    if ($page_type == 'home') {
                                        echo $classifieds = "";
                                    }
                                } else {
                                    echo $classifieds = "StacksClassifieds.com, <span style='color:#bfc5ce'>Free classifieds</span>";
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </header>
