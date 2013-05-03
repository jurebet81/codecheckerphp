function filechange(input){
	var filestring = input.value;
	var fileExtension = filestring.substr(filestring.lastIndexOf(".") + 1);
	if (fileExtension == "php"){
		document.getElementById("inputFileError").innerHTML = "";
	}
	else{
		input.value = "";
		document.getElementById("inputFileError").innerHTML = "Archivo incorrecto! Debe ser PHP";
	}
}
$('form').submit(function (e){
	var checkboxes = document.getElementsByName("checks[]");
	for (var i = 0; i < checkboxes.length; i++){
		if(checkboxes[i].checked){
			return true;
		}
	}
	document.getElementById("tagsError").innerHTML = "You must select at least one parameter";
	e.preventDefault();
	return false;
});

