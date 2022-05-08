<div class="kraji">
<?php
require_once 'povezava.php';
if(!empty($_GET['kraj1']) && !empty($_GET['kraj2'])) {
$kraj1= $_GET['kraj1'];
$kraj2= $_GET['kraj2'];
$apiKey = "26b649b1c6b9aa6fde403ea73e1b3e10";
$ch = curl_init();

$sql_cords_kraj1 = "SELECT lat,lng FROM cities WHERE (city LIKE '%$kraj1%')";
$rezultat1 = mysqli_query($link, $sql_cords_kraj1);
$row_kraj1= mysqli_fetch_array($rezultat1);
$nr_row = mysqli_num_rows($rezultat1);
if($nr_row == 0){	
echo "Vnesli ste neobstoječ kraj.";
die();
}
$kraj1_lat = $row_kraj1[0];
$kraj1_lng = $row_kraj1[1];


$sql_distanca ="SELECT a.city AS from_city, b.city AS to_city, 
   69.1 *
    DEGREES(ACOS(LEAST(1.0, COS(RADIANS(a.lat))
         * COS(RADIANS(b.lat))
         * COS(RADIANS(a.lng - b.lng))
         + SIN(RADIANS(a.lat))
         * SIN(RADIANS(b.lat))))) AS distance_in_miles
  FROM cities AS a
  JOIN cities AS b ON a.id <> b.id
 WHERE a.city LIKE '%$kraj1%' AND b.city LIKE '%$kraj2%'";
$rezultat_dist = mysqli_query($link, $sql_distanca);
$dist_row= mysqli_fetch_array($rezultat_dist);
$distanca = $dist_row['distance_in_miles'];
if($distanca > 0 && $distanca < 100){
$populacija = 5000;
}
else if($distanca > 100 && $distanca < 399){
$populacija = 25000;
}
else if($distanca < 400){
$populacija = 50000;
}
else if($distanca > 400){
$populacija = 350000;
}
else if($distanca > 800){
$populacija = 450000;
}
else if($distanca > 3000){
$populacija = 1000000;
}
$sql_cords_kraj2 = "SELECT lat,lng FROM cities WHERE (city LIKE '%$kraj2%')";
$rezultat2 = mysqli_query($link, $sql_cords_kraj2);
$row_kraj2= mysqli_fetch_array($rezultat2);
$kraj2_lat = $row_kraj2[0];
$kraj2_lng = $row_kraj2[1];
if($kraj1_lat >= $kraj2_lat && $kraj1_lng >= $kraj2_lng){
$sql_navigacija = "SELECT lat, lng, city, population, SQRT(
    POW(69.1 * (lat - $kraj1_lat), 2) +
    POW(69.1 * ($kraj1_lng - lng) * COS(lat / 57.3), 2)) AS distance
FROM cities
WHERE  (population > $populacija) AND (lng >= $kraj2_lng AND lng <= $kraj1_lng) AND (lat >= $kraj2_lat AND lat <= $kraj1_lat) HAVING (distance < '$distanca' AND distance != 0)
ORDER BY `distance`  ASC LIMIT 20";	
}
if ($kraj1_lat <= $kraj2_lat && $kraj1_lng <= $kraj2_lng ){
$sql_navigacija = "SELECT lat, lng, city, population, SQRT(
    POW(69.1 * (lat - $kraj1_lat), 2) +
    POW(69.1 * ($kraj1_lng - lng) * COS(lat / 57.3), 2)) AS distance
FROM cities
WHERE  (population > $populacija) AND (lng BETWEEN $kraj1_lng AND $kraj2_lng) AND (lat BETWEEN $kraj1_lat AND $kraj2_lat) HAVING (distance < '$distanca' AND distance != 0)
ORDER BY `distance`  ASC LIMIT 20";
}
if ($kraj1_lat >= $kraj2_lat && $kraj1_lng <= $kraj2_lng ){
$sql_navigacija = "SELECT lat, lng, city, population, SQRT(
    POW(69.1 * (lat - $kraj1_lat), 2) +
    POW(69.1 * ($kraj1_lng - lng) * COS(lat / 57.3), 2)) AS distance
FROM cities
WHERE  (population > $populacija) AND (lng <= $kraj2_lng AND lng >= $kraj1_lng) AND (lat >= $kraj2_lat AND lat <= $kraj1_lat) HAVING (distance < '$distanca' AND distance != 0)
ORDER BY `distance`  ASC LIMIT 20";	
}
if ($kraj1_lat <= $kraj2_lat && $kraj1_lng >= $kraj2_lng ){
$sql_navigacija = "SELECT lat, lng, city, population, SQRT(
    POW(69.1 * (lat - $kraj1_lat), 2) +
    POW(69.1 * ($kraj1_lng - lng) * COS(lat / 57.3), 2)) AS distance
FROM cities
WHERE  (population > $populacija) AND (lng <= $kraj1_lng AND lng >= $kraj2_lng) AND (lat BETWEEN $kraj1_lat AND $kraj2_lat) HAVING (distance < '$distanca' AND distance != 0)
ORDER BY `distance`  ASC LIMIT 20";
}
$rezultat_mesta = mysqli_query($link, $sql_navigacija);
	echo '<table class="kraji">'
	.'<theader><th>Ime</th><th>Latitude</th><th>Longitude</th><th>Populacija</th><th>Stanje</th><th>Temperatura</th></theader>'
	.'<tbody>';
$pinpoints = " ";
while($row = mysqli_fetch_array($rezultat_mesta)){
	$lat_api = $row['lat'];
	$lng_api = $row['lng'];
	$googleApiUrl = "api.openweathermap.org/data/2.5/weather?lat=".$lat_api."&lon=".$lng_api."&units=metric&appid=". $apiKey ."";
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_VERBOSE, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$response = curl_exec($ch);
	curl_close($ch);
	$data = json_decode($response);
	$stanje = ucwords($data->weather[0]->description);
	if($stanje == 'Clear Sky'){
	echo '<tr><td>'.$row['city'].'</td>'
			.'<td>'.$row['lat'].'</td>'	
			.'<td>'.$row['lng'].'</td>'
			.'<td>'.$row['population'].'</td>'
			.'<td>'.$stanje.'</td>'
			.'<td>'. $data->main->temp_min.' C°</td>';
			$pinpoints .="DG.marker([$lat_api, $lng_api]).addTo(map); \n";
	}
}
?>
<?php
}
else{
echo "Vpišite kraje";
}
?>
</div>