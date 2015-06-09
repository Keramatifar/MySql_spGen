<?php

$host = 'localhost';
$username = 'root';
$password = '';
$dbs = '';
$script = '';
if (isset($_POST['txtHost']))
{
    $host = $_POST['txtHost'];
    $username = $_POST['txtUsername'];
    $password = $_POST['txtPassword'];
    include 'f_spgen.php';
    $isDisable = '';
    
    $result = mysql_list_dbs( $conn );
    
    while( $row = mysql_fetch_object( $result ) ):
    if (isset($_POST['cmbDatabase']) && ($_POST['cmbDatabase'] == $row->Database))
    {
        $dbs.= "<option value='$row->Database' selected='true'>$row->Database</option>"; 
    }
    else
    {
        $dbs.= "<option value='$row->Database'>$row->Database</option>"; 
    }
    endwhile;
    
    if($conn && isset($_POST["tbls"]))
    {
        $Database = $_POST['cmbDatabase'];
        $tableName = $_POST["tbls"];
        $arrchk = $_POST['chbSp'];
        $arrchkDelete = $_POST['chbSpDelete'];
        $PrefixSp = $_POST['txtPrefixSp'];
        $Seprator = $_POST['txtSeprator'];
        $script =  "<script language=javascript>getTable('$Database')</script>" ;
        createProcedureAndDAL($Database,$tableName,$arrchk,$arrchkDelete,$PrefixSp,$Seprator);
    }
    
}
else
{
    $isDisable = 'disabled="true"';
}





?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Keramatifar Stored Procedure Generator</title>
<style>
div#outerDiv{width: 970px; height: 600px; background: ; margin: 0 auto;}
div#containerDiv{width: 100%; height: 400px; background: ;}
div#tblListDiv{width: 400px; float: left; height: 400px;}
div#dblistDiv{width: 400px; float: left; height: 400px;}
.fl{border: 1px solid black; width: 350px; height: 430px;}
.f2{border: 1px solid black; width: 300px; height: 130px;} 
.title{font: normal 12px tahoma; color: gray;}
</style>
<script type="text/javascript" src="script/jquery.js"></script>
<script type="text/javascript" src="script/validate.js"></script>
<script type="text/javascript">
    $(document).ready(
        function()
        {
            $("#dbForm").validate();
        }
        );
</script>
<script type="text/javascript" src="script/spgen.js"></script>
<?php
    echo $script;  
?>
</head>
<body>
<div id="outerDiv">
<h1><a href="http://www.barnamenevis.info" target="_blank">Barnamenevis &copy;</a> Stored Procedure Generator</h1>
<div id="containerDiv">

    <fieldset class="f2">
        <legend>Server</legend>
        <form action="" method="post" name="dbForm">
            Host name: <input name="txtHost" type="text" class="required" value="<?php echo $host ?>" />
            <br />
            Username: <input name="txtUsername" type="text" class="required" value="<?php echo $username ?>" />
            <br />
            Password: <input name="txtPassword" type="password" value="<?php echo $password ?>" class="required"/>
            <br />
            <br />
            <input type="submit" value="Connect"/>
        </form>
    </fieldset>
    
    <fieldset class="fl" <?php echo $isDisable ?> >
    <legend>Tables</legend>
    
    <form method="post" action="">
    <input name="txtHost" type="hidden" value="<?php echo $host ?>" />
    <input name="txtUsername" type="hidden" value="<?php echo $username ?>" />
    <input name="txtPassword" type="hidden" value="<?php echo $password ?>" />
    <p class="title">Please Select Database</p>
    <select onchange="getTable(this.value)" name="cmbDatabase">
     <?php echo $dbs ?>
     </select>
    <p class="title">Please Select Table</p>
    <select id="tbls" name="tbls">
    
    </select>
    <br />
    <br />
    Prefix: <input name="txtPrefixSp" type="text" class="required" value="sp" />
    <br />
    Seprator: <input name="txtSeprator" type="text" class="required" value="_" />
    <br />
    <table width="100%" border="0">
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><input type="checkbox" name="chbSp[]" value="SelectAll" checked="checked" /> Select All</td>
        <td><input type="checkbox" name="chbSpDelete[]" value="SelectAll" checked="checked" />if EXISTS Delete</td>
      </tr>
      <tr>
        <td><input type="checkbox" name="chbSp[]" value="SelectRow" checked="checked" /> Select Row</td>
        <td><input type="checkbox" name="chbSpDelete[]" value="SelectRow" checked="checked" />if EXISTS Delete</td>
      </tr>
      <tr>
        <td><input type="checkbox" name="chbSp[]" value="DeleteRow" checked="checked" /> Delete Row</td>
        <td><input type="checkbox" name="chbSpDelete[]" value="DeleteRow" checked="checked" />if EXISTS Delete</td>
      </tr>
      <tr>
        <td><input type="checkbox" name="chbSp[]" value="UpdateRow" checked="checked" /> Update Row</td>
        <td><input type="checkbox" name="chbSpDelete[]" value="UpdateRow" checked="checked" />if EXISTS Delete</td>
      </tr>
      <tr>
        <td><input type="checkbox" name="chbSp[]" value="Insert" checked="checked" /> Insert</td>
        <td><input type="checkbox" name="chbSpDelete[]" value="Insert" checked="checked" />if EXISTS Delete</td>
      </tr>
      <tr>
        <td><input type="checkbox" name="chbSp[]" value="CreateDAL" checked="checked" /> Create Data Access Layer</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    <br />

        <input type="submit" value="Create" />

    </form>
    </fieldset>
</div><!--ContainerDiv-->
<div id="spSelectDiv">
</div><!--- spSelectDiv -->
<div id="test"></test>
</div>
</body></html>