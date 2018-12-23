//FUNCTIONS

/*
var randomScalingFactor = function() {
      return Math.round(Math.random() * 100);
    };
document.getElementById('tryMeBtn').addEventListener('click', function() {
      deliveredConfig.data.datasets.forEach(function(dataset) {
        dataset.data = dataset.data.map(function() {
          return randomScalingFactor();
        });
      });
      window.myPie.update();
    });

*/


/*CHART FUNCTIONS*/

function deleteAllDatasets(chartId, totalDatasets){
    for(var i = 0; i < totalDatasets; i++ ){
        removeDataset(chartId);
      }   
}

//Colors are generated randomly
function addArrayDataset(chart, labelArray, dataArray) {
    chart.data.labels = labelArray;
      $.each(dataArray, function( index, value ) {
        chart.data.datasets.forEach((dataset) => {
          var hexColor = getRandomColor();
          var darkerHexColor = hexColorLuminance(hexColor, -0.2)
          dataset.backgroundColor.push(hexColor);
          dataset.borderColor.push(darkerHexColor);
          dataset.hoverBackgroundColor.push(darkerHexColor);
          dataset.data.push(value);
        });
      });
    chart.update();
}

function addDataset(chart, label, data, bgColor, borderColor, hoverBgColor) {
    chart.data.labels.push(label);
    chart.data.datasets.forEach((dataset) => {
        dataset.backgroundColor.push(bgColor);
        dataset.borderColor.push(borderColor);
        dataset.hoverBackgroundColor.push(hoverBgColor);
        dataset.data.push(data);
    });
    chart.update();
}


function removeDataset(chart) {
    chart.data.labels.pop();
    chart.data.datasets.forEach((dataset) => {
        dataset.backgroundColor.pop();
        dataset.borderColor.pop();
        dataset.hoverBackgroundColor.pop();
        dataset.data.pop();
    });
    chart.update();
}

//HEX
function getRandomColor() {
  var letters = '0123456789ABCDEF';
  var color = '#';
  for (var i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}

//To see result use .g in variable that holds return (Ex: rgbColor.g)
function hexToRgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}



//https://www.sitepoint.com/javascript-generate-lighter-darker-color/
function hexColorLuminance(hex, lum) {

    // validate hex string
    hex = String(hex).replace(/[^0-9a-f]/gi, '');
    if (hex.length < 6) {
        hex = hex[0]+hex[0]+hex[1]+hex[1]+hex[2]+hex[2];
    }
    lum = lum || 0;

    // convert to decimal and change luminosity
    var rgb = "#", c, i;
    for (i = 0; i < 3; i++) {
        c = parseInt(hex.substr(i*2,2), 16);
        c = Math.round(Math.min(Math.max(0, c + (c * lum)), 255)).toString(16);
        rgb += ("00"+c).substr(c.length);
    }

    return rgb;
}

