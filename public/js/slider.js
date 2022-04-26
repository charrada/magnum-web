let slider = document.getElementById("slider");
let month = document.getElementById("plan");
var price = document.getElementById("price").innerText;



let toggle = document.getElementById("toggle");
let text = document.getElementById("period");

const DISCOUNT = 0.25;

var months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

month.innerText = "1";
document.getElementById('total').innerText=price; 
function discount() {
  text.innerHTML = "";

  if (toggle.checked) {
    text.innerHTML = "year";
    for (let i = 0; i < months.length; i++) {
        months[i] = months[i] - months[i];
    }
    listener();
  } else {
    text.innerHTML = "months";
   var months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
    listener();
  }
}

var listener = function () {
  window.requestAnimationFrame(function () {
    switch (slider.value) {
        case "1":
        month.innerHTML = Number(months[0]);   
        document.getElementById('total').innerText=price;        
        break;
        case "2":
        month.innerHTML = Number(months[1]);
        document.getElementById('total').innerText=price*2;
        break;
        case "3":
        month.innerHTML = Number(months[2]);
        document.getElementById('total').innerText=price*3;
        break;
        case "4":
        month.innerHTML = Number(months[3]);
        document.getElementById('total').innerText=price*4;
        break;
        case "5":
        month.innerHTML = Number(months[4]);
        document.getElementById('total').innerText=price*5;
        break;
        case "6":
        month.innerHTML = Number(months[5]);
        document.getElementById('total').innerText=price*6;
        break;
        case "7":
        month.innerHTML = Number(months[6]);
        document.getElementById('total').innerText=price*7;
        break;
        case "8":
        month.innerHTML = Number(months[7]);
        document.getElementById('total').innerText=price*8;
        break;
        case "9":
        month.innerHTML = Number(months[8]);
        document.getElementById('total').innerText=price*9;
        break;
        case "10":
        month.innerHTML = Number(months[9]);
        document.getElementById('total').innerText=price*10;
        break;
        case "11":
        month.innerHTML = Number(months[10]);
        document.getElementById('total').innerText=price*11;
        break;
        case "12":
        month.innerHTML = Number(months[11]);
        document.getElementById('total').innerText=price*12;
        break;
    }
  });
};

slider.addEventListener("mousedown", function () {
  listener();
  slider.addEventListener("mousemove", listener);
});
slider.addEventListener("mouseup", function () {
  slider.removeEventListener("mousemove", listener);
});

slider.addEventListener("keydown", listener);
slider.addEventListener("input", showSliderValue, false);

function showSliderValue() {
  month.innerHTML = slider.value;
  var bulletPosition = (slider.value /slider.max);
  month.style.left = (bulletPosition * 540) + "px";
}
