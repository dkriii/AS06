<?php 
/*
	filename 	: cis355api(10.php
	author   	: george corser// edited by Daniel Keiffer
	course   	: cis355 (winter2020)
	description	: demonstrate JSON API functions
				  return number of new covid19 cases
	input    	: https://api.covid19api.com/summary
	functions   : main()
	                curl_get_contents()
*/

main();

#-----------------------------------------------------------------------------
# FUNCTIONS
#-----------------------------------------------------------------------------
function main () {
	
	$apiCall = 'https://api.covid19api.com/summary';
	// line below stopped working on CSIS server
	// $json_string = file_get_contents($apiCall); 
	$json_string = curl_get_contents($apiCall);
	$obj = json_decode($json_string);
    $data = $obj->Countries;
    
    for($i=0;$i<count($data);$i++){
        $myArray[$i] = array('Country' => $data[$i]->Country, 'TotalConfirmed' => $data[$i]->TotalConfirmed);
    }    
    
     array_multisort(array_Column($myArray, 'TotalConfirmed'), SORT_DESC, $myArray);
    
    for($i=0;$i<10;$i++){
        $sortedArray[$i] = array('Country' => $myArray[$i]['Country'], 'TotalConfirmed' => $myArray[$i]['TotalConfirmed']);    
    }
    
    $jsonArray = json_encode($sortedArray);
    //print_r($jsonArray);
    
echo "<html>";
echo"<head>";
    echo"<meta charset='utf-8'>";
    echo"<link   href='css/bootstrap.min.css' rel='stylesheet>";
    echo"<script src='js/bootstrap.min.js'></script>";
echo"</head>";
echo "<table class='table table-striped table-bordered' style='background-color: lightblue' cellspacing='20' !important'>";

	echo "<thead>";
		echo "<tr>";
		echo    "<th></th>";
		echo    "<th>Country</th>";
    	echo	"<th>Confirmed Cases</th>";


	echo	"</tr>";
	echo "</thead>";
	echo "<tbody";
    $num=0;
        foreach($sortedArray as $row){
				$num++;
				echo '<tr>';
				echo '<td>' . $num;
				echo '<td>'. $row['Country'];
				echo '<td>' .$row['TotalConfirmed'];
				echo '</td>';
				echo '</tr>';
			}
		
echo"</tbody>";
	
echo "</html>";




    
}

#-----------------------------------------------------------------------------
// read data from a URL into a string
function curl_get_contents($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}



?>

