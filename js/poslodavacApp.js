var oPoslodavacModul = angular.module('oPoslodavacModul', []);


//DIO ZA OBAVIJESTI
oPoslodavacModul.controller("obavijestiController", function($scope, $http){
	$scope.oObavijesti = [];
	$http({
		method: "GET",
		url: "http://localhost/PortalZaPosao/action_korisnici.php?action_id=dohvati_obavijestiPoslodavca",

	}).then(function(response){
		/*console.log(response.data);*/
		$scope.oObavijesti = response.data;
	}, function(response){
		console.log(response);
		console.log("Error: učitavanje obavijesti nije uspjelo.");
	});
});

oPoslodavacModul.directive("poslodavacObavijesti", function(){
	return {
		restrict: "E",
		templateUrl: "templates/obavijestiPoslodavca.html"
	};
});


//DIO ZA POSLOVE
oPoslodavacModul.controller("posloviController", function($scope, $http){
	$scope.oPoslovi = [];

	$http({
		method: "GET",
		url: "http://localhost/PortalZaPosao/action_korisnici.php?action_id=dohvati_poslovePoslodavca"
	}).then(function(response){
		/*console.log(response.data);*/
		$scope.oPoslovi = response.data;
	}, function(response){
		console.log("Error: učitavanje poslova nije uspjelo.");
	});

	$scope.GetModalPosla = function(posaoId){
		GetModal('modals.php?modal_id=job_update&job_id='+posaoId);
	};
});

oPoslodavacModul.directive("poslodavacPoslovi", function(){
	return {
		restrict: "E",
		templateUrl: "templates/posloviPoslodavca.html"
	};
});

//DIO ZA RAZGOVORE 
oPoslodavacModul.controller("razgovoriController", function($scope, $http){
	$scope.oRazgovori = [];
	$scope.oRazgovor = [];


	$http({
		method: "GET",
		url: "http://localhost/PortalZaPosao/action_korisnici.php?action_id=dohvati_razgovorePoslodavca"
	}).then(function(response){
		/*console.log(response.data);*/
		$scope.oRazgovori = response.data;
	}, function(response){
		console.log("Error: Učitavanje razgovora nije uspjelo.");
	});

	setInterval(function(){
		var msgNumber = '';
		var msgUpdateNumber = '';
		$http({
			method: "GET",
			url: "http://localhost/PortalZaPosao/action_korisnici.php?action_id=dohvati_razgovorePoslodavca"
		}).then(function(response){
			//ZAPISI RAZGOVORE IZ TABLICE
			$scope.oRazgovoriUpdate = response.data;

			//TRENUTNI BROJ RAZGOVORA
			$scope.oRazgovori.forEach(function(razgovor){
				msgNumber += razgovor.poruke.length + " ";
			});
			
			//UPDATEANI BROJ RAZGOVORA
			$scope.oRazgovoriUpdate.forEach(function(razgovorUpdate){
					msgUpdateNumber += razgovorUpdate.poruke.length + " ";
				});

			if(msgNumber != msgUpdateNumber)
			{
				$scope.oRazgovori = $scope.oRazgovoriUpdate;
			}

		}, function(response){
			console.log("Error: Update razgovora nije uspio.");
		});
	}, 1000);

	$scope.GetPoruke = function(r_id){
		$scope.oRazgovor = [];
		var msgCount = 0;
		$scope.oRazgovori.forEach(function(razgovor){
			if(razgovor.razgovor_id == r_id)
			{
				var oChat = {
					razgovorId: r_id,
					posiljatelj: razgovor.posloprimac_imePrezime,
					poruke: razgovor.poruke,
					slikaPosiljatelja: razgovor.posloprimac_slika
				}
				$scope.oRazgovor.push(oChat);

				msgCount = $scope.oRazgovor[0].poruke.length;
			}
		});

		setInterval(function(){
			$scope.oRazgovorUpdate = [];
			$scope.oRazgovori.forEach(function(razgovor){
				if(razgovor.razgovor_id == r_id)
				{
					var oChat = {
						razgovorId: r_id,
						posiljatelj: razgovor.posloprimac_imePrezime,
						poruke: razgovor.poruke
					}
					$scope.oRazgovorUpdate.push(oChat);

					var msgCountUpdate = $scope.oRazgovorUpdate[0].poruke.length;
					if(msgCount != msgCountUpdate)
					{
						$scope.oRazgovor = $scope.oRazgovorUpdate;
						msgCount = msgCountUpdate;
					}
				}
			});
		}, 1000);
	};
	/*$scope.GetDateTime = function()
	{
		var dateNow = new Date();
		var hours = dateNow.getHours();
		var minutes = dateNow.getMinutes();
		if(dateNow.getHours() < 10)
		{
			hours = "0"+ dateNow.getHours();
		}
		if(dateNow.getMinutes() < 10)
		{
			minutes = "0"+ dateNow.getMinutes();
		}
		var time = hours + ":" + minutes;
		var date = dateNow.getDate()+"/"+(dateNow.getMonth()+1)+"/"+dateNow.getFullYear();

		var dateTime = time+" "+date;

		return dateTime;
	};*/
	$scope.SendMessage = function()
	{
		$.ajax({
			type: "POST",
			url: "action_korisnici.php",
			dataType: "text",
			data: $('#formMessage').serialize(),
			success: function(succesResponse){
				/*console.log(succesResponse);*/
				if(succesResponse != "ERROR")
				{
					$http({
						method: "GET",
						url: "http://localhost/PortalZaPosao/action_korisnici.php?action_id=dohvati_razgovorePoslodavca"
					}).then(function(response){
						$scope.oRazgovori = response.data;
						$scope.GetPoruke(succesResponse);
					}, function(response){
						console.log("Error: učitavanje razgovora nije uspjelo.");
					});
				}
				else
				{
					alert("Ne možete poslati praznu poruku!");
				}
			},
			error: function(response){
				console.log("ERROR: " + response.status + " " + response.statusText);
			}
		});
	};
	$scope.RenderPosiljateljIme = function(posiljatelj){
		var title = document.querySelector("#titlePosiljatelj");
		if(posiljatelj.length > 25)
		{
			title.style.fontSize = "24px";
			title.innerHTML = posiljatelj;
		}
		else
		{
			title.innerHTML = posiljatelj;
		}
	}
});

oPoslodavacModul.directive("poslodavacPoruke", function(){
	return {
		restrict: "E",
		templateUrl: "templates/porukePoslodavca.html"
	};
});

//NAKON PROMJENE U DOM ELEMENTU 'poslodavac-poruke' IZVRSI FUNKCIJU
$('poslodavac-poruke').on("DOMSubtreeModified", function(){
	var div = document.getElementById("panelBody");
	if(div)
	{
		div.scrollTop = div.scrollHeight;
	}
	
});