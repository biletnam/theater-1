<?php

//

if (!defined('BASEPATH'))
    exit('No direct script access allowed_ext');

class Common {

    function makeUrl($title) {
        $ci = &get_instance();
        $data = $ci->db->escape_str($title);
        $data = preg_replace('/\'/', "", $data);
        $data = preg_replace('/ +/', " ", $data);
        $data = str_replace(" ", "-", $data);
        $data = preg_replace('/[^a-zA-Z0-9.-]/', "", $data);
        //return strtolower($data);
        return $data;
    }

    function uploadFile($fileArray, $destination) {
        if ($fileArray['name'] != "") {
            $allowed_ext = array("jpg", "jpeg", "pjpeg", "gif","flv");
            $arrType = pathinfo($fileArray['name']);
            $extension = "";
            if (isset($arrType['extension'])) {
                $extension = $arrType['extension'];
            }
            if (in_array(strtolower($extension), $allowed_ext)) {
                if ($fileArray["size"] < (10485760)) { 
                    $file_name = $this->makeUrl(date("YmdHis") . "_" . $fileArray["name"]);
                   
                    if (!copy($fileArray["tmp_name"], $destination . '/' . $file_name)) {
                        $_SESSION['MESSAGE'] = "<br>Image cannot be uploded";
                        return false;
                    } else {
                        if (isset($_POST["oldImage"])) {
                            $_POST["oldImage"] = trim($_POST["oldImage"]);
                            if ($_POST["oldImage"] != "") {
                                $this->deleteFile($destination . "/" . $_POST["oldImage"]);
                            }
                        }
                    }
                } else {
                    $_SESSION['MESSAGE'] = "<br>Max filesize should be 1024KB";
                    return false;
                }
            } else {
                $_SESSION['MESSAGE'] = "<br>Format not supported";
                return false;
            }
        } else {
            return false;
        }
        return $file_name;
    }

    /* 	This function deletes the specified file in the first parameter */




    /* this function will return 
     * 1 if unable to copy
     * 2 if file size exist then allowed size (ie. 4MB is current allowed size)
     * 3 if invalid or not allowed extention
     * 4 if $_FILES['file_name']['name] is empty string
     * uploaded file name if successfully uploaded
     */

    function uploadAjaxFile($fileArray, $destination) {
        if ($fileArray['name'] != "") {
            $allowed_ext = array("jpg", "jpeg", "pjpeg", "gif", "png", "pdf", "ppt", "pptx", "pps", "doc", "docx", "txt", "msg", "xml", "psd", "xls", "xlsx", "rar", "zip"/* ,"wbmp","video","x-ms-wm","octet-stream" */, "flv");
            $arrType = pathinfo($fileArray['name']);
            $extension = "";
            if (isset($arrType['extension'])) {
                $extension = $arrType['extension'];
            }
            if (in_array(strtolower($extension), $allowed_ext)) {
                if ($fileArray["size"] < (4485760)) { //
                    $file_name = $this->makeUrl(date("YmdHis") . "_" . $fileArray["name"]);
                    if (!copy($fileArray["tmp_name"], $destination . '/' . $file_name)) {
                        return -1;
                    } else {
                        if (isset($_POST["oldImage"])) {
                            $_POST["oldImage"] = trim($_POST["oldImage"]);
                            if ($_POST["oldImage"] != "") {
                                $this->deleteFile($destination . "/" . $_POST["oldImage"]);
                            }
                        }
                    }
                } else {
                    return -2;
                }
            } else {
                return -3;
            }
        } else {
            return -4;
        }
        return $file_name;
    }

    function deleteFile($file) {
        if (file_exists($file)) {
            if (unlink($file))
                return true;
        }
    }

}

?>
