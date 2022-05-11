var tooltip = document.getElementById('myTooltip');
var copyText = document.getElementById('couponCode');
function myFunction() {
	copyText.select();
	copyText.setSelectionRange(0, 99999);
	document.execCommand('copy');
	tooltip.innerHTML = 'Copied: ' + copyText.value;
}
function outFunc() {
	tooltip.innerHTML = 'Copy to clipboard';
}

// Close
var closebtns = document.getElementsByClassName(
	'close'
); /* Get all elements with class="close" */
var i;
/* Loop through the elements, and hide the parent, when clicked on */
for (i = 0; i < closebtns.length; i++) {
	closebtns[i].addEventListener('click', function () {
		this.parentElement.style.display = 'none';
	});
}