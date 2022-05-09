let slider = document.getElementById("slider");
let month = document.getElementById("plan");
var price = document.getElementById("price").innerText;




let toggle = document.getElementById("toggle");
let text = document.getElementById("period");

const DISCOUNT = 0.25;

var months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

month.innerText = "1";
document.getElementById('total').innerText=Number(price).toFixed(2);  
function discount() {
 
}

var listener = function () {
  window.requestAnimationFrame(function () {
      document.getElementById("input").disabled = false;
      document.getElementById("toggle").value = "Redeem coupon";
      document.getElementById("input").value = "";
      document.getElementById("toggle").disabled = false;
    switch (slider.value) {
        case "1":
        month.innerHTML = Number(months[0]);   
        document.getElementById('total').innerText=Number(price).toFixed(2);        
        break;
        case "2":
        month.innerHTML = Number(months[1]);
        document.getElementById('total').innerText=Number(price*2).toFixed(2);
        break;
        case "3":
        month.innerHTML = Number(months[2]);
        document.getElementById('total').innerText=Number(price*3).toFixed(2);
        break;
        case "4":
        month.innerHTML = Number(months[3]);
        document.getElementById('total').innerText=Number(price*4).toFixed(2);
        break;
        case "5":
        month.innerHTML = Number(months[4]);
        document.getElementById('total').innerText=Number(price*5).toFixed(2);
        break;
        case "6":
        month.innerHTML = Number(months[5]);
        document.getElementById('total').innerText=Number(price*6).toFixed(2);
        break;
        case "7":
        month.innerHTML = Number(months[6]);
        document.getElementById('total').innerText=Number(price*7).toFixed(2);
        break;
        case "8":
        month.innerHTML = Number(months[7]);
        document.getElementById('total').innerText=Number(price*8).toFixed(2);;
        break;
        case "9":
        month.innerHTML = Number(months[8]);
        document.getElementById('total').innerText=Number(price*9).toFixed(2);
        break;
        case "10":
        month.innerHTML = Number(months[9]);
        document.getElementById('total').innerText=Number(price*10).toFixed(2);
        break;
        case "11":
        month.innerHTML = Number(months[10]);
        document.getElementById('total').innerText=Number(price*11).toFixed(2);
        break;
        case "12":
        month.innerHTML = Number(months[11]);
        document.getElementById('total').innerText=Number(price*12).toFixed(2);
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
function expand() {
  switcher.className = 'expanded';
  setTimeout(function() {
    input.focus();
  }, 500);
}

function collapse() {
  switcher.className = 'collapsed';
  input.blur();
}

toggle.onclick = expand;

input.onblur = function() {
  setTimeout(collapse, 100);
}

buttonWithText.onsubmit = function(e) {
  e.preventDefault();
//  alert("New username: " + input.value);
  collapse();
}

