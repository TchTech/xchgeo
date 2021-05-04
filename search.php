<?php
require_once "scripts/Scrap.php";

$diaryUrl = htmlspecialchars($_POST["url"]);
$parameter =  htmlspecialchars($_POST["data-parameter"]);
//function main($diaryUrl, $parameter){
    $diary = new Diary;//->setDoc($_POST["url"]);
    $diary->setDoc($diaryUrl);
    $doc = $diary->getDoc();
    $temperature = ((new Temperature))->initTemperature($doc);
    //$temperature = Diary::initTemperature($diaryUrl);
    $pressure = ((new Pressure))->initPressure($doc);
    $wind = ((new Wind))->initWind($doc);
    $weather = ((new Weather))->initWeather($doc);
    $cloud = ((new Cloud))->initCloud($doc);
    /*print_r($temperature);
    print_r($pressure);
    print_r($wind);
    print_r($weather);
    print_r($cloud);*/
//}
$unicode_chars = [
    ' ', //temperature
    ' ', //wind
    ' ', //pressure
    ' ', //weather
    ' ', //cloud
    ' ', //all info
];

$clean_parameter = str_replace($unicode_chars, "", $parameter);
switch($clean_parameter){
    case "Температура":
        $temperature_data_N = $temperature["MiddleNightTemperature"];
        $temperature_data_D = $temperature["MiddleDayTemperature"];
        $temperature_data_DBD = "[" . implode(", ", $temperature["MiddleDayByDayTemperature"]) . "]";
        $pressure_data_DBD = $pressure_data_N = $pressure_data_D = $wind_data_DIR = $wind_data_SPD = $we_data = $cloud_data = "null";
        break;
    case "Ветер":
        $wind_data_DIR = "[" . implode(", ", $wind["DirectionsByMonth"]) . "]";
        $wind_data_SPD = $wind["MiddleSpeedByMonth"];
        $pressure_data_DBD = $pressure_data_N = $pressure_data_D = $temperature_data_DBD =$temperature_data_N = $temperature_data_D = $we_data = $cloud_data = "null";
        break;
    case "Давление":
        $pressure_data_N = $pressure["MiddleNightPressure"];
        $pressure_data_D = $pressure["MiddleDayPressure"];
        $pressure_data_DBD = "[" . implode(", ", $pressure["MiddleDayByDayPressure"]) . "]";
        $wind_data_DIR = $wind_data_SPD = $temperature_data_DBD = $temperature_data_N = $temperature_data_D = $we_data = $cloud_data = "null";
        break;
    case "Погода":
        $we_data = "[" . implode(", ", $weather) . "]";
        $wind_data_DIR = $wind_data_SPD = $pressure_data_DBD = $pressure_data_N = $pressure_data_D = $temperature_data_DBD = $temperature_data_N = $temperature_data_D = $cloud_data = "null";
        break;
    case "Облачность":
        $cloud_data = "[" . implode(", ", $cloud) . "]";
        $wind_data_DIR = $wind_data_SPD = $pressure_data_DBD = $pressure_data_N = $pressure_data_D = $temperature_data_DBD = $temperature_data_N = $temperature_data_D = $we_data = "null";
        break;
    case "Вся информация":
        $temperature_data_DBD = "[" . implode(", ", $temperature["MiddleDayByDayTemperature"]) . "]";
        $temperature_data_N = $temperature["MiddleNightTemperature"];
        $temperature_data_D = $temperature["MiddleDayTemperature"];
        $pressure_data_DBD = "[" . implode(", ", $pressure["MiddleDayByDayPressure"]) . "]";
        $pressure_data_N = $pressure["MiddleNightPressure"];
        $pressure_data_D = $pressure["MiddleDayPressure"];
        $wind_data_DIR = "[" . implode(", ", $wind["DirectionsByMonth"]) . "]";
        $wind_data_SPD = $wind["MiddleSpeedByMonth"];
        $we_data = "[" . implode(", ", $weather) . "]";
        $cloud_data = "[" . implode(", ", $cloud) . "]";
        break;
}

/*$temperature_data = "[" . implode(", ", $temperature["MiddleDayByDayTemperature"]) . "]";
$pressure_data = "[" . implode(", ", $pressure["MiddleDayByDayPressure"]) . "]";
//main($_POST["url"], $_POST["data-parameter"]);
$wind_data = "[" . implode(", ", $wind["DirectionsByMonth"]) . "]";
$we_data = "[" . implode(", ", $weather) . "]";
$cloud_data = "[" . implode(", ", $cloud) . "]";*/
echo "<!DOCTYPE html>
<html>

<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, shrink-to-fit=no\">
    <link rel=\"icon\" href=\"assets/img/logo-img.png\">
    <title>Поиск. XchronoGeo</title>
    <link rel=\"stylesheet\" href=\"assets/bootstrap/css/bootstrap.min.css\">
    <link rel=\"stylesheet\" href=\"https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;display=swap\">
    <link rel=\"stylesheet\" href=\"assets/fonts/material-icons.min.css\">
    <link rel=\"stylesheet\" href=\"assets/css/Features-Boxed.css\">
    <link rel=\"stylesheet\" href=\"assets/css/Footer-Basic.css\">
    <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css\">
    <link rel=\"stylesheet\" href=\"assets/css/styles.css\">
</head>
<body><script>
// data
var date_title = '" . $diary->getDateTitle($doc) . "'
var night_pressure_data =  " . $pressure_data_N ."
var days_pressure_data = " . $pressure_data_D ."
var days_temp_data = " . $temperature_data_D ."
var night_temp_data = ". $temperature_data_N ."
var month_wind_speed_data = " . $wind_data_SPD ."
var wind_data = " . $wind_data_DIR . "
var temp_data = " . $temperature_data_DBD . "
var cloud_data = " . $cloud_data ."
var pr_data = " . $pressure_data_DBD ."
var we_data = " . $we_data ."
var parameter = '" . $clean_parameter ."'
</script>
<script src='https://cdn.jsdelivr.net/npm/apexcharts'></script>
<script src='https://www.jsdelivr.com/package/npm/chart.js'></script>
<script href='assets/js/charting.js'></script>
    <nav class=\"navbar navbar-light navbar-expand-md d-xl-flex\" style=\"height: 100px;background-color: orange;\">
        <div class=\"container-fluid\"><img class=\"d-flex justify-content-center\" data-bs-hover-animate=\"tada\" src=\"assets/img/logo-img.png\" style=\"width: 100px;height: 100px;\" alt=\"ГеоСкан\"><button data-toggle=\"collapse\" class=\"navbar-toggler\" data-target=\"#\"><span class=\"sr-only\">Toggle navigation</span><span class=\"navbar-toggler-icon\"></span></button>
            <div
                class=\"collapse navbar-collapse\">
                <ul class=\"nav navbar-nav\">
                    <li class=\"nav-item\" role=\"presentation\"><a class=\"nav-link active nav-item\" href=\"index.html\" style=\"font-size: 25px;color: white;padding: 20px;\">Главная</a></li>
                    <li class=\"nav-item\" role=\"presentation\"><a class=\"nav-link\" href=\"help.html\" style=\"font-size: 25px;color: white;padding: 20px;\">Помощь</a></li>
                    <li class=\"nav-item\" role=\"presentation\"></li>
                </ul>
        </div>
        </div>
    </nav>
    <main>
        <div class=\"d-xl-flex justify-content-xl-end\" style=\"padding: 10px;\"></div><link href=\"https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css\" rel=\"stylesheet\"/>
<script defer src=\"https://use.fontawesome.com/releases/v5.0.13/js/all.js\"></script>
<link href=\"css/fontawesome/css/all.css\" rel=\"stylesheet\">
<link href=\"https://use.fontawesome.com/releases/v5.0.13/css/all.css\" rel=\"stylesheet\">
<script src='https://kit.fontawesome.com/a076d05399.js'></script><h1 class=\"d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex justify-content-center justify-content-sm-center justify-content-md-center justify-content-lg-center justify-content-xl-center\" style=\"border: 2px solid #ccc; font-size: 40px;margin: 10px;color: lightgreen;border-width: thin medium thick 10px;background-color: white\"><span style=\"   background: -webkit-linear-gradient(left, #FFE000, #799F0C);
background: -o-linear-gradient(right, #FFE000, #799F0C);
background: -moz-linear-gradient(right, #FFE000, #799F0C);
background: linear-gradient(to right, #FFE000 , #799F0C); 
-webkit-background-clip: text;
-webkit-text-fill-color: transparent;\">X c h r o n o  g e o</span></h1>
        <h1 class=\"d-md-flex d-lg-flex d-xl-flex justify-content-md-center justify-content-lg-center justify-content-xl-center\" id=\"heading\">Вставьте ссылку на&nbsp;<a href=\"https://www.gismeteo.ru/diary/\">дневник</a></h1>
        <form method='post' class=\"d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex justify-content-sm-center justify-content-md-center justify-content-lg-center justify-content-xl-center\"><input class=\"border rounded-0 border-dark shadow form-control d-md-flex d-xl-flex justify-content-md-center justify-content-xl-center\" type=\"url\" id=\"url-input\" style=\"background-color: white;\" autocomplete=\"on\" inputmode=\"url\" name=\"url\" placeholder=\"https://www.gismeteo.ru/diary/\"
                required=\"\"><select id=\"select-data\" class=\"select-data\" name=\"data-parameter\">
  <option>&#xf02d; Вся информация</option>
  <option>&#xf2c9; Температура</option>
  <option>&#xf14e; Ветер</option>
  <option>&#xf0e4; Давление</option>
  <option>&#xf0e7; Погода</option>
  <option>&#xf0c2; Облачность</option>
</select><button class=\"btn btn-primary document-capitalize border rounded-0\" type=\"submit\" style=\"margin-left: 10px;height: 50px;\"><strong>Получить</strong></button></form>
    </main>
    <div class=\"d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex justify-content-center justify-content-sm-center justify-content-md-center justify-content-lg-center justify-content-xl-center\" style=\"margin-top: 15px;\">
    <button type=\"button\" class=\"btn btn-info infoPopover\" data-toggle=\"popover\" data-placement=\"bottom\" title=\"Краткое описание.\" data-html=\"true\" data-content=\"1. Перейдите по ссылке <a href='https://www.gismeteo.ru/diary/'>https://www.gismeteo.ru/diary/</a>. <br>2. Выберите ваш регион и желаемую дату, нажмите Получить дневник. <br>3. Скопируйте получившуюся ссылку и вставьте в текстовое поле на этом сайте. <br>4. Выберите подходящие для вас параметры в падающем окне списка.<br>5. Нажмите кнопку Получить.\" style=\"background-image: url(assets/img/baseline_info_black_48.png); background-color: #eee; background-size: cover; width: 45px;height: 45px;\" ></button>
    </div>
<script src=\"https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js\" integrity=\"sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==\" crossorigin=\"anonymous\"></script>
<script>
   $(function(){
      $(\".infoPopover\").popover();
   });
</script>
    <hr>
    <div>
    <h1 class='d-xl-flex justify-content-xl-center' id='date-title' style='margin-bottom: 15px; margin-top: 25px; background: -webkit-linear-gradient(#f12711, #f5af19);  -webkit-background-clip: text;  -webkit-text-fill-color: transparent;'>title<br /></h1>
  <script>
  document.getElementById('date-title').innerHTML = date_title + '(' + parameter + ')'
  </script>
        <div class=\"container\">
            <div class=\"row\">
                <div class=\"col-md-12\">
                    <h1 class=\"d-xl-flex justify-content-xl-center\" style=\"margin: 25px;background-color: rgb(238,244,247);\"><a href=\"#graph-items\">Графическое</a>&nbsp;и&nbsp;<a href=\"#text-items\">текстовое</a>&nbsp;представление данных:</h1>
                </div>
            </div>
            <div class=\"row\">
                <div class=\"col-md-6 d-xl-flex align-items-xl-center\">
                    <div class=\"mb-auto\">
                        <ul class=\"nav nav-tabs\" id=\"graph-items\">
                            <li class=\"nav-item\"><a class=\"nav-link active\" id='wind-graph-tab' role=\"tab\" data-toggle=\"tab\" href=\"#tab-1\">Роза ветров</a></li>
                            <li class=\"nav-item\"><a class=\"nav-link\" id='temp-graph-tab' role=\"tab\" data-toggle=\"tab\" href=\"#tab-2\">Температура</a></li>
                            <li class=\"nav-item\"><a class=\"nav-link\" id='cloud-graph-tab' role=\"tab\" data-toggle=\"tab\" href=\"#tab-3\">Облачность</a></li>
                            <script>
                                if(cloud_data === null){
                                    graph_cloud_tab_elem = document.getElementById('cloud-graph-tab')
                                    graph_cloud_tab_elem.remove()
                                    graph_cloud_elem = document.getElementById('tab-3')
                                    graph_cloud_elem.remove()
                                }
                            </script>
                            <li class=\"nav-item\"><a class=\"nav-link\" id='pressure-graph-tab' role=\"tab\" data-toggle=\"tab\" href=\"#tab-4\">Давление</a></li>
                            <li class=\"nav-item\"><a class=\"nav-link\" id='weather-graph-tab' role=\"tab\" data-toggle=\"tab\" href=\"#tab-5\">Осадки</a></li>
                            <script>
                            if(we_data === null){
                                graph_we_tab_elem = document.getElementById('weather-graph-tab')
                                graph_we_tab_elem.remove()
                                graph_we_elem = document.getElementById('tab-5')
                                graph_we_elem.remove()
                            }</script>
                        </ul>
                        <div class=\"tab-content\" id=\"graph-contents\">
                            <div class=\"tab-pane active\" role=\"tabpanel\" id=\"tab-1\" style=\"width: 540px; height: 300px;\"><div id=\"Radar_graph\" style=\"width: 540px; height: 300px;\"></div></div>
                            <div class=\"tab-pane\" role=\"tabpanel\" id=\"tab-2\" style=\"width: 540px; height: 300px;\"><div id=\"Tm_line_graph\" style=\"width: 540px; height: 300px;\"></div></div>
                            <div class=\"tab-pane\" role=\"tabpanel\" id=\"tab-3\" style=\"width: 540px; height: 300px;\"><div id=\"Cl_bar_graph\" style=\"width: 540px; height: 300px;\"></div></div>
                            <div class=\"tab-pane\" role=\"tabpanel\" id=\"tab-4\" style=\"width: 540px; height: 300px;\"><div id=\"Pr_line_graph\" style=\"width: 540px; height: 300px;\"></div></div>
                            <div class=\"tab-pane\" role=\"tabpanel\" id=\"tab-5\" style=\"width: 540px; height: 300px;\"><div id=\"We_bar_graph\" style=\"width: 540px; height: 300px;\"></div></div>
                        </div>
                    </div>
                </div>
                <div id='text-items' class=\"col d-xl-flex justify-content-xl-end\">
                    <div>
                        <ul class=\"nav nav-tabs\" id=\"document-items\">
                            <li class=\"nav-item\"><a class=\"nav-link active\" id='nav-pressure' role=\"tab\" data-toggle=\"tab\" href=\"#tab-7\">Давление</a></li>
                            <li class=\"nav-item\"><a class=\"nav-link\" id='nav-temperature' role=\"tab\" data-toggle=\"tab\" href=\"#tab-9\">Температура</a></li>
                            <li class=\"nav-item\"><a class=\"nav-link\" id='nav-wind' role=\"tab\" data-toggle=\"tab\" href=\"#tab-10\">Ветер</a></li>
                        </ul>
                        <div class=\"tab-content\" id=\"document-contents\" style=\"margin-top: 25px;\">
                            <div class=\"tab-pane active\" role=\"tabpanel\" id=\"tab-7\">
                                <div class=\"card\">
                                    <div class=\"card-body\">
                                        <h4 class=\"card-title\">Давление.</h4>
                                        <h6 class=\"document-muted card-subtitle mb-2\">Средние данные за месяц.</h6><p class=\"card-document\">Сутки №<select id=\"pr-day-select\" onchange=\"changeSelectedDay('pr-day-select', 'pr-day-data')\"><optgroup label=\"Сутки №...\"><option selected>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option><option>24</option><option>25</option><option>26</option><option>27</option><option>28</option><option>29</option><option>30</option><option>31</option></optgroup></select> -
    <a id=\"pr-day-data\">0</a> мм рт.ст.<br /><a id=\"pr-mnth-data\">0</a> мм рт.ст. - средний показатель за месяц.<br /><br /><a id=\"pr-night-data\">0</a> мм рт.ст. - средний ночной показатель за месяц.<br /><br /><a id=\"pr-days-data\">0</a> мм рт. ст. - средний дневной показатель за месяц.<br /></p>
<script>
if(pr_data !== null && night_pressure_data !== null && days_pressure_data !== null){
    var arr_sum = 0
    pr_data.forEach(function(item){
        arr_sum = arr_sum + item  
    })
    document.getElementById(\"pr-mnth-data\").innerHTML = Math.round(arr_sum/pr_data.length)
    document.getElementById(\"pr-days-data\").innerHTML = days_pressure_data
    document.getElementById(\"pr-night-data\").innerHTML = night_pressure_data
}else{
    nav_pr_elem = document.getElementById('nav-pressure')
    nav_pr_elem.remove()
    card_pr_elem = document.getElementById('tab-7')
    card_pr_elem.remove()
    graph_tab_pr_elem = document.getElementById('pressure-graph-tab')
    graph_tab_pr_elem.remove()
    graph_pr_elem = document.getElementById('tab-4')
    graph_pr_elem.remove()
}
</script></div>
                                </div>
                            </div>
                            <div class=\"tab-pane\" role=\"tabpanel\" id=\"tab-9\">
                                <div class=\"card\">
                                    <div class=\"card-body\">
                                        <h4 class=\"card-title\">Температура.</h4>
                                        <h6 class=\"document-muted card-subtitle mb-2\">Средние данные за месяц.</h6><p class=\"card-document\">Сутки №<select onchange=\"changeSelectedDay('temp-day-select', 'temp-day-data')\" id=\"temp-day-select\"><optgroup label=\"Сутки №...\"><option selected>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option><option>24</option><option>25</option><option>26</option><option>27</option><option>28</option><option>29</option><option>30</option><option>31</option></optgroup></select>    - <a id=\"temp-day-data\">0</a>°C<br /><a id=\"temp-mnth-data\">0</a>°C - средний показатель за месяц.<br /><br /><a id=\"temp-night-data\">0</a>°C - средний ночной показатель за месяц.<br /><br /><a id=\"temp-days-data\">0</a>°C - средний дневной показатель за месяц.<br /></p></div>
                                </div>
                            </div>
<script>
if(days_temp_data != null && night_temp_data != null && temp_data != null){    
var arr_sum = 0
    temp_data.forEach(function(item){
        arr_sum = arr_sum + item  
        //console.log(arr_sum)
    })
    document.getElementById(\"temp-mnth-data\").innerHTML = Math.round(arr_sum/temp_data.length)
    document.getElementById(\"temp-days-data\").innerHTML = days_temp_data
    document.getElementById(\"temp-night-data\").innerHTML = night_temp_data
}else{
    nav_temp_elem = document.getElementById('nav-temperature')
    nav_temp_elem.remove()
    card_temp_elem = document.getElementById('tab-9')
    card_temp_elem.remove()
    graph_tab_temp_elem = document.getElementById('temp-graph-tab')
    graph_tab_temp_elem.remove()
    graph_temp_elem = document.getElementById('tab-2')
    graph_temp_elem.remove()

}</script>
                            <div class=\"tab-pane\" role=\"tabpanel\" id=\"tab-10\">
                                <div class=\"card\">
                                    <div class=\"card-body\">
                                        <h4 class=\"card-title\">Ветер.</h4>
                                        <h6 class=\"document-muted card-subtitle mb-2\">Средние данные за месяц.</h6><p class=\"card-document\"><a id=\"wind-spd-mnth-data\">2</a> м/с - средняя скорость ветра за месяц.</p></div>
                                </div>
                            </div>
                            <script>if(month_wind_speed_data != null){
                                document.getElementById(\"wind-spd-mnth-data\").innerHTML = month_wind_speed_data
                            }else{
                                nav_wind_elem = document.getElementById('nav-wind')
                                nav_wind_elem.remove()
                                card_wind_elem = document.getElementById('tab-10')
                                card_wind_elem.remove()
                                graph_tab_wind_elem = document.getElementById('wind-graph-tab')
                                graph_tab_wind_elem.remove()
                                graph_wind_elem = document.getElementById('tab-1')
                                graph_wind_elem.remove()
                            }</script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        switch(parameter){
            case 'Температура':
                document.getElementById(\"tab-9\").className = \"tab-pane active\";
                document.getElementById(\"tab-2\").className = \"tab-pane active\";
                break;
            case 'Ветер':
                document.getElementById(\"tab-10\").className = \"tab-pane active\";
                document.getElementById(\"tab-1\").className = \"tab-pane active\";
                break;
            case 'Давление':
                document.getElementById(\"tab-7\").className = \"tab-pane active\";
                document.getElementById(\"tab-4\").className = \"tab-pane active\";
                break;
            case 'Облачность':
                document.getElementById(\"tab-3\").className = \"tab-pane active\";
                break;
            case 'Погода':
                document.getElementById(\"tab-5\").className = \"tab-pane active\";
                break;
        }
    </script>
    <script href='assets/js/data-parameter.js'></script>
    <script src=\"assets/js/jquery.min.js\"></script>
    <script src=\"assets/bootstrap/js/bootstrap.min.js\"></script>
    <script src=\"assets/js/smart-forms.min.js\"></script>
    <script src=\"assets/js/bs-init.js\"></script>
    <script src=\"assets/js/charting.js\"></script>
    <script src=\"assets/js/texting.js\"></script>
    <hr style='margin-top: 50px;'>
    <div class='footer-basic'>
    <footer>
        <ul class='list-inline'>
            <li class='list-inline-item'><a href='index.html'>Главная</a></li>
            <li class='list-inline-item'><a href='help.html'>Помощь</a></li>
            <li class='list-inline-item'><a href='#'>О нас</a></li>
        </ul>
        <p class='copyright'>Xchronos © 2020</p>
    </footer>
</div>
</body>

</html>";
?>