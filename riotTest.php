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
    $firstTime = false;
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach(new ArrayIterator($stmt->fetchAll()) as $k=>$entry) {
        if($endLoop){
            break;
        }
        foreach($entry as $val){
            if($summonerName == $val){
                $nameFound = true;
            }
            else if($nameFound){
                $summoner = $val;
                $endLoop = true;
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
        $firstTime = true;
         //@ suppresses 404 warning

        
       
   
        $jsonIterator = new RecursiveIteratorIterator(
            new RecursiveArrayIterator(json_decode($summonerId, TRUE)),
            RecursiveIteratorIterator::SELF_FIRST);
            foreach($jsonIterator as $key=>$val){
                echo "<br> test".$key."<br>";
                if($key == "id"){   
                $summoner = $val;
        
    }
}
        $data = [
            'summonerName'=>$summonerName,
            'summonerId'=>$summoner,
        ];
        
        $stmt = $conn->prepare("INSERT into summoners (summonerName, summonerId) Values (:summonerName, :summonerId)");
        $stmt->execute($data);
    }
}
catch(Exception $e) {
    echo "Error finding player data. Please check spelling/try again.";
    exit;
    
}
$conn = null;

    
    
//$summoner = "7xefWD4FSDz2U45Rzcgepr5OgKO9bmiDyFfoQRV6VlrWPds";

$championMastery = file_get_contents("https://na1.api.riotgames.com/lol/champion-mastery/v4/champion-masteries/by-summoner/".$summoner."?api_key=".$api);

//method to obtain champion name and key from https://riot-api-libraries.readthedocs.io/en/latest/ddragon.html (update upon new champion release/patch)
$staticData = file_get_contents("http://ddragon.leagueoflegends.com/cdn/9.23.1/data/en_US/champion.json");
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