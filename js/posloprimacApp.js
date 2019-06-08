var oPosloprimacModul = angular.module('oPosloprimacModul', []);

//DIO ZA OBAVIJESTI
oPosloprimacModul.controller("obavijestiController", function($scope, $http){
	$scope.oObavijesti = [];

	$http({
		method: "GET",
		url: "http://localhost/PortalZaPosao/action_korisnici.php?action_id=dohvati_obavijestiPosloprimca",
	}).then(function(response){
		/*console.log(response.data);*/
		$scope.oObavijesti = response.data;
	}, function(response){
		console.log("Error: učitavanje obavijesti nije uspjelo.");
	});
});

oPosloprimacModul.directive("posloprimacObavijesti", function(){
	return {
		restrict: "E",
		templateUrl: "templates/obavijestiPosloprimca.html"
	};
});

//DIO ZA POSLOVE
oPosloprimacModul.controller("posloviController", function($scope, $http){
	$scope.oPoslovi = [];

	$http({
		method: "GET",
		url: "http://localhost/PortalZaPosao/action_korisnici.php?action_id=dohvati_poslovePosloprimca"
	}).then(function(response){
		/*console.log(response.data);*/
		$scope.oPoslovi = response.data;
	}, function(response){
		console.log("Error: učitavanje poslova nije uspjelo.");
	});

	$scope.GetModalPosla = function(posaoId){
		GetModal('modals.php?modal_id=job_info&job_id='+posaoId);
	};
	$scope.RemoveJobFromPanel = function(posaoId){
		var posao = document.querySelector("div[ng-value='"+posaoId+"']");
		posao.classList.add('hidden');
	};
});

oPosloprimacModul.directive("posloprimacPoslovi", function(){
	return {
		restrict: "E",
		templateUrl: "templates/posloviPosloprimca.html"
	};
});

//DIO ZA RAZGOVORE
oPosloprimacModul.controller("razgovoriController", function($scope, $http){
	$scope.oRazgovori = [];
	$scope.oPoruke = [];
	$scope.oRazgovor = [];

	$http({
		method: "GET",
		url: "http://localhost/PortalZaPosao/action_korisnici.php?action_id=dohvati_razgovorePosloprimca"
	}).then(function(response){
		console.log(response.data);
		$scope.oRazgovori = response.data;
	}, function(response){
		console.log("Error: učitavanje razgovora nije uspjelo.");
	});

	$scope.GetPoruke = function(r_id){
		$scope.oRazgovor = [];
		$scope.oRazgovori.forEach(function(razgovor){
			if(razgovor.razgovor_id == r_id)
			{
				$scope.oPoruke = [];
				razgovor.poruke.forEach(function(poruka){
					$scope.oPoruke.push(poruka);
				});
				var oChat = {
					razgovorId: r_id,
					posiljatelj: razgovor.poslodavac_ime,
					poruke: $scope.oPoruke
				}
				$scope.oRazgovor.push(oChat);
			}
		});
	};
	$scope.GetDateTime = function()
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
	};
	$scope.SendMessage = function()
	{
		$.ajax({
			type: "POST",
			url: "action_korisnici.php",
			dataType: "text",
			data: $('#formMessage').serialize(),
			success: function(succesResponse){
				console.log(succesResponse);
				if(succesResponse != "ERROR")
				{
					$http({
						method: "GET",
						url: "http://localhost/PortalZaPosao/action_korisnici.php?action_id=dohvati_razgovorePosloprimca"
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

oPosloprimacModul.directive("posloprimacPoruke", function(){
	return {
		restrict: "E",
		templateUrl: "templates/porukePosloprimca.html"
	};
});

//NAKON PROMJENE U DOM ELEMENTU 'poslodavac-poruke' IZVRSI FUNKCIJU
$('posloprimac-poruke').on("DOMSubtreeModified", function(){
	var div = document.getElementById("panelBody");
	if(div)
	{
		div.scrollTop = div.scrollHeight;
	}
	
});