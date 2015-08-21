<?php 
include_once("fckeditor/fckeditor.php"); 
include_once("basepath.php");
?>
<?php
$oFCKeditor = new FCKeditor('tDescription',$tDescription);
$oFCKeditor->Width  = '800' ;
$oFCKeditor->Height = '350' ;
$oFCKeditor->BasePath = $BasePath;
//$oFCKeditor->ToolbarSet = "Basic" ;
$oFCKeditor->Config['SkinPath'] = $BasePath.'editor/skins/office2003/';
$oFCKeditor->Create(); 
?>
<script>
/*document.getElementById('tDescription').contentDocument.getElementById('xEditingArea').style.height = '100.1%';
  setTimeout(function() { 
    document.getElementById('tDescription').contentDocument.getElementById('xEditingArea').style.height = '100%'
  }, 100); */
</script>