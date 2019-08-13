<?php
require_once 'connection.php';
$project=array("558462","558464","558469","558471","558472","558474","558476","558477","558479","558482","558483","561169","561698", "561706", "561707", "561708", "561717", "561719", "561727", "561730", "561732");
require 'Client.php';

$allpositions_client = new allpositions\api\Client('key');
$query = '';
$link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));
mysqli_query($link, "SET NAMES 'utf8'"); 
mysqli_query($link, "SET CHARACTER SET 'utf8'");
mysqli_query($link, "SET SESSION collation_connection = 'utf8_general_ci'");
mysqli_query($link, "TRUNCATE TABLE `positions_in_db`");
$date_rep = "2018-05-15";
$date_start= "2018-01-01";

$datei = array("2018-05-15", "2018-05-01", "2018-04-15", "2018-02-02", "2018-03-15", "2018-03-02", "2018-02-15", "2018-02-03", "2018-02-03", "2018-01-15", "2018-01-01");

for($pr=0; $pr < count($project); $pr++)
{
	$datei = $allpositions_client->getReportDates($project[$pr]);
	for($y=0; $y < count($datei) - 1; $y++)
{ 
$date_start = $datei[$y];
$date_rep = $datei[$y+1];
echo '++++++++++++++++++++';
var_dump ($d);
echo '++++++++++++++++++++';
echo '<br>param_getReport ('.$project[$pr].', '.$date_rep.', '.$date_start.') <br>-------------<br>';
$report = $allpositions_client->getReport($project[$pr], $date_rep, $date_start);
var_dump ($report);
$count= $report[count];
$sengines = $report[sengines];
$queries =$report[queries];
$positions = $report[positions];

for ($i=0; $i<$count; $i++){

$date[0] = $queries[$i][query];
$date[1] = $queries[$i][wordstat];
$date[2] = $sengines[0][name_region];
$date[3] = $positions[$sengines[0][id_se].'_'.$queries[$i][id_query]][position];
$date[4] = $positions[$sengines[0][id_se].'_'.$queries[$i][id_query]][prev_position];
$date[5] = $positions[$sengines[0][id_se].'_'.$queries[$i][id_query]][change_position];
$date[6] = $positions[$sengines[0][id_se].'_'.$queries[$i][id_query]][url];
$date[7] = $date_rep;
$date[8] = $date_start;
$date[9] = $project[$pr];

$query ="INSERT INTO `b4_19047883_wordpress`.`positions_in_db` (`query`, `wordstat`, `name_region`, `position`, `prev_position`, `change_position`, `url`, `date_rep`, `date_start`, `project`) VALUES ('".$date[0]."', '".$date[1]."', '".$date[2]."', '".$date[3]."', '".$date[4]."', '".$date[5]."', '".$date[6]."', '".$date[7]."', '".$date[8]."', '".$date[9]."');";
//echo $query;
$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 

$date[0] = $queries[$i][query];
$date[1] = $queries[$i][wordstat];
$date[2] = $sengines[1][name_region];
$date[3] = $positions[$sengines[1][id_se].'_'.$queries[$i][id_query]][position];
$date[4] = $positions[$sengines[1][id_se].'_'.$queries[$i][id_query]][prev_position];
$date[5] = $positions[$sengines[1][id_se].'_'.$queries[$i][id_query]][change_position];
$date[6] = $positions[$sengines[1][id_se].'_'.$queries[$i][id_query]][url];
$date[7] = $date_rep;
$date[8] = $date_start;
$date[9] = $project[$pr];

$query ="INSERT INTO `b4_19047883_wordpress`.`positions_in_db` (`query`, `wordstat`, `name_region`, `position`, `prev_position`, `change_position`, `url`, `date_rep`, `date_start`, `project`) VALUES ('".$date[0]."', '".$date[1]."', '".$date[2]."', '".$date[3]."', '".$date[4]."', '".$date[5]."', '".$date[6]."', '".$date[7]."', '".$date[8]."', '".$date[9]."');";
//echo $query;
$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 

}}}

?>