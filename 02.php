<!doctype html>
<html lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="/proba/podloga.css">
  <link href='http://fonts.googleapis.com/css?family=Spicy+Rice' rel='stylesheet' type='text/css'>
<title>Vremenska prognoza</title>
</head>
<body>

<?php


 mysql_connect("localhost","silvahab","s1be3Rh6P2");
 mysql_select_db("silvahab_weather123");
 
$term=$_GET["grad"];

 
$query=mysql_query("SELECT * FROM popisGradova where grad like '%".$term."%' order by grad ");

 
    while($grad=mysql_fetch_array($query)){
      
                    $WOEID= $grad["WOEID"];
                        
    }

include '03.php';

//kreiranje objekta 
$weather = new YahooWeather($WOEID, 'c');
 
$datum =$weather->getForecastTodayDate();
$temperatura = $weather->getTemperature();
$grad = $weather->getLocationCity();
$drzava = $weather->getLocationCountry();
$slika=$weather->getYahooIcon();
$opis=$weather->getForecastTodayDescription();
mysql_query("INSERT INTO `Vrijeme` VALUES ('$datum','$grad','$drzava', '$temperatura','$opis')");

echo "<center><br>Grad: <b>$grad</b></br></center>";
echo "<center><br>Drzava: <b>$drzava</b></br></center>";
echo "<center><br>Temperatura: <b>$temperatura</b></br></center>";
echo "<center>$slika<center>";
echo "<center>$datum</center>";

echo '<center><br>Popis vec unesenih gradova:</br></center>';

$query=mysql_query("SELECT * FROM Vrijeme");

echo '<table class="table table-striped table-bordered table-hover">'; 
echo"<TR><TD><b>Grad</b></TD><TD><b>Drzava</b></TD><TD><b>Temperatura(Celzijus)</b></TD><TD><b>Opis</b></TD></TR>"; 
    while($prognoza=mysql_fetch_array($query)){
 

              
echo "</tr><td>";  
echo $prognoza["grad"];		    
echo "</td><td>";  
echo $prognoza["drzava"];             
echo "</td><td>";  
echo $prognoza["temp"];   
echo "</td><td>";  
echo $prognoza["opis"];		 
echo "</TD></tr>";  

 }
echo "</table>"; 


?>



</body>
</html>
