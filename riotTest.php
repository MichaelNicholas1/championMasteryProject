<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" type="text/css" href="style.css">
    </head>
<body>
<form  id ="selection" method='post'>
      I want all champions with mastery level 
<select name='option'>
  <option value="less"> Less than </option>
  <option value="greater"> Greater than </option>
  <option value="equal"> Equal to </option>
  <option value="lesseq">Less than or equal to</option>
  <option value="greatereq">Greater than or equal to</option>
    
</select>
    <input type="number" id="level" name="level" min = 1 max = 7 required = true>
    for <input type='text' id ="summoner" name = "summoner" required=true placeholder="summoner name here">
    <input type="submit" id = "selection" name="selection" />
</form>  


    
    
    
<?php
    require 'config.php';
//INSERT into summoners (summonerName, summonerId)
//Values ('ChrisC1208', '7xefWD4FSDz2U45Rzcgepr5OgKO9bmiDyFfoQRV6VlrWPds');
    
    
    
//https://na1.api.riotgames.com/lol/summoner/v4/summoners/by-name/Cannabomb%200?api_key=RGAPI-95718d02-068b-4f72-ab27-c58baac91369    
/*summoner id's
* chrisc1208 - 7xefWD4FSDz2U45Rzcgepr5OgKO9bmiDyFfoQRV6VlrWPds
* addmeelbakro - AFozj9ImPJgOcZDJsylcunOjnfg2DMNLbJkBs8dlIxAOGzM
* addmeelbakro - stored locally to prevent duplicate api calls --> result.json
*/
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
    
if($nameFound){
    if(($timeStamp + 86000) < time()){
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
        $timeLeft = gmdate("H:i:s",(($timeStamp + 86000) - time()));
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
                            $name = array_search($val, $champions);
                            echo "Champion Name: ".$name."<br> Champion Level: ".$championLevel."<br> Champion Points: ".$championPoints."<br>Champion Points Until Next Level: ".$championPointsUntilNextLevel."<br>";
                            echo "----------------------------------------- <br>";
                        }
                    }
                        else if($option == "greater"){
                            if($championLevel > $level){
                                $name = array_search($val, $champions);
                                echo "Champion Name: ".$name."<br> Champion Level: ".$championLevel."<br> Champion Points: ".$championPoints."<br>.Champion Points Until Next Level: ".$championPointsUntilNextLevel."<br>";
                                echo "----------------------------------------- <br>";
                            }
                    }
                        else if($option == "equal"){
                            if($championLevel == $level){
                                $name = array_search($val, $champions);
                                echo "Champion Name: ".$name."<br> Champion Level: ".$championLevel."<br> Champion Points: ".$championPoints."<br>Champion Points Until Next Level: ".$championPointsUntilNextLevel."<br>";
                                echo "----------------------------------------- <br>";
                            }
                    }
                        else if($option == "lesseq"){
                            if($championLevel <= $level){
                                $name = array_search($val, $champions);
                                echo "Champion Name: ".$name."<br> Champion Level: ".$championLevel."<br> Champion Points: ".$championPoints."<br>Champion Points Until Next Level: ".$championPointsUntilNextLevel."<br>";
                                echo "----------------------------------------- <br>";
                            }
                    }
                        else if($option == "greatereq"){
                            if($championLevel >= $level){
                                                            echo $championPoints."<br>";
                                $name = array_search($val, $champions);
                                echo "Champion Name: ".$name."<br> Champion Level: ".$championLevel."<br> Champion Points: ".$championPoints."<br>Champion Points Until Next Level: ".$championPointsUntilNextLevel."<br>";
                                echo "----------------------------------------- <br>";
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