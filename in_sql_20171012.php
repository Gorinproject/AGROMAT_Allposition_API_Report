<?php
require_once 'connection.php';
$project=array("558462","558464","558469","558471","558472","558474","558476","558477","558479","558482","558483","561169");
require 'Client.php';

$allpositions_client = new allpositions\api\Client('key');
$query = '';
$link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));
mysqli_query($link, "SET NAMES 'utf8'"); 
mysqli_query($link, "SET CHARACTER SET 'utf8'");
mysqli_query($link, "SET SESSION collation_connection = 'utf8_general_ci'");
mysqli_query($link, "TRUNCATE TABLE `positions_in_db`");
$date_rep = "2017-09-15";
$date_start= "2017-09-01";
$datei = array("2017-01-01","2017-02-01","2017-03-01","2017-04-01","2017-05-01","2017-06-01","2017-07-01","2017-08-01","2017-09-01","2017-10-01","2017-11-01","2017-12-01");


for($y=0; $y < count($datei) - 1; $y++)
{
$date_start = $datei[$y];
$date_rep = $datei[$y+1];
//echo $date_start.'***'.$date_rep.'+++';
for($pr=0; $pr < count($project); $pr++)
{ 

$report = $allpositions_client->getReport($project[$pr], $date_rep, $date_start);

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

$query ="INSERT INTO `b4_19047883_wordpress`.`positions_in_db` (`query`, `wordstat`, `name_region`, `position`, `prev_position`, `change_position`, `url`, `date_rep`, `date_start`) VALUES ('".$date[0]."', '".$date[1]."', '".$date[2]."', '".$date[3]."', '".$date[4]."', '".$date[5]."', '".$date[6]."', '".$date[7]."', '".$date[8]."');";
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

$query ="INSERT INTO `b4_19047883_wordpress`.`positions_in_db` (`query`, `wordstat`, `name_region`, `position`, `prev_position`, `change_position`, `url`, `date_rep`, `date_start`) VALUES ('".$date[0]."', '".$date[1]."', '".$date[2]."', '".$date[3]."', '".$date[4]."', '".$date[5]."', '".$date[6]."', '".$date[7]."', '".$date[8]."');";
//echo $query;
$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 

/*echo '<tr><td rowspan="2">'.($queries[$i][query]).'</td>
<td rowspan="2">'.($queries[$i][wordstat]).'</td>
<td>'.$sengines[0][name_region].'</td>
<td>'.$positions[$sengines[0][id_se].'_'.$queries[$i][id_query]][position].'</td>
<td>'.$positions[$sengines[0][id_se].'_'.$queries[$i][id_query]][prev_position].'</td>
<td style="color:green; font-weight:bold;">'.$positions[$sengines[0][id_se].'_'.$queries[$i][id_query]][change_position].'</td>
<td>'.$positions[$sengines[0][id_se].'_'.$queries[$i][id_query]][url].'</td></tr>'

.'<tr><td>'.$sengines[1][name_region].'</td>
<td>'.$positions[$sengines[1][id_se].'_'.$queries[$i][id_query]][position].'</td>
<td>'.$positions[$sengines[0][id_se].'_'.$queries[$i][id_query]][prev_position].'</td>
<td style="color:green; font-weight:bold;">'.$positions[$sengines[1][id_se].'_'.$queries[$i][id_query]][change_position].'</td>
<td>'.$positions[$sengines[1][id_se].'_'.$queries[$i][id_query]][url].'</td></tr>';
*/
}}}

//echo '</table>';
//mysqli_close($link);


$group = $allpositions_client->getReportDates(558476);

echo '<pre>';
var_dump($group);
echo count($group);
echo '<table border="1">';
for ($i=0; $i< count($group); $i++);

echo '<tr><td>'.($group[$i][group]).'</td><td>'.($group[$i][id_group]).'</td></tr>';

echo '</table>';



?>


<?php echo '9999999999999999999999999999';?>
<?php
$project2=array

("558462","558464","558469","558471","558472","558474","558476","558477","558479","558482","558483","561169");

$allpositions_client = new allpositions\api\Client('4dc0d540ddc196c9b7e5e9997e29d7c3');

echo '<table class="table table-bordered">';
echo '<tr><th>Запрос</th>
<th>Частота</th>
<th>Поисковая система</th>
<th>Текущая позиция</th>
<th>Предыдущая позиция</th>
<th>Изменение позиции</th>
<th>Найденный URL</th></tr>';

$pr=0;

for($pr=0; $pr < count($project2); $pr++)
{ 

$report2 = $allpositions_client->getReport($project2[$pr], "2017-09-01", "2017-08-01");

$count2= $report2[count];
$sengines2 = $report2[sengines];
$queries2 =$report2[queries];
$positions2 = $report2[positions];


for ($i=0; $i<$count2; $i++)
echo '<tr><td rowspan="2">'.($queries2[$i][query]).'</td><td rowspan="2">'.($queries2[$i][wordstat]).'</td><td>'.

$sengines2

[0][name_region].'</td><td>'.$positions2[$sengines2[0][id_se].'_'.$queries[$i][id_query]][position].'</td><td>'.

$positions2

[$sengines2[0][id_se].'_'.$queries2[$i][id_query]][prev_position]
.'</td><td style="color:green; font-weight:bold;">'.$positions2[$sengines2[0][id_se].'_'.$queries2[$i][id_query]]

[change_position]
.'</td><td>'.$positions2[$sengines2[0][id_se].'_'.$queries2[$i][id_query]][url].'</td></tr>'
.'<tr><td>'.$sengines2[1][name_region].'</td><td>'.$positions2[$sengines2[1][id_se].'_'.$queries2[$i][id_query]]

[position].'</td><td>'.$positions2[$sengines2[0][id_se].'_'.$queries2[$i][id_query]][prev_position]
.'</td><td style="color:green; font-weight:bold;">'.$positions2[$sengines2[1][id_se].'_'.$queries2[$i][id_query]]

[change_position]
.'</td><td>'.$positions2[$sengines2[1][id_se].'_'.$queries2[$i][id_query]][url].'</td></tr>';

}

echo '</table>';



$group = $allpositions_client->getReportDates(558476);

echo '<pre>';
var_dump($group);
echo count($group);
echo '<table border="1">';
for ($i=0; $i< count($group); $i++);

echo '<tr><td>'.($group[$i][group]).'</td><td>'.($group[$i][id_group]).'</td></tr>';

echo '</table>';



?>
