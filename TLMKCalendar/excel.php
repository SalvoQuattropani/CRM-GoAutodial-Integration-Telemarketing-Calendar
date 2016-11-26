<?php
$connessione=mysql_connect("localhost","root","vicidialnow");
if(!$connessione)
{
	print("<h8>-Connessione SQL fallita-</h8>");
}
else
{
	
}



$db = mysql_select_db("agenda");
if(!$db)
{
	print("<h8>-Connessione al DB fallita-</h8>");
	exit;
}
else
{
	
}


$query = mysql_query("SELECT cal_id FROM webcal_entry_categories WHERE cat_id='$id_cat'");

if(!$query)
{
	print("<h8>-quesru0 fallita-</h8>");
	exit;
}
else
{
	
	
}


$cat_id=$_POST['cat_id'];
$query_da_fare=$_POST['quary_da_fare'];

$discr=$_POST['discr'];

$agente=$_POST['agente'];
$inizio_data=$_POST['data_in'];
$fine_data=$_POST['data_fin'];




 
 $query_ogg = mysql_query("$query_da_fare");
 
 
 if($query_ogg)
{
	print("<h8>-quesri OGG fallita fallita-</h8>");
	exit;
}
else
{
	
	
}
 
 

 
 
 
$result = mysql_query("SHOW COLUMNS FROM webcal_entry");


if(!$result)
{
	print("<h8>-quesru1 fallita-</h8>");
	exit;
}
else
{
	
	
}


if (mysql_num_rows($result) > 0) {
 while ($row = mysql_fetch_assoc($result)) {
  $csv_output .= $row['Field'].", ";
  $i++;
 }
}
$csv_output .= "\n";




//-------------------------------------
$query = mysql_query("SELECT cal_id FROM webcal_entry_categories WHERE cat_id='$cat_id'");

 while ($temp = mysql_fetch_assoc($query)){
$appoggio=$temp['cal_id'];
echo $appoggio;
 
 
 if($discr==1){
	 $values = mysql_query("SELECT * FROM webcal_entry WHERE cal_id='$appoggio' AND cal_create_by='$agente' AND cal_date between '$inizio_data' and'$fine_data'");
}
 else{
	 if($discr==2){$values = mysql_query("SELECT * FROM webcal_entry WHERE cal_id='$appoggio'  AND cal_date between '$inizio_data' and'$fine_data'");
	 }else{if($discr==3){$values = mysql_query("SELECT * FROM webcal_entry WHERE cal_id='$appoggio' AND cal_create_by='$agente'");
	 }else{if($discr==4){ $values = mysql_query("SELECT * FROM webcal_entry WHERE cal_id='$appoggio'");}}}
 }


if(!$values)
{
	print("<h8>-quesru2 fallita-</h8>");
	exit;
}
else
{
	
}
while ($rowr = mysql_fetch_array($values)) {
 for ($j=0;$j<$i;$j++) {
  $csv_output .= $rowr[$j].", ";
 }
 $csv_output .= "\n";
}
}
$filename = $file."_".date("Y-m-d_H-i",time());
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv" . date("Y-m-d") . ".csv");
header("Content-disposition: filename=".$filename.".csv");
print $csv_output;
?>