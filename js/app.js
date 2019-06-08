function OpenRegModal(){
	var radioUser = document.querySelector('input[name="radioUser"]:checked');
	if(radioUser !== null)
	{
		if(radioUser.value == "poslodavac")
		{
			GetModal("modals.php?modal_id=new_employer");
		}
		else{
			GetModal("modals.php?modal_id=new_employee");
		}
	}
	else
	{
		alert("Odaberite vrstu korisnika!");
	}
}

function GetUserCats()
{
	var string = "";
	var inputCats = document.querySelector("#empCats");
	var cats = document.querySelectorAll("input[name='kategorija']");
	var catsChecked = document.querySelectorAll("input[name='kategorija']:checked");
	
	for(var i = 0; i < catsChecked.length; i++){
		if(catsChecked[i] != catsChecked[catsChecked.length-1])
		{
			string += catsChecked[i].value+", ";
		}
		else{
			string += catsChecked[i].value;
		}
	}

	if(string != '')
	{
		inputCats.setAttribute("value", string);
		cats.forEach(function(cat){
			cat.removeAttribute("required");
		});
	}
	
}

function RenderTitle(title)
{
	var name = document.querySelector("#empName");
	if(title.length > 25)
	{
		name.style.fontSize = "24px";
		name.style.marginTop = "10px";
		name.innerHTML = title;
	}
	else
	{
		name.style.marginTop = "5px";
		name.innerHTML = title;
	}
}

function TogglePassword()
{
	var pass = document.querySelector('#togglePassword');
	if(pass.type == 'password')
	{
		pass.type = 'text';
	}
	else
	{
		pass.type = 'password';
	}
}

function CheckGender(gender)
{
	var genderRadios = document.querySelectorAll('input[name="gender"]');
	if(gender == 'M')
	{
		genderRadios.forEach(function(radio){
			if(radio.value == 'M')
			{
				radio.setAttribute('checked', true);
			}
		});
	}
	else
	{
		genderRadios.forEach(function(radio){
			if(radio.value == 'Z')
			{
				radio.setAttribute('checked', true);
			}
		});
	}
}

function CheckCats(categories)
{
	var kategorijePolje = categories.split(", ");
	var cats = document.querySelectorAll("input[name='kategorija']");

	var checker = 0;

	kategorijePolje.forEach(function(kategorija){
		cats.forEach(function(cat){
				if(cat.value == kategorija)
				{
					cat.setAttribute('checked', true);
					checker++;
				}
			});
	});

	if(checker != 0)
	{
		cats.forEach(function(cat){
			cat.removeAttribute('required');
		});
		GetUserCats();
	}
}