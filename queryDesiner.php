<?php
 session_start();
 if(isset($_POST['reset'])) 
 {
     session_destroy();
     session_unset();
 }
?>

<!DOCTYPE html>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Query Designer</title>
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="script/jquery.js"></script>
<script>
$(document).ready(function(){
    getTable('eshop');
    
    $('#ddlTables').click(function(){
        
        
        tblName = ($(this).val());
        $.post(
        'ajax.php'
       ,{tblName:tblName}
       ,function(data)
           {
               $('body').append(data);
           }
       )
        
    })
    
})
    function getTable(dbName)
{
    $.post(
        'gettbl.php'
       ,{dbname:dbName}
       ,function(data)
           {
               $('#ddlTables').html(data);
           }
       )
}
function query(table, field)
{
    $.post(
        'ajax.php',
        {fieldName:field, tableName:table},
        function(data)
        {
           $('#queryText').html(data)
        }
        
    
    )
}
</script>
</head>
<body>
<form action="" method="post">
    <input type="submit" value="Reset" name="reset">
</form>

<p id='queryText'>
 
</p>
  <div class="popUp">
  <p class="popTitle">Add Table</p>
    <div class="popUpContent">
        <select id='ddlTables' size="20">
        
        </select>
    </div>
    
  </div>

</body>
</html>

