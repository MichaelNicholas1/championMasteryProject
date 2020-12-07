<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" type="text/css" href="style.css">
            <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/png">
        
    <!--====== Magnific Popup CSS ======-->
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
        
    <!--====== Slick CSS ======-->
    <link rel="stylesheet" href="assets/css/slick.css">
        
    <!--====== Line Icons CSS ======-->
    <link rel="stylesheet" href="assets/css/LineIcons.css">
        
    <!--====== Bootstrap CSS ======-->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    
    <!--====== Default CSS ======-->
    <link rel="stylesheet" href="assets/css/default.css">
    
    <!--====== Style CSS ======-->
    <link rel="stylesheet" href="assets/css/style.css">
    </head>
<body>
    

    
<form  id ="selection" method='post'>
      I want all champions with mastery level (level number, not points!) 
<select name='option'>
  <option value="less"> Less than </option>
  <option value="greater"> Greater than </option>
  <option value="equal"> Equal to </option>
  <option value="lesseq">Less than or equal to</option>
  <option value="greatereq">Greater than or equal to</option>
    
</select>
    <input placeholder = "1-7" type="number" id="level" name="level" min = 1 max = 7 required = true>
    for <input type='text' id ="summoner" name = "summoner" required=true placeholder="summoner name here">
    <input type="submit" id = "selection" name="selection" />
    (summoner name is case sensitive!)
</form>  
    
    
    
<?php
    require 'config.php';

$found = false;
if(isset($_POST['summoner'])){        
try{
    $conn = new PDO($dsn, $username, $password, $options);
    $stmt = $conn->prepare("SELECT * FROM summoners");
    $stmt->execute();
    $summonerName = str_replace('%20', ' ',$_POST['summoner']);
    $nameFound = false;
    $endLoop = false;
    $stampIt = false;
    $timeStamp = 0;
    $championJson = 0;
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach(new ArrayIterator($stmt->fetchAll()) as $k=>$entry) {
        if($endLoop){
            break;
        }
        foreach($entry as $val){
            if($summonerName == $val){
                $nameFound = true;
            }
            else if($nameFound && $endLoop == false){
                $summoner = $val;
                $endLoop = true;
               // break;
            }
            //skip over the json in the database
            else if($endLoop == true && $stampIt == false){
                $championJson = $val;
                $stampIt = true;
            }
            else if($stampIt == true){
                $timeStamp = $val;
                break;
            }
        }
    }
    if($nameFound){
        $summonerId = $summoner;
    }
    //if we didn't find the summoner, add their summoner name and id to database
    else{
        //$summonerName = str_replace(' ', '%20',$_POST['summoner']);
        $urlSummoner = str_replace(' ', '%20',$_POST['summoner']);
        $summonerId = @file_get_contents("https://na1.api.riotgames.com/lol/summoner/v4/summoners/by-name/".$urlSummoner."?api_key=".$api);
         //@ suppresses 404 warning

        
       
   
        $jsonIterator = new RecursiveIteratorIterator(
            new RecursiveArrayIterator(json_decode($summonerId, TRUE)),
            RecursiveIteratorIterator::SELF_FIRST);
            foreach($jsonIterator as $key=>$val){
                if($key == "id"){   
                $summoner = $val;
        
    }
}
        $data = [
            'summonerName'=>$summonerName,
            'summonerId'=>$summoner,
            'timestamp'=>time(),
            
        ];
        
        $stmt = $conn->prepare("INSERT into summoners (summonerName, summonerId, timestamp) Values (:summonerName, :summonerId, :timestamp)");
        $stmt->execute($data);
    }
}
catch(Exception $e) {
    echo "Error finding player data. Please check spelling/try again.";
    exit;
    
}
//$conn = null;

    
    
//$summoner = "7xefWD4FSDz2U45Rzcgepr5OgKO9bmiDyFfoQRV6VlrWPds";
    
//add functionality to prevent api calls younger than a day (86000 seconds in a day, if the saved time stamp + 1 day is less than current time, than we can make a new api call)
    //lowering time from 86000 (1day) to 1800(30 min) for api calls until i find a proper time to use
    
if($nameFound){
    if(($timeStamp + 1800) < time()){
       // echo "last call was older than one day";
        $championMastery = file_get_contents("https://na1.api.riotgames.com/lol/champion-mastery/v4/champion-masteries/by-summoner/".$summoner."?api_key=".$api);
        
                $data = [
            'summonerName'=>$summonerName,
            'timestamp'=>time(),
            
        ];
        
        $stmt = $conn->prepare("UPDATE summoners SET timestamp=:timestamp WHERE (summonerName=:summonerName)");
        $stmt->execute($data);
    }
    else{
        $timeLeft = gmdate("H:i:s",(($timeStamp + 1800) - time()));
        echo "Note that champion data is not up to date!<br> Time remaining until you can update this data: ".$timeLeft." (Hours:Minutes:Seconds)";
        $championMastery = $championJson;
    }
}
    else{
      //  echo "<br> name wasnt found";
        $championMastery = file_get_contents("https://na1.api.riotgames.com/lol/champion-mastery/v4/champion-masteries/by-summoner/".$summoner."?api_key=".$api);
        
                        $data = [
            'summonerName'=>$summonerName,
            'championMastery'=>$championMastery,
            
        ];
        
        $stmt = $conn->prepare("UPDATE summoners SET championMastery=:championMastery WHERE (summonerName=:summonerName)");
        $stmt->execute($data);
    }

$conn = null;

//method to obtain champion name and key from https://ddragon.leagueoflegends.com/api/versions.json (updates by pulling current patch from link below)
$currentPatch = json_decode(file_get_contents("https://ddragon.leagueoflegends.com/api/versions.json"),true);
$staticData = file_get_contents("http://ddragon.leagueoflegends.com/cdn/".$currentPatch[0]."/data/en_US/champion.json");
$champions = [];
$championKey = 0;
$championPoints = '';
$championLevel = 5;
$championPointsUntilNextLevel = 0;
$championPointsUntilNextLevel = 0;
if(isset($_POST['option']) && isset($_POST['level'])){
    $option = $_POST['option'];
    $level = $_POST['level'];
}

$jsonIterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator(json_decode($staticData , TRUE)),
    RecursiveIteratorIterator::SELF_FIRST);
foreach($jsonIterator as $key=>$val){
        if($key == "key"){ 
        if(is_numeric($val) == true){
            $championKey = $val;
        }

        
    }
        else if($key=="name"){
            $champions[$val] = $championKey;
        }
}

//https://stackoverflow.com/questions/4343596/how-can-i-parse-a-json-file-with-php
$jsonIterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator(json_decode($championMastery , TRUE)),
    RecursiveIteratorIterator::SELF_FIRST);
//$championMastery = json_decode($championMastery);

    
    
echo '            <div class="row justify-content-center">';
    
    
            $name = "";
            $box = '
                                            <div class="col-lg-4 col-md-7 col-sm-9">
                    <div class="single-features mt-40">
                        <div class="features-title-icon d-flex justify-content-between"> ';
                            

    
                    /*    '<div class="features-content">
                            <p class="text">Short description for the ones who look for something new. Short description for the ones who look for something new.</p>
                            <a class="features-btn" href="#">LEARN MORE</a>
                        </div>
                    </div> <!-- single features -->
                </div> '; */
                 
echo "<h2>Champion Mastery Statistics for ".$_POST['summoner'].", Points Descending</h2>";
foreach($jsonIterator as $key=>$val){
    if(gettype($val) == 'array'){
        $championPoints = $val['championPoints']; 
        $championLevel = $val['championLevel'];
        $championPointsUntilNextLevel = $val['championPointsUntilNextLevel'];
    }
        else if($key == "championLevel"){
            if(gettype($val) == 'array'){
            $championLevel = strval($val['championLevel']);
        }else{
            $championLevel = $val;   
            }
    }
        else if($key == "championPoints"){
        if(gettype($val) == 'array'){
            $championPoints = strval($val['championPoints']);
        }
        else{
            $championPoints = strval($val); 
        }
    }
        else if ($key == "championId") {

            
            //filter for champion level
                if(isset($_POST['option']) && isset($_POST['level'])){                                                                                                       
                    if($option == "less"){
                        if($championLevel < $level){
                            echo $box;
                            $name = array_search($val, $champions);
                            $namePic = str_replace(" ","",$name);
                            $namePic = str_replace("'","",$namePic);
                            echo '<h4 class="features-title"><a href="#">'.$name.'</a></h4> ';
                                        $champIcon =                ' <div class="champ-thumbnail">
                               <img class="img-thumbnail" src="assets/images/default_champion_tiles/'.$namePic.'_0.jpg" > 
                            </div>
                        </div> ';
                            echo $champIcon;
                            echo "Champion Level: ".$championLevel."<br> Champion Points: ".$championPoints."<br>Champion Points Until Next Level: ".$championPointsUntilNextLevel."<br>";
                            echo "----------------------------------------- <br>";
                            echo '<div class="features-content">
                        </div>
                    </div> <!-- single features -->
                </div> ';
                        }
                    }
                        else if($option == "greater"){
                            if($championLevel > $level){
echo $box;
                            $name = array_search($val, $champions);
                                                            $namePic = str_replace(" ","",$name);
                            $namePic = str_replace("'","",$namePic);
                            echo '<h4 class="features-title"><a href="#">'.$name.'</a></h4> ';
                                            $champIcon =                ' <div class="champ-thumbnail">
                               <img class="img-thumbnail" src="assets/images/default_champion_tiles/'.$namePic.'_0.jpg" > 
                            </div>
                        </div> ';
                            echo $champIcon;
                            echo "Champion Level: ".$championLevel."<br> Champion Points: ".$championPoints."<br>Champion Points Until Next Level: ".$championPointsUntilNextLevel."<br>";
                            echo "----------------------------------------- <br>";
                            echo '<div class="features-content">
                        </div>
                    </div> <!-- single features -->
                </div> ';
                            }
                    }
                        else if($option == "equal"){
                            if($championLevel == $level){
echo $box;
                            $name = array_search($val, $champions);
                                                            $namePic = str_replace(" ","",$name);
                            $namePic = str_replace("'","",$namePic);
                            echo '<h4 class="features-title"><a href="#">'.$name.'</a></h4> ';
                                            $champIcon =                ' <div class="champ-thumbnail">
                               <img class="img-thumbnail" src="assets/images/default_champion_tiles/'.$namePic.'_0.jpg" > 
                            </div>
                        </div> ';
                            echo $champIcon;
                            echo "Champion Level: ".$championLevel."<br> Champion Points: ".$championPoints."<br>Champion Points Until Next Level: ".$championPointsUntilNextLevel."<br>";
                            echo "----------------------------------------- <br>";
                            echo '<div class="features-content">
                        </div>
                    </div> <!-- single features -->
                </div> ';
                            }
                    }
                        else if($option == "lesseq"){
                            if($championLevel <= $level){
echo $box;
                            $name = array_search($val, $champions);
                                                            $namePic = str_replace(" ","",$name);
                            $namePic = str_replace("'","",$namePic);
                            echo '<h4 class="features-title"><a href="#">'.$name.'</a></h4> ';
                                            $champIcon =                ' <div class="champ-thumbnail">
                               <img class="img-thumbnail" src="assets/images/default_champion_tiles/'.$namePic.'_0.jpg" > 
                            </div>
                        </div> ';
                            echo $champIcon;
                            echo "Champion Level: ".$championLevel."<br> Champion Points: ".$championPoints."<br>Champion Points Until Next Level: ".$championPointsUntilNextLevel."<br>";
                            echo "----------------------------------------- <br>";
                            echo '<div class="features-content">
                        </div>
                    </div> <!-- single features -->
                </div> ';
                            }
                    }
                        else if($option == "greatereq"){
                            if($championLevel >= $level){
echo $box;
                            $name = array_search($val, $champions);
                            $namePic = str_replace(" ","",$name);
                            $namePic = str_replace("'","",$namePic);
                            echo '<h4 class="features-title"><a href="#">'.$name.'</a></h4> ';
                                            $champIcon =                ' <div class="champ-thumbnail">
                               <img class="img-thumbnail" src="assets/images/default_champion_tiles/'.$namePic.'_0.jpg" > 
                            </div>
                        </div> ';
                            echo $champIcon;
                            echo "Champion Level: ".$championLevel."<br> Champion Points: ".$championPoints."<br>Champion Points Until Next Level: ".$championPointsUntilNextLevel."<br>";
                            echo "----------------------------------------- <br>";
                            echo '<div class="features-content">
                        </div>
                    </div> <!-- single features -->
                </div>';
                            }
                    }
        }
    }

}
//var_dump($championMastery);


}

?>
    
    </body>
</html>