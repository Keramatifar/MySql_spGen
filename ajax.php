<?php
session_start();
require 'class.DatabaseHandler.php';
    if(isset($_POST['tblName']))
    {
        $tablename = $_POST['tblName'];
        if(!isset($_SESSION[$tablename]))
        {
           $result =   DatabaseHandler::GetAll("SHOW FIELDS FROM $tablename");    
            $_SESSION[$tablename] = $result;
        }
        else
        $result = $_SESSION[$tablename];
        
        
        $table = "<div class='box'>";
        
        foreach($result as $item)
        {
            
            $table .= 
            "
                <input type='checkbox' onclick='query(\"$tablename\", \"$item[Field]\")'>
                    $item[Field]
                <br />
            " ;
        }    
        $table .= '</div>';
        echo $table;
        
    }
    if(isset($_POST['fieldName']))
    {
       $tableInfo = $_SESSION[$_POST['tableName']];
       $PK = '';
       foreach($tableInfo as $item)
       {
           if($item['Key'] == 'PRI')
           {
               $PK = $item['Field'];
               break;
           }
       }
        
        $tableName = $_POST['tableName'];
       $fieldName = $_POST['fieldName'];
       $query = "SELECT <br /> ";
       if(isset($_SESSION['query']))
       {
           $queryArray = $_SESSION['query'];
       }
       else
       {
           $queryArray= array('fields'=> '', 'from' => '', 'where' => '', 'on' => '' );
       }
       $fields = $queryArray['fields'];
       $from = $queryArray['from'];
       $where = $queryArray['where'];
       $on = $queryArray['on'];
       if($fields == '')
       {
           $fields = "$tableName.$fieldName <br />"; 
       }
       else
       {
           $fields .= ", $tableName.$fieldName <br />"; 
       }
       
       if($from == '')
       {
           $from = "$tableName"; 
       }
       elseif($from != $tableName)
       {
           $on = "ON $from.$tableName".'_'. "$PK = $tableName.$PK";
           $from .= " JOIN $tableName"; 
           
           
       }
       
       
       
       $query .= $fields;
       $query .= "<br /> FROM $from";
       $query .= "<br /> $on";
       $queryArray= array('fields'=> $fields, 'from' => $from, 'where' => $where, 'on' => $on );
       $_SESSION['query'] = $queryArray;
       
       echo $query;
       
    }
?>

    

