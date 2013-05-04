$('form').submit(function (e){
	var validFile = true;
	var filestring = $("input[name=file]").val();
	var fileExtension = filestring.substr(filestring.lastIndexOf(".") + 1);
	if (fileExtension == "php"){
		document.getElementById("inputFileError").innerHTML = "";
	}
	else{
		$("input[name=file]").val("");
		document.getElementById("inputFileError").innerHTML = "Incorrect file.you must upload a php file";
		validFile = false;
		
	}
	var validCheckbox = false;
	var checkboxes = document.getElementsByName("checks[]");
	for (var i = 0; i < checkboxes.length; i++){
		if(checkboxes[i].checked){
			validCheckbox = true;
			break;
		}
	}
	if (validCheckbox == false){
		document.getElementById("tagsError").innerHTML = "You must select at least one parameter";
	}
	
	if (validCheckbox == false || validFile == false){
		e.preventDefault();
		return false;
	}
	else{
		return true;
	}
});
