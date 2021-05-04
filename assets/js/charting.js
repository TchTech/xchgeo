//Wind . Rose o wind
/*var radar_elem = document.getElementById('Radar_graph');
var Radar_graph = new Chart(radar_elem, {
    type: 'radar',
    data: {
        labels: ['Северный', 'Северо-восточный', 'Восточный', 'Юго-восточный', 'Южный', 'Юго-западный', 'Западный', 'Северо-западный'],
        datasets: [{
            label: 'Роза ветров',
            data: wind_data,
            borderColor: 'rgb(54, 162, 235)',
        }]
    }, options: {
            scale: {
                ticks: {
                    stepSize: 1,
                    beginAtZero: true,
                    userCallback: function(label, index, labels) {
                        // when the floored value is the same as the value we have a whole number
                        if (Math.floor(label) === label) {
                            return label;
                }
                /*yAxes: [{

                }]
            }
        }
}
)*/
//alert(wind_data)

var optionsForRdr = {
    chart: {
      type: "radar"
    },
    series: [
      {
        name: "Количество",
        data: wind_data
      }
    ],
    xaxis: {
      categories: ['Северный', 'Северо-восточный', 'Восточный', 'Юго-восточный', 'Южный', 'Юго-западный', 'Западный', 'Северо-западный']
    }
  };
  
var Radar_graph = new ApexCharts(document.querySelector("#Radar_graph"), optionsForRdr);
Radar_graph.render();


var optionsForTm = {
    series: [{
      name: "Температура",
      data: temp_data
  }],
    chart: {
    //height: 350,
    type: 'line',
    colors: ['orange'],
    zoom: {
      enabled: false
    }
  },
  colors: ['#FFA500'],
  dataLabels: {
    enabled: false
  },
  grid: {
    show: true,
    borderColor: '#dcdcdc',
    strokeDashArray: 0,
    position: 'back',
    clipMarkers: true,
    xaxis: {
        lines: {
            show: true,
            offsetX: '0.5',
            offsetY: '0.5'
        }
    },
  },
  stroke: {
    curve: 'straight',
  },
  xaxis: {
    categories: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31],
  }
  };

  var Tm_line_graph = new ApexCharts(document.querySelector("#Tm_line_graph"), optionsForTm);
  Tm_line_graph.render();

  var optionsForCl = {
    colors: ['#a020f0'],
    chart: {
      type: "bar"
    },
    series: [
      {
        name: "Количество",
        data: cloud_data
      }
    ],
    xaxis: {
      categories: [
        'Ясно', 'Малооблачно', 'Облачно', 'Пасмурно'
      ]
    }
  };

  var Cl_bar_graph = new ApexCharts(document.querySelector("#Cl_bar_graph"), optionsForCl);
  Cl_bar_graph.render();

var optionsForPr = {
    series: [{
      name: "Давление",
      data: pr_data
  }],
    chart: {
    //height: 350,
    type: 'line',
    zoom: {
      enabled: false
    }
  },
  colors: ['#00008B'],
  dataLabels: {
    enabled: false
  },

  stroke: {
    curve: 'straight'
  },
  grid: {
    show: true,
    borderColor: '#dcdcdc',
    strokeDashArray: 0,
    position: 'back',
    clipMarkers: true,
    xaxis: {
        lines: {
            show: true,
            offsetX: '0.5',
            offsetY: '0.5'
        }
    },
},
  xaxis: {
    categories: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31],
  }
  };

  var Pr_line_graph = new ApexCharts(document.querySelector("#Pr_line_graph"), optionsForPr);
  Pr_line_graph.render();

  var optionsForWe = {
    colors: ['#0078cb'],
    chart: {
      type: "bar"
    },
    series: [
      {
        name: "Количество",
        data: we_data
      }
    ],
    xaxis: {
      categories: ['Дождь', 'Снег', 'Гроза']
    }
  };

  var We_bar_graph = new ApexCharts(document.querySelector("#We_bar_graph"), optionsForWe);
  We_bar_graph.render();

/*// temp . temperature day by day
var tm_line_elem = document.getElementById('Tm_line_graph');
var Tm_line_graph = new Chart(tm_line_elem, {
    type: 'line',
    data: {
        labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30'],
        datasets: [{
            label: 'Температура',
            data: temp_data,
            backgroundColor: 'rgb(255, 157, 65)',
            borderColor: 'rgb(254, 138, 78)',
        }]
    },
    options: {
    scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true
            }
        }]
    }
}
}
)
//clouding . whole
var cl_bar_elem = document.getElementById('Cl_bar_graph');
var Cl_bar_graph = new Chart(cl_bar_elem, {
    type: 'bar',
    data: {
        labels: ['Ясно', 'Малооблачно', 'Облачно', 'Пасмурно'],
        datasets: [{
            label: 'Облачность',
            data: cloud_data,
            backgroundColor: ['rgb(244, 237, 123)',
                              'lightblue',
                              'rgb(102, 148, 246)',
                              'rgb(194, 122, 192)'],
            borderColor: 'rgb(234, 226, 117)',
        }]
    },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
}
)
// Pressure . line day by day
var pr_line_elem = document.getElementById('Pr_line_graph');
var Pr_line_graph = new Chart(pr_line_elem, {
    type: 'line',
    data: {
        labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30'],
        datasets: [{
            label: 'Давление',
            data: pr_data,
            backgroundColor: 'rgb(209, 160, 204)',
            borderColor: 'rgb(158, 79, 165)',
        }]
    },
    options: {
    scales: {
        yAxes: [{
            ticks: {
                beginAtZero: false
            }
        }]
    }
}
}
)
// weather . whole day bar
var we_bar_elem = document.getElementById('We_bar_graph');
var We_bar_graph = new Chart(we_bar_elem, {
    type: 'bar',
    data: {
        labels: ['Дождь', 'Снег', 'Гроза'],
        datasets: [{
            label: 'Осадки',
            data: we_data,
            backgroundColor: 'purple',
            borderColor: 'gray',
        }]
    },
    options: {
    scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true
            }
        }]
    }
}
}
)
console.log(result)
*/