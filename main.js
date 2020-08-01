const inputs = document.querySelectorAll(".input");

function validateForm() {
	var password = document.forms["signup-form"]["password"].value;
	var confirm_password = document.forms["signup-form"]["confrim_password"].value;
	var first_name = document.forms["signup-form"]["first_name"].value;
	var second_name = document.forms["signup-form"]["second_name"].value;
	var email = document.forms["signup-form"]["email"].value;
	var ID_Number = document.forms["signup-form"]["email"].value;

    if ( password != confirm_password) {
        alert("The password isn't a match");
        return false;
	}
	if (( first_name == null || first_name == "") || ( second_name == null || second_name == "") ){
        alert("The name part should be filled");
        return false;
	}
	if ( password != confirm_password) {
        alert("The password isn't a match");
        return false;
	}
	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))
	{
	  return (true)
	}
	  alert("You have entered an invalid email address!")
	  return (false)
	}


function onlyOne(checkbox) {
    var checkboxes = document.getElementsByName('check')
    checkboxes.forEach((item) => {
        if (item !== checkbox) item.checked = false
    })
}

function addcl(){
	let parent = this.parentNode.parentNode;
	parent.classList.add("focus");
}

function remcl(){
	let parent = this.parentNode.parentNode;
	if(this.value == ""){
		parent.classList.remove("focus");
	}
}


inputs.forEach(input => {
	input.addEventListener("focus", addcl);
	input.addEventListener("blur", remcl);
});
