function controlTag(e)
{
	tecla = (document.all) ? e.keyCode : e.which;
	if (tecla == 8) return true; 
	else if (tecla == 0 || tecla == 9) return true;
	patron =/[0-9]/;
	n = String.fromCharCode(tecla);
	return patron.test(n);
}

function fntiIdentificacionValidate(txtString)
{
	var stringIdentificacion = new RegExp(/^([vVjJeE])+([0-9]{6,9})+$/);
	if (stringIdentificacion.test(txtString) == false) {
		return false;	
	} else {
		return true;
	}
}

function testText(txtString)
{
	var stringText = new RegExp(/^[a-zA-ZÑñÁáÉéÍíÓóÚú\s]+$/);
	if (stringText.test(txtString)) {
		return true;
	} else {
		return false;
	}
}

function testEntero(intCant)
{
	var intCantidad = new RegExp(/^([+0-9])*$/);
	if (intCantidad.test(intCant)) {
		return true;
	} else {
		return false;
	}
}

function fntEmailValidate(email)
{
	var stringEmail = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
	if (stringEmail.test(email) == false) {
		return false;	
	} else {
		return true;
	}
}


// funcines que validaran los inputs
function fntValidIdentificacion()
{
	let validIdentificacion = document.querySelectorAll(".validIdentificacion");
	validIdentificacion.forEach(function(validIdentificacion) {
		validIdentificacion.addEventListener('keyup', function() {
			let inputValue = this.value;
			if(!fntiIdentificacionValidate(inputValue)) {
				this.classList.add('is-invalid');
			} else {
				this.classList.remove('is-invalid');
			}
		})
	})
}

function fntValidText()
{
	let validText = document.querySelectorAll(".validText");
	validText.forEach(function(validText) {
		validText.addEventListener('keyup', function() {
			let inputValue = this.value;
			if(!testText(inputValue)) {
				this.classList.add('is-invalid');
			} else {
				this.classList.remove('is-invalid');
			}
		})
	})
}

function fntValidNumber()
{
	let validNumber = document.querySelectorAll(".validNumber");
	validNumber.forEach(function(validNumber) {
		validNumber.addEventListener('keyup', function() {
			let inputValue = this.value;
			if(!testEntero(inputValue)) {
				this.classList.add('is-invalid');
			} else {
				this.classList.remove('is-invalid');
			}
		})
	})
}

function fntValidEmail()
{
	let validEmail = document.querySelectorAll(".validEmail");
	validEmail.forEach(function(validEmail) {
		validEmail.addEventListener('keyup', function() {
			let inputValue = this.value;
			if(!fntEmailValidate(inputValue)) {
				this.classList.add('is-invalid');
			} else {
				this.classList.remove('is-invalid');
			}
		})
	})
}

window.addEventListener('load', function() {
	fntValidIdentificacion();
	fntValidText();
	fntValidNumber();
	fntValidEmail();
}, false);


function openModalSupport(urlImg)
{

	var modal = document.getElementById('myModal');

	// Get the image and insert it inside the modal - use its "alt" text as a caption
	var modalImg = document.getElementById("img01");
	var captionText = document.getElementById("caption");
	
	modal.style.display = "block";
	modalImg.src = urlImg;
	

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks on <span> (x), close the modal
	
	  modal.style.display = "flex";
	

}