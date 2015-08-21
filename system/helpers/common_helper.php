<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * CodeIgniter Array Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/array_helper.html
 */
// ------------------------------------------------------------------------

/**
 * Element
 *
 * Lets you determine whether an array index is set and whether it has a value.
 * If the element is empty it returns FALSE (or whatever you specify as the default value.)
 *
 * @access	public
 * @param	string
 * @param	array
 * @param	mixed
 * @return	mixed	depends on what the array contains
 */
if (!function_exists('random_number')) {

    function random_number($digits = 5) {

        return $randno = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
    }

}
if (!function_exists('_clang')) {

    function _clang($val) {
        $val = stripslashes($val);
        $val = trim($val);

        return $val;
    }

}

/**
 * Use to encrypt Password
 * return encrypt password
 * */
if (!function_exists('encrypt')) {

    function encrypt($data) {
        if ($data) {
            $returnvalue = $data;
            for ($i = 0; $i < 2; $i++) {
                $returnvalue = strrev(base64_encode($returnvalue));
            }
            return $returnvalue;
        } else {
            return;
        }
    }

}

/**
 * Use to decrypt Password
 * return decrypt password
 * */
if (!function_exists('decrypt')) {

    function decrypt($data) {
        if ($data) {
            $returnvalue = $data;
            for ($i = 0; $i < 2; $i++) {
                $returnvalue = base64_decode(strrev($returnvalue));
            }
            return $returnvalue;
        } else {
            return;
        }
    }

}

/**
 * Use to get random Password
 * return raw password
 * */
if (!function_exists('generate_password')) {

    function generate_password($length = 8) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password = substr(str_shuffle($chars), 0, $length);
        return $password;
    }

}

if (!function_exists('affiliate_number')) {

    function affiliate_number($digits = 9) {

        return $affiliate_no = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
    }

}
/**
 * Use to get url encode
 * return decode char
 * */
if (!function_exists('base64url_encode')) {

    function base64url_encode($str) {
        return strtr(base64_encode($str), '+/', '-_');
    }

}
/**
 * Use to get url decode
 * return encode char
 * */
if (!function_exists('base64url_decode')) {

    function base64url_decode($base64url) {
        return base64_decode(strtr($base64url, '-_', '+/'));
    }

}

/**
 * Use to get admin details
 * return array for name and email
 * */
if (!function_exists('get_admin_email')) {

    function get_admin_detail() {
        $array = array('email' => 'bhushan@amutechnologies.com', 'name' => 'StacksClassifieds');
        return $array;
    }

}
/**
 * Use to get google login data
 * return array for google login
 * */
if (!function_exists('K_google')) {

    function K_google() {

        $ci = & get_instance();
        $ci->load->config('google');
        $google_client_id = $ci->config->item('google_client_id');
        $google_client_secret = $ci->config->item('google_client_secret');
        $google_redirect_url = $ci->config->item('google_redirect_url'); //path to your script
        $google_developer_key = $ci->config->item('google_developer_key');

        require_once 'src/Google_Client.php';
        require_once 'src/contrib/Google_Oauth2Service.php';
        $gClient = new Google_Client();
        $gClient->setClientId($google_client_id);
        $gClient->setClientSecret($google_client_secret);
        $gClient->setRedirectUri($google_redirect_url);
        $gClient->setDeveloperKey($google_developer_key);


        $google_oauthV2 = new Google_Oauth2Service($gClient);


        //If user wish to log out, we just unset Session variable
        if (isset($_REQUEST['reset'])) {
            unset($_SESSION['token']);
            $gClient->revokeToken();
            header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL)); //redirect user back to page
        }
        if (!isset($_GET['code']) && empty($_REQUEST['state'])) {
            unset($_SESSION['token']);
        }
        //If code is empty, redirect user to google authentication page for code.
        //Code is required to aquire Access Token from google
        //Once we have access token, assign token to session variable
        //and we can redirect user back to page and login.

        if (isset($_GET['code']) && empty($_REQUEST['state'])) {
            $gClient->authenticate($_GET['code']);
            $_SESSION['token'] = $gClient->getAccessToken();
            //echo $_SESSION['token'];die;
            //header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
            //return;
        }


        if (isset($_SESSION['token'])) {
            //echo "tokent->".$_SESSION['token'];
            $gClient->setAccessToken($_SESSION['token']);
        }

        //echo "aceec->". $gClient->getAccessToken(); die;
        if ($gClient->getAccessToken()) {
            //For logged in user, get details from google using access token
            $data['guser'] = $google_oauthV2->userinfo->get();
            $data['guser_id'] = $data['guser']['id'];
            $data['guser_name'] = filter_var($data['guser']['name'], FILTER_SANITIZE_SPECIAL_CHARS);
            $data['gemail'] = filter_var($data['guser']['email'], FILTER_SANITIZE_EMAIL);
            $data['gprofile_url'] = filter_var($data['guser']['link'], FILTER_VALIDATE_URL);
            $data['gprofile_image_url'] = filter_var($data['guser']['picture'], FILTER_VALIDATE_URL);
            $gprofile_image_url = $data['gprofile_image_url'];
            $email = $data['gemail'];
            $data['gpersonMarkup'] = "$email<div><img src='$gprofile_image_url?sz=50'></div>";
            $user = $data['guser'];
            if (!empty($user)) {
                $get_users = $ci->user_model->get_user_by_filed('google_id', $user['id']);
                if (count($get_users) == 0) {
                    $data_to_store = array(
                        'firstname' => $user['given_name'],
                        'google_id' => $user['id'],
                        'lastname' => $user['family_name'],
                        'primary_email' => $user['email'],
                        'gender' => $user['gender'],
                        'avatar' => $user['picture'],
                        'type_of_membership' => 'FREE',
                        'date_of_registration' => date("Y-m-d H:i:s"),
                        'last_login' => date("Y-m-d H:i:s"),
                        'status' => 'Active',
                    );
                    $ci->user_model->store_user($data_to_store);
                    $last_id = $ci->db->insert_id();
                } else {
                    $data_to_store = array(
                        'firstname' => $user['given_name'],
                        'google_id' => $user['id'],
                        'lastname' => $user['family_name'],
                        'primary_email' => $user['email'],
                        'gender' => $user['gender'],
                        'avatar' => $user['picture'],
                        'last_login' => date("Y-m-d H:i:s"),
                    );
                    $ci->user_model->update_user_by_field('google_id', $get_users[0]['google_id'], $data_to_store);
                    $last_id = $get_users[0]['user_id'];
                }
                $get_member = 'FREE';
                $session = array(
                    'username' => $user['email'],
                    'user_id' => $last_id,
                    'type_of_membership' => $get_member,
                    'login_google' => 1,
                    'is_logged_in' => true
                );
                //print_r($session);
                $ci->session->set_userdata($session);

                //echo '<pre>';print_r($ci->session->userdata); die;
                //print_r($data['guser']); die;
                //$_SESSION['token']
                if (isset($_GET['code'])) {
                    echo "<script>
							window.close();
					window.opener.location.reload();
						</script>";
                    //redirect($google_redirect_url);
                }
            }
        } else {
            //For Guest user, get google login url
            $data['authUrl'] = $gClient->createAuthUrl();
        }

        return $data;
    }

}

/**
 * Use to get Facebook login data
 * return array for facebook User data
 * */
if (!function_exists('K_facebook')) {

    function K_facebook() {

        //facebook add user and session entry process end
        $ci = & get_instance();
        $ci->load->library('facebook');
        $user = $ci->facebook->getUser();
        if (!empty($user)) {

            $data['user_profile'] = $ci->facebook->api('/me');
            //echo '<pre>'; print_r($data['user_profile']);
            $access_token = $ci->facebook->getAccessToken();
            $params = array('next' => base_url('welcome/logout/'), 'access_token' => $access_token);
            $data['logout_url'] = $ci->facebook->getLogoutUrl($params);
            $get_users = $ci->user_model->get_user_by_filed('fb_id', $data['user_profile']['id']);

            $firstname = (!empty($data['user_profile']['first_name']) ? $data['user_profile']['first_name'] : "");
            $lastname = (!empty($data['user_profile']['last_name']) ? $data['user_profile']['last_name'] : "");
            $username = (!empty($data['user_profile']['username']) ? $data['user_profile']['username'] : "");
            $email = (!empty($data['user_profile']['email']) ? $data['user_profile']['email'] : "");
            $gender = (!empty($data['user_profile']['gender']) ? $data['user_profile']['gender'] : "");

            /* if (isset($_REQUEST['state']) && isset($_REQUEST['code'])) {
              echo "<script>
              window.close();
              window.opener.location.reload();
              </script>";
              } else {
              // load page
              } */

            if (count($get_users) == 0) {
                $data_to_store = array(
                    'firstname' => $firstname,
                    'fb_id' => $data['user_profile']['id'],
                    'lastname' => $lastname,
                    'username' => $username,
                    'password' => '',
                    'primary_email' => $email,
                    'gender' => $gender,
                    'avatar' => '',
                    'town' => '',
                    'type_of_membership' => 'FREE',
                    'date_of_registration' => date("Y-m-d H:i:s"),
                    'last_login' => date("Y-m-d H:i:s"),
                    'status' => 'Active',
                );
                $ci->user_model->store_user($data_to_store);
            } else {
                $data_to_store = array(
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'username' => $username,
                    'primary_email' => $email,
                    'gender' => $data['user_profile']['gender'],
                    'last_login' => date("Y-m-d H:i:s"),
                );
                $ci->user_model->update_user_by_field('fb_id', $get_users[0]['fb_id'], $data_to_store);
            }
            $get_fb_data = $ci->user_model->get_user_by_filed('fb_id', $data['user_profile']['id']);
            $session = array(
                'username' => $get_fb_data[0]['primary_email'],
                'user_id' => $get_fb_data[0]['user_id'],
                'type_of_membership' => $get_users[0]['type_of_membership'],
                'login_facebook' => 1,
                'is_logged_in' => true
            );
            $ci->session->set_userdata($session);
            $facebook_redirect_url = site_url();
            //echo '<pre>'; print_r($_GET); die;
            if (isset($_GET['code']) && isset($_GET['state'])) {
                echo "<script>
							window.close();
					window.opener.location.reload();
						</script>";

                //redirect($facebook_redirect_url);
            }
            //}
            //facebook add user and session entry process end
        } else {
            $data['login_url'] = $ci->facebook->getLoginUrl(array(
                'display' => 'popup',
                'next' => site_url(),
                /* 'redirect_uri' => site_url(), */
                'scope' => array("email") // permissions here
            ));
        }
        return $data;
    }

}
/**
 * Use to get type of user
 * return array for User data
 * */
if (!function_exists('type_of_user')) {

    function type_of_user() {
        $data = array('poweradmin');
        return $data;
    }

}
/**
 * Use to validate url
 * return array
 * */
if (!function_exists('url_exists_curl')) {

    function url_exists_curl($url) {
        $ch = @curl_init($url);
        @curl_setopt($ch, CURLOPT_HEADER, TRUE);
        @curl_setopt($ch, CURLOPT_NOBODY, TRUE);
        @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
        @curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $status = array();
        preg_match('/HTTP\/.* ([0-9]+) .*/', @curl_exec($ch), $status);
        if (@$status[1] == 200) {
            return true;
        } else {
            return false;
        }
    }

}

/**
 * Use to get user access data
 * return array for User access data

 * */
if (!function_exists('user_access')) {

    function user_access($user_id, $permission) {
        // delete_users => To display delete user button
        // delete_newsletter => To display delete newsletter button
        // add_power_admin => To display power_admin in Type of memebership in User add
        $roles = array("power_admin" => array('delete_users',
                'delete_newsletters',
                'add_power_admin'),
            "normal_admin" => array('add_power_admin'),
        );
        $ci = & get_instance();
        $ci->load->model('user_model');
        $user_role_data = $ci->user_model->get_user_by_id($user_id);
        @$user_role = $user_role_data[0]['type_of_membership'];

        if (@in_array($permission, $roles[$user_role]))
            return true;
        else
            return false;
    }

}

/**
 * Use to get CMS block data
 * return data

 * */
if (!function_exists('cms_block')) {

    function cms_block($block_name) {
        $ci = & get_instance();
        $ci->load->model('cms_model');
        $data = $ci->cms_model->get_cms_by_block_name($block_name);
        return $data[0]['description'];
//		$return = @$data[0][$ci->session->userdata('language_shortcode')];
//		if(empty($return)){
//			return @$data[0]['description'];
//		}else if(!empty($data[0][$ci->session->userdata('language_shortcode')])){
//			return @$data[0][$ci->session->userdata('language_shortcode')];
//		}else{
//			return null;
//			}
    }

}

/**
 * Use to get CMS block data
 * return data

 * */
if (!function_exists('cms_help_list')) {

    function cms_help_list() {
        $ci = & get_instance();
        $ci->load->model('cms_model');
        $data = $ci->cms_model->get_cms_by_field("type", "help_page");
        return $data;
    }

}
/**
 * Use to get custom radio selected data
 * return data

 * */
if (!function_exists('custom_set_radio')) {

    function custom_set_radio($field, $value, $defaults = null) {
        // first, check to see if the form element was POSTed
        if (isset($_POST[$field])) {
            // does it match the value we provided?
            if ($_POST[$field] == $value) {
                // yes, so set the checkbox
                return "checked='checked'"; // valid for both checkboxes and radio buttons
            }
        }
        // There was no POST, so check to see if the provided defaults contains our field
        elseif (!is_null($defaults) && isset($defaults)) {
            // does it match the value we provided?
            // yes, so set the checkbox
            return "checked='checked'"; // valid for both checkboxes and radio buttons
        }
    }

}
/**
 * Use to get custom selected value data
 * return data

 * */
if (!function_exists('custom_set_value')) {

    function custom_set_value($field, $defaults = null) {
        // first, check to see if the form element was POSTed
        if (isset($_POST[$field])) {
            // does it match the value we provided?
            if (!empty($_POST[$field])) {
                // yes, so set the checkbox
                return $_POST[$field];
                // valid for both checkboxes and radio buttons
            }
        }
        // There was no POST, so check to see if the provided defaults contains our field
    }

}
/**
 * Use to get custom select selected data
 * return data

 * */
if (!function_exists('custom_set_select')) {

    function custom_set_select($field, $value, $defaults = null) {
        // first, check to see if the form element was POSTed
        if (isset($_POST[$field])) {
            if (!is_array($_POST[$field])) {
                // does it match the value we provided?
                if ($_POST[$field] == $value) {
                    // yes, so set the checkbox
                    return "selected='selected'";
                    // valid for both checkboxes and radio buttons
                }
            } else if (is_array($_POST[$field])) {

                $field = $_POST[$field];
                if (in_array($value, $field)) {
                    return "selected='selected'";
                }
            }
        } else {

            return "";
        }
        // There was no POST, so check to see if the provided defaults contains our field
    }

}
/**
 * Use to get seo friendly url slug from any string
 * return data

 * */
if (!function_exists('create_slug')) {

    function create_slug($phrase, $maxLength = 100000000000000) {
        $result = strtolower($phrase);

        $result = preg_replace("/[^A-Za-z0-9\s-._\/]/", "", $result);
        $result = str_replace("/", "", $result);
        $result = trim(preg_replace("/[\s-]+/", " ", $result));
        $result = trim(substr($result, 0, $maxLength));
        $result = preg_replace("/\s/", "-", $result);

        return $result;
    }

}
/**
 * Use to get Youtube code from URL string
 * return data

 * */
if (!function_exists('get_youtube_code')) {

    function get_youtube_code($videolink) {
        $ytarray = explode("/", $videolink);
        $ytendstring = end($ytarray);
        $ytendarray = explode("?v=", $ytendstring);
        $ytendstring = end($ytendarray);
        $ytendarray = explode("&", $ytendstring);
        $ytcode = $ytendarray[0];
        return $ytcode;
    }

}
/**
 * Use to get view path of file
 * return file path

 * */
if (!function_exists('get_youtube_code')) {

    function get_view_path($view_name) {
        $target_file = APPPATH . 'views/' . $view_name . '.php';
        if (file_exists($target_file))
            return $target_file;
    }

}
/**
 * Use to set Free user accesses
 * return as defined

 * */
if (!function_exists('get_if_free_user')) {

    function get_if_free_user($value) {
        $ci = & get_instance();
        if (!$ci->session->userdata('is_logged_in') || $ci->session->userdata('type_of_membership') == 'FREE') {
            switch ($value) {
                case 'class_free_user':
                    $data = "free_user";
                    break;
                case 'advance_search_popup':
                    $data = 'onClick="popup(\'advance_search_popup\')"';
                    break;
                case 'class_free_user_overlay_1':
                    $data = "free_user_overlay_1";
                    break;
                case 'class_free_user_overlay_2':
                    $data = "free_user_overlay_2";
                    break;
                case 'manage_schedule_popup_2':
                    $data = 'onClick="popup(\'manage_schedule_popup_2\')"';
                    break;
                case 'class_free_user_overlay_3':
                    $data = "free_user_overlay_3";
                    break;
                case 'class_free_user_overlay_4':
                    $data = "free_user_overlay_4";
                    break;
                case 'class_free_user_overlay_5':
                    $data = "free_user_overlay_5";
                    break;
                case 'manage_schedule_popup_3':
                    $data = 'onClick="popup(\'manage_schedule_popup_3\')"';
                    break;
            }
            return $data;
        } else {
            return;
        }
    }

}
/**
 * Use to get gopremium price value
 * return file path
  for ex: array("month" => 1.99,"year" => 23.88, "final"=> 95.52,"plan" => "Premium Plan", "total_years" => "4 years", "months_in_years" => 48);
 * */
if (!function_exists('get_gopremium_price')) {

    function get_gopremium_price($mode) {
        if ($mode == 'pre1_year_4') {
            $pre1_year_4 = array("month" => 1.99, "year" => 23.88, "final" => 95.52, "plan" => "Premium Plan", "total_years" => "4 years", "months_in_years" => 48, "type_of_membership" => "PRE1");
            return $pre1_year_4;
        } else
        if ($mode == 'pre1_year_2') {
            $pre1_year_2 = array("month" => 2.79, "year" => 33.48, "final" => 66.96, "plan" => "Premium Plan", "total_years" => "2 years", "months_in_years" => 24, "type_of_membership" => "PRE1");
            return $pre1_year_2;
        } else
        if ($mode == 'pre1_year_1') {
            $pre1_year_1 = array("month" => 2.99, "year" => 35.88, "final" => 35.88, "plan" => "Premium Plan", "total_years" => "1 year", "months_in_years" => 12, "type_of_membership" => "PRE1");
            return $pre1_year_1;
        } else

        if ($mode == 'pre2_year_4') {
            $pre2_year_4 = array("month" => 5.99, "year" => 71.88, "final" => 287.52, "plan" => "XXL", "total_years" => "4 years", "months_in_years" => 48, "type_of_membership" => "PRE2");
            return $pre2_year_4;
        } else
        if ($mode == 'pre2_year_2') {
            $pre2_year_2 = array("month" => 6.79, "year" => 81.48, "final" => 162.96, "plan" => "XXL", "total_years" => "2 years", "months_in_years" => 24, "type_of_membership" => "PRE2");
            return $pre2_year_2;
        } else
        if ($mode == 'pre2_year_1') {
            $pre2_year_1 = array("month" => 6.99, "year" => 83.88, "final" => 83.88, "plan" => "XXL", "total_years" => "1 year", "months_in_years" => 12, "type_of_membership" => "PRE2");
            return $pre2_year_1;
        }
    }

}
/**
 * Use to Display go premium link price value
 * return file path
 * */
if (!function_exists('show_go_premium_link')) {

    function show_go_premium_link() {
        $ci = & get_instance();
        $ci->load->model('user_model');
        $user_id = $ci->session->userdata("user_id");
        if ($user_id) {
            $user_data = $ci->user_model->get_user_by_id($user_id);
            //echo '<pre>'; print_r($user_data);
            $acepted_members = array("FREE", "PRE1");
            if (in_array($user_data[0]['type_of_membership'], $acepted_members)) {
                //$data = '<a href="'.site_url('premium-account').'">(go Premium!)</a>';
                return true;
            } else {

                return false;
            }
        } else {
            return false;
        }
    }

}
/**
 * Use to get average rate by newsletter_id
 * return file path
 * */
if (!function_exists('get_average_rate')) {

    function get_average_rate($newsletter_id) {
        $ci = & get_instance();
        $ci->load->model('newsletter_model');
        $get_rate = $ci->newsletter_model->get_rate_by_user($newsletter_id);
        $total_user_rate = count($get_rate);
        $star_1 = array();
        $star_2 = array();
        $star_3 = array();
        $star_4 = array();
        $star_5 = array();
        $avg_rate = array();
        for ($r = 0; $r < count($get_rate); $r++) {
            $avg_rate[] = $get_rate[$r]['rate'];

            if ($get_rate[$r]['rate'] <= 1) {
                $star_1[] = $get_rate[$r]["rate"];
            } else if ($get_rate[$r]['rate'] <= 2) {
                $star_2[] = $get_rate[$r]["rate"];
            } else if ($get_rate[$r]['rate'] <= 3) {
                $star_3[] = $get_rate[$r]["rate"];
            } else if ($get_rate[$r]['rate'] <= 4) {
                $star_4[] = $get_rate[$r]["rate"];
            } else if ($get_rate[$r]['rate'] <= 5) {
                $star_5[] = $get_rate[$r]["rate"];
            }
        }
        //print_r($avg_rate);
        $s_star_1 = count($star_1);
        @$s_star_1_per = (100 * $s_star_1) / $total_user_rate;
        $s_star_1_per = !empty($s_star_1_per) ? $s_star_1_per : "0";

        $s_star_2 = count($star_2);
        @$s_star_2_per = (100 * $s_star_2) / $total_user_rate;
        $s_star_2_per = !empty($s_star_2_per) ? $s_star_2_per : "0";

        $s_star_3 = count($star_3);
        @$s_star_3_per = (100 * $s_star_3) / $total_user_rate;
        $s_star_3_per = !empty($s_star_3_per) ? $s_star_3_per : "0";

        $s_star_4 = count($star_4);
        @$s_star_4_per = (100 * $s_star_4) / $total_user_rate;
        $s_star_4_per = !empty($s_star_4_per) ? $s_star_4_per : "0";

        $s_star_5 = count($star_5);
        @$s_star_5_per = (100 * $s_star_5) / $total_user_rate;
        $s_star_5_per = !empty($s_star_5_per) ? $s_star_5_per : "0";

        $s_star_1_per = round($s_star_1_per, 2);
        $s_star_2_per = round($s_star_2_per, 2);
        $s_star_3_per = round($s_star_3_per, 2);
        $s_star_4_per = round($s_star_4_per, 2);
        $s_star_5_per = round($s_star_5_per, 2);

        $rate_sum = array_sum($avg_rate);
        @$avg = (float) $rate_sum / (int) $total_user_rate;
        $avg_round = $avg; //round(2.8, 1);
        $return_array = array("avg_round" => $avg_round);
        return $return_array;
    }

}
/**
 * Use to get memeber type
 * return file path
 * */
if (!function_exists('get_type_of_membership_txt')) {

    function get_type_of_membership_txt($type_of_membership) {
        switch ($type_of_membership) {
            case 'normal_admin':
                $type_of_membership = "Normal Admin";
                break;
            case 'power_admin':
                $type_of_membership = "Power Admin";
                break;
            case 'FREE':
                $type_of_membership = "Free";
                break;
            case 'PRE1':
                $type_of_membership = "Premium type 1";
                break;
            case 'PRE2':
                $type_of_membership = "Premium type 2";
                break;
            case 'PUB1':
                $type_of_membership = "Publisher type 1";
                break;
            case 'PUB2':
                $type_of_membership = "Publisher type 2";
                break;
            case 'CAAD':
                $type_of_membership = "Company account Administrator";
                break;
            case 'CAUS':
                $type_of_membership = "Company Account";
                break;
        }
        return $type_of_membership;
    }

}
/**
 * Use to Display additional email link price value
 * return file path
 * */
if (!function_exists('show_additional_email_link')) {

    function show_additional_email_link() {
        $ci = & get_instance();
        $ci->load->model('user_model');
        $user_id = $ci->session->userdata("user_id");
        if ($user_id) {
            $user_data = $ci->user_model->get_user_by_id($user_id);
            //echo '<pre>'; print_r($user_data);
            $acepted_members = array("FREE");
            if (in_array($user_data[0]['type_of_membership'], $acepted_members)) {
                //$data = '<a href="'.site_url('premium-account').'">(go Premium!)</a>';
                return false;
            } else {

                return true;
            }
        } else {
            return false;
        }
    }

}
/**
 * Use to Display Meta and title value
 * return file path
 * */
if (!function_exists('show_meta')) {

    function show_meta() {
        $return = '';
        $ci = & get_instance();
        $user_id = $ci->session->userdata("user_id");
        $default_title = 'knewdog! - The World&#039;s Best Way to Read Newsletters.';
        $default_description = 'It`s like your own dog trained to bring your newsletters when you need them, to the place you want them... And from now on knewdog! will protect your mailbox from spam and virus.';
        $default_keyword = 'Newsletter , newsletter, get newsletter';

        if ($ci->uri->segment(1) == 'blog') {
            //Blog
            $id = $ci->uri->segment(4);
            $ci->load->model('blog_model');
            $get_data = $ci->blog_model->get_blog_by_id($id);

            $data = array(
                "title" => (!empty($get_data[0]['meta_title']) ? $get_data[0]['meta_title'] : $default_title),
                "keyword" => (!empty($get_data[0]['meta_keyword']) ? $get_data[0]['meta_keyword'] : $default_keyword),
                "description" => (!empty($get_data[0]['meta_description']) ? $get_data[0]['meta_description'] : $default_description));
        } else {
            //Default
            if ($ci->uri->segment(1)) {
                $title = ucfirst($ci->uri->segment(1)) . " Page";
            } else {
                $title = 'Home Page';
            }
            $data = array("title" => $default_title, "keyword" => $default_keyword, "description" => $default_description);
        }
        return $return .='<title>' . $data['title'] . '</title>
			<meta name="description" content="' . $data['description'] . '">
			<meta name="keywords" content="' . $data['keyword'] . '">
			<meta property="og:type" content="website" />
			<meta property="og:url" content="' . current_url() . '" />
			<meta property="og:site_name" content="knewdog!" />
			<meta name="robots" content="index, follow"/>';

        //return $return;
    }

}
/**
 * Use to Display Meta and title value
 * return file path
 * */
if (!function_exists('add_head')) {

    function add_head() {
        $ci = & get_instance();
        $session_language_shortcode = $ci->session->userdata('language_shortcode');
        $data = '<link rel="stylesheet" href="' . base_url() . '/assets/css/styles_' . $session_language_shortcode . '.css">';
        return $data;
    }

}

/**
 * Use to Display Meta and title value
 * return file path
 * */
if (!function_exists('get_excerpt')) {

    function get_excerpt($str, $length = 10, $trailing = '...') {
        /*
         * * $str -String to truncate
         * * $length - length to truncate
         * * $trailing - the trailing character, default: "..."
         */
        // take off chars for the trailing
        $length-=mb_strlen($trailing);
        if (mb_strlen($str) > $length) {
            // string exceeded length, truncate and add trailing dots
            $string = mb_substr($str, 0, $length) . $trailing;
            return strip_tags($string);
        } else {
            // string was already short enough, return the string
            $res = strip_tags($str);
        }

        return $res;
    }

}

/**
 *
 * Allow models to use other models
 *
 * This is a substitute for the inability to load models
 * inside of other models in CodeIgniter.  Call it like
 * this:
 *
 * $salaries = model_load_model('salary');
 * ...
 * $salary = $salaries->get_salary($employee_id);
 *
 * @param string $model_name The name of the model that is to be loaded
 *
 * @return object The requested model object
 *
 */
if (!function_exists('model_load_model')) {

    function model_load_model($model_name) {
        $CI = & get_instance();
        $CI->load->model($model_name);
        return $CI->$model_name;
    }

}
/**
 * Use to Display session language words
 * return file path
**/
/*if(!function_exists('get_excerpt'))
{

	function get_excerpt ($str, $length=10, $trailing='...')
	{

	}
}*/
/* End of file common_helper.php */
/* Location: ./system/helpers/common_helper.php */