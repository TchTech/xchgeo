<?php
require 'vendor/autoload.php';
use DiDom\Document ;


class Diary{
    protected $diaryDocument;

    function getDateTitle($document){
        $date = $document->find("h1")[0];
        return $date->text();
    }

    function average(array $arr, bool $roundInts = false){
        if($roundInts){
            return round(array_sum($arr) / count($arr), 1);
        } else{
            return array_sum($arr) / count($arr);
        }
    }

    function setDoc($diaryUrl){
        $d = new Diary;
            if (!(isset($diaryUrl) && $d->isGismeteo($diaryUrl))){ 
                $d->fatalDie("The url has some problems on line 19.", "URL IS WRONG");
            }
            try{
                $this->diaryDocument = new Document($diaryUrl, true);
                //throw new Exception("!SERVER UNAVAILABLE!");
            }
            catch(Exception $err){
                $d->fatalDie("Oops... Gismeteo isn't available", $err->getMessage());
                //return false;
            }
            if($d->isEmptyDiary($this->diaryDocument)){
                $d->fatalDie("The diary dont have any info.", "DIARY IS EMPTY");
            }
            //return true;
    }

    function getDoc(){
        return $this->diaryDocument;
    }
    
    public function fatalDie($desription, $errMsg){
        echo "<h1 style='background-color: rgb(197, 18, 68); color: white; font-size: 100px; font-family: Tahoma;'>" . $desription ."<br>";
        echo "Error msg: <a style='background-color: rgb(197, 18, 68); color: white; font-size: 50px; font-family: Tahoma;'>" . $errMsg . "</a></h1>";
        echo "<form method='get' action='/xchronogeo_alpha_design/index.html'><button type='submit' style='width: 200; height: 70; background-color: orange; color: white; font-size: 30px; font-family: Tahoma;'>GO TO MAIN</button></form>";
        die();
    }
    
    /*public function  initTemperature($diaryUrl){
        $diaryDocument === false ? die("<h1 style='background-color: rgb(197, 18, 68); color: white; font-size: 100px; font-family: Tahoma;'>Gismeteo Diary Document wasn't created.</h1>") 
        : $t = new Temperature;
        return $t->MidWholeNightTemp();
    }*/

    public function isGismeteo($inputurl){

        $coreurl = 'https://www.gismeteo.ru/diary/';
        /*if(strpos($url, $coreurl) != false and str_replace($coreurl,"", $url) != ""){
            return true;
        }*/
    
        if(strstr($inputurl, $coreurl) and str_replace($coreurl,"", $inputurl) != ""){
            return true;
        }
        else{
            return false;
        }
    }

    public function isEmptyDiary($document){
        if($document->has('.empty_phrase')){
            return true;
        }
        else{
            return false;
        }
    }
    
}
class Temperature extends Diary{
    function initTemperature($document){
        $t = new Temperature();
        $monthTemperature = [
            "MiddleMonthTemperature" => $t->Month($document),
            "MiddleDayByDayTemperature" => $t->DayByDay($document),
            "MiddleDayTemperature" => $t->Day($document),
            "MiddleNightTemperature" => $t->Night($document)
        ];
        return $monthTemperature;
    }
    /*function DayByDayTemp($document){ // NOT NEEDED!! ----------------------------------------------------------------------------------
        $days_arr = [];
        $day_or_night = TRUE;
        $textElement = $document->find('td.first_in_group');
        foreach($textElement as $element) {
            //$day_or_night ? $day_or_night_text = "день" : $day_or_night_text = "ночь"; // проверка на время суток. Либо день, Либо ночь.
            if ($day_or_night == TRUE) {
                $day_num++; //если в этой интерации используется день, то прибавляем единицу к дате
            }
            $days_arr[] = $day_num;
            $day_or_night = !$day_or_night; //Смена времени суток.
        }
        return $days_arr;
    }*/
    /*function DayNightTemp($document){ // NOT NEEDED!! -----------------------------------------------------------------------------
        $arrayOfTemperature=array();
        $textElement = $document->find('td.first_in_group');
        foreach($textElement as $element) {
            $arrayOfTemperature[] = str_replace("+", "", $element->text()); //прибавляем температуру в массив, убирая плюс для положительной температуры
        }
        return array_sum($arrayOfTemperature); //сумма температур из массива
    }*/
    function Month($document){
        $arrayOfTemperature=array();
        $textElement = $document->find('td.first_in_group');
        foreach($textElement as $element) {
            $arrayOfTemperature[] = str_replace("+", "", $element->text()); //прибавляем температуру в массив, убирая плюс для положительной температуры
        }
        return ((new Diary))->average($arrayOfTemperature, true); // возвращаем среднее арифметическое
    }
    function DayByDay($document){
        $wholeTemp = [];
        $dayAndNight = array();
        $day_num = 0;
        $dayAdder = FALSE;
        $textElement = $document->find('td.first_in_group');
        foreach($textElement as $element) {
            $dayAndNight[] = $element->text(); // прибавляем температуру дня\ночи в массив
            if ($dayAdder == TRUE) { // если мы прибавили температуру дня и ночи одного и того же дня, то ...
                $day_num++; // дата увеличивается на единицу
                $wholeTemp[] = ((new Diary))->average($dayAndNight); // находим среднее арифметическое температуры целых суток
                unset($dayAndNight);
            }
            $dayAdder = !$dayAdder; //смена переменной на противоположную себе, чтобы следующая итерация работала корректно
        }
        return $wholeTemp;

    }
    function Day($document){
        $days = array();
        $dayAdder = TRUE;
        $textElement = $document->find('td.first_in_group');
        foreach($textElement as $element) {
            if ($dayAdder == TRUE) { //
                $days[] = $element->text(); //
            }
            $dayAdder = !$dayAdder; //
        }
        return ((new Diary))->average($days, true);//
    }
    function Night($document){
        $nights = array();
        $dayAdder = false;
        $textElement = $document->find('td.first_in_group');
        foreach($textElement as $element) {
            if ($dayAdder == TRUE) { //
                $nights[] = $element->text(); //
            }
            $dayAdder = !$dayAdder; //
        }
        return ((new Diary))->average($nights, true); //
    }
}

class Wind extends Diary{
    function initWind($document){
        $w = new Wind();
        $monthWind = [
            "DirectionsByMonth" => $w->Directions($document),
            "MiddleSpeedByMonth" => $w->Speed($document)
        ];
        return $monthWind;
    }
    function Directions($document){
        $north = 0; $northeast = 0; $east = 0; $southeast = 0; $south = 0; $southwest = 0; $west = 0; $northwest = 0; $calm = 0;
        $indexOfWind = 5;
        $windDirectionByDays = array();
        $newDay = false;
        $has_wind = true;
        while($has_wind) {
            $elem = $document->find('td')[$indexOfWind];
            if (!isset($elem)){
                $has_wind = false;
                break;
            } else{
                $windDirection = explode(" ", $elem->text())[0];
                $windDirectionByDays[] = $windDirection;
                $indexOfWind += 11;
            }
        }
        foreach($windDirectionByDays as $direction){
            switch($direction){
                case "С":
                    $north++;
                    break;
                case "СВ":
                    $northeast++;
                    break;
                case "В":
                    $east++;
                    break;
                case "ЮВ":
                    $southeast++;
                    break;
                case "Ю":
                    $south++;
                    break;
                case "ЮЗ":
                    $southwest++;
                    break;
                case "З":
                    $west++;
                    break;
                case "СЗ":
                    $northwest++;
                    break;
                case "Ш":
                    $calm++;
                    break;
            }
        }
        $countedDirections = array($north, $northeast, $east, $southeast, $south, $southwest, $west, $northwest);
        return $countedDirections;
    }
    function Speed($document){
        $indexOfWind = 5;
        $windSpeedByDays = array();
        $newDay = false;
        $has_wind = true;
        while($has_wind) {
            $elem = $document->find('td')[$indexOfWind];
            if (!isset($elem)){
                $has_wind = false;
                break;
            } else{
                $windSpeed = (int) filter_var(explode(" ", $elem->text())[1], FILTER_SANITIZE_NUMBER_INT);
                $windSpeedByDays[] = $windSpeed;
                $indexOfWind += 11;
            }
        }
        return ((new Diary))->average($windSpeedByDays, true);
    }
}

class Pressure extends Diary{
    function initPressure($document){
        $p = new Pressure();
        $monthPressure = [
            "MiddleMonthPressure" => $p->Month($document),
            "MiddleDayByDayPressure" => $p->DayByDay($document),
            "MiddleDayPressure" => $p->Day($document),
            "MiddleNightPressure" => $p->Night($document)
        ];
        return $monthPressure;
    
    }
    function Month($document){
        $indexOfPressure = 2;
        $pressureByWholeDay = array();
        $newDay = false;
        $has_pressure = true;
        while($has_pressure) {
            $elem = $document->find('td')[$indexOfPressure];
            if (!isset($elem)){
                $has_pressure = false;
                break;
            } else{
                $pressureByWholeDay[] = $elem->text();
                //$indexOfPressure += 5;
                $newDay == true ? $indexOfPressure += 6 : $indexOfPressure += 5;
                $newDay = !$newDay;
                //$has_pressure = false;
            }
        }
        return ((new Diary))->average($pressureByWholeDay, true);
    }
    function Day($document){
        $indexOfPressure = 2;
        $pressureByWholeDay = array();
        $newDay = false;
        $has_pressure = true;
        while($has_pressure) {
            $elem = $document->find('td')[$indexOfPressure];
            if (!isset($elem)){
                $has_pressure = false;
                break;
            } else{
                $pressureByWholeDay[] = $elem->text();
                $indexOfPressure += 11;
                //$has_pressure = false;
            }
        }
        return ((new Diary))->average($pressureByWholeDay, true);
    }

    function Night($document){
        $indexOfPressure = 7;
        $pressureByWholeDay = array();
        $newDay = false;
        $has_pressure = true;
        while($has_pressure) {
            $elem = $document->find('td')[$indexOfPressure];
            if (!isset($elem)){
                $has_pressure = false;
                break;
            } else{
                $pressureByWholeDay[] = $elem->text();
                $indexOfPressure += 11;
                //$has_pressure = false;
            }
        }
        return ((new Diary))->average($pressureByWholeDay, true);
    }

    function DayByDay($document){
        $indexOfPressure = 2;
        $pressureByTheDay = array();
        $WholePressureInTheDays = array();
        $newDay = false;
        $has_pressure = true;
        while($has_pressure) {
            $elem = $document->find('td')[$indexOfPressure];
            if (!isset($elem)){
                $has_pressure = false;
                break;
            } else{
                $pressureByTheDay[] = $elem->text();
                //$indexOfPressure += 5;
                if($newDay){
                    $indexOfPressure += 6;
                    $WholePressureInTheDays[] = ((new Diary))->average($pressureByTheDay);
                    unset($pressureByTheDay);
                } else{
                    $indexOfPressure += 5;
                }

                $newDay = !$newDay;
                //$has_pressure = false;
            }
        }
        return $WholePressureInTheDays;
    } 
}

class Cloud extends Diary{
    function initCloud($document){
        $dullTimes = 0; $sunclTimes = 0; $suncTimes = 0; $sunTimes = 0;
        $elems = $document->find('img.label_icon.label_small.screen_icon');
        foreach($elems as $image){
            $imgSrc = $image->getAttribute("src");
            if(strstr($imgSrc, "dull")){
                $dullTimes++;
            }
            elseif(strstr($imgSrc, "suncl.png")){
                $sunclTimes++;
            }
            elseif(strstr($imgSrc, "sunc.png")){
                $suncTimes++;
            }
            elseif(strstr($imgSrc, "sun.png")){
                $sunTimes++;
            }
        }
        $cloudByMonth = array($sunTimes, $suncTimes, $sunclTimes, $dullTimes);
        return $cloudByMonth;
    }

}

class Weather extends Diary{
    function initWeather($document){
        $rainTimes = 0; $snowTimes = 0; $stormTimes = 0;
        $elems = $document->find('img.label_icon.label_small.screen_icon');
        foreach($elems as $image){
            $imgSrc = $image->getAttribute("src");
            if(strstr($imgSrc, "rain")){
                $rainTimes++;
            }
            elseif(strstr($imgSrc, "snow")){
                $snowTimes++;
            }
            elseif(strstr($imgSrc, "storm")){
                $stormTimes++;
            }
        }
        $weathersByMonth = array($rainTimes, $snowTimes, $stormTimes);
        return $weathersByMonth;
    }
}
?>