var cuotas = angular.module('cuotas',['ngRoute']);
var paCed;
var nom;
var apel;

cuotas.config(['$routeProvider',
              function($routeProvider) {
                $routeProvider.
                  when('/ListaMiembros', {
                    templateUrl: 'listMiemb.php',
                    //controller: 'miembros'
                  }).
                  when('/NuevoMiembro', {
                    templateUrl: 'NuevMiemb.php',
                    //controller: 'nuevoM'
                  }).
                  when('/ModificarCuo', {
                    templateUrl: 'ModiCuo.php',
                  }).
                  when('/Estadisticas', {
                    templateUrl: 'estadis.php',
                  }).
                  when('/Lpagos', {
                    templateUrl: 'lista_p.php',
                    //controller: 'pagos'
                  }).
                  when('/pagar', {
                    templateUrl: 'p.php',
                    //controller: 'pagos'
                  }).
                  when('/Modi', {
                    templateUrl: 'NuevMiemb.php',
                    //controller: 'pagos'
                  }).
                  otherwise({
                    redirectTo: '/',
                      templateUrl: 'ini.php',
                      //controller: 'miembros'
                  });
              }]);


cuotas.controller('miembros', function($scope, $http){
	$http.post('modelo.php',{accion:1})
	.success(function (response){
		if(response.msg){
			alert(response.msg);}
		else if(response.lista){
			$scope.dataset = response.lista;
			$scope.total = response.Total;}
	});
	$scope.p = function(ced, n, a){
		paCed = ced;
		nom = n;
		apel = a;
	}
});

cuotas.controller('nuevoM', function($scope, $http){
	$scope.valor=true;
	//console.log($scope.valor);
	$scope.guardar = function(){
		if(typeof($scope.ced)== "undefined" || typeof($scope.nomb)== "undefined" || typeof($scope.apell)== "undefined" ||typeof($scope.cel)== "undefined"
		 || typeof($scope.eMail)== "undefined" || typeof($scope.dateN)== "undefined" || typeof($scope.dateI)== "undefined"
		 || $scope.ced=="" || $scope.nomb=="" || $scope.apell=="" || $scope.cel=="" || $scope.eMail=="" || $scope.dateN=="" || $scope.dateI==""){
			alert("Todos los campos son obligatorios");
		}
		else{
			$http.post('modelo.php',{accion:2,
								ced:$scope.ced,
								nomb:$scope.nomb,
								apell:$scope.apell,
								cel:$scope.cel,
								correo:$scope.eMail,
								f_nac:$scope.dateN,
								f_ingr:$scope.dateI})
			.success(function (response){
				if(response.msg){
					alert(response.msg);}
				else if(response.lista){
					$scope.dataset = response.lista;}
			});
		}	
	}

	$scope.modi = function(cedula){
		$scope.valor=false;
		$http.post('modelo.php', {accion:8, ced:cedula})
		.success(function(response){
			console.log($scope.valor);
		});
	}
});


cuotas.controller('Lpagos', function($scope, $http){
	$scope.miemb = nom + " " + apel;
	$http.post('modelo.php',{accion:3,ced:paCed})
	.success(function (response){
		if(response.msg){
			alert(response.msg);}
		else if(response.lista){
			$scope.dataset = response.lista;
			$scope.dataset2 = response.lista2;
			$scope.total = response.Total;}
	});
});

cuotas.controller('pagar', function($scope, $http){
	$scope.ced = paCed;
	$scope.miemb = nom + " " + apel;
	$scope.mostrar =[];
	var mes;
	var ano;

	$http.post('modelo.php',{accion:4,ced:paCed})
	.success(function (response){
		if(response.msg){
			alert(response.msg);}
		else {
			mes = parseInt(response.ulti_M);
			$scope.mostrar.push({ultA:response.ulti_A, ultM:response.ulti_M, um:response.mon_Cuo, mA:response.mon_Cuo});
			//mes = mes + 1;

			ano = response.ulti_A;
			$scope.ult_A=response.ulti_A;
			$scope.ult_M=response.ulti_M;
			$scope.u_m=response.mon_Cuo;

			$scope.aS=parseInt(response.aS);
			$scope.mS=parseInt(response.mS);
			$scope.ult_A_num=parseInt(response.ulti_A);}
	});




	//FUNCION PARA AGREGAR NUEVOS CAMPOS
	var n = 12;
	$scope.range = function() {
		if($scope.aS == $scope.ult_A_num){n= $scope.mS;}
		if($scope.aS >= $scope.ult_A_num){
			if(mes < n){
				mes = mes + 1;
				var mesCad = mes.toString();
				if(mesCad.length<2){
					mesCad = "0" + mesCad;}
				$scope.mostrar.push({ultA:ano, ultM:mesCad, um:$scope.u_m, mA:$scope.u_m});
			}

			if(mes==12){
				$scope.ult_A_num++;
				ano = $scope.ult_A_num.toString();
				mes=0;
				if($scope.aS >= $scope.ult_A_num){
					n=$scope.mS;}
			}
		}
    };

    //FUNCION QUE ELIMINA ELEMENTOS DEL ARREGLO DE OBJETOS JSON MOSTRAR **FUNCION NO SE USA EN ESTE SISTEMA**
    $scope.cancelar = function(i){
    	var index = $scope.mostrar.indexOf(i);
  		$scope.mostrar.splice(index, 1);
  		if(parseInt($scope.ult_M)==12){
  			$scope.ult_A = parseInt($scope.ult_A);
  			$scope.ult_A++;
  			$scope.ult_A = $scope.ult_A.toString();

  			$scope.ult_M = parseInt($scope.ult_M);
  			$scope.ult_M = 01;
  			$scope.ult_M = $scope.ult_M.toString();
  		}
  		else
  		{
  			$scope.ult_M = parseInt($scope.ult_M);
  			$scope.ult_M++;
  			$scope.ult_M = $scope.ult_M.toString();
  		}
    }


    $scope.pagar = function(c, mo, a, me, i, pago){
    	if(parseInt($scope.u_m) < parseInt(mo)){
    		alert("Monto a cancelar es mayor a la cuota mensual establecida");}
    	else {
    		if(parseInt(a) == parseInt($scope.ult_A) && parseInt(me) == parseInt($scope.ult_M)){
    			var fecha_p = a + "-" + me + "-01";
    			console.log($scope.p_parc);
    			$http.post('modelo.php',{accion:5, ced:c, cuota:mo, fp:fecha_p, monto:pago})
				.success(function (response){
					alert(response.msg);
					if(parseInt(response.msg2)==1){
						//alert(response.msg);
						$scope.cancelar(i);
					}
				});
    		}
    		else {alert("Debe cancelar la cuoto mas antigua primero");}

    		/*$http.post('modelo.php',{accion:5})
			.success(function (response){

			}*/
    	}
    	//console.log("cedula: " + c + "monto: " + mo + "fecha de la cuota: " + a + "-" + me + "-01");
    }

});


cuotas.controller('ModifiCuota', function($scope, $http){

	$http.post('modelo.php',{accion:6})
	.success(function (response){
		if(response.msg){
			alert(response.msg);}
		else {
			$scope.dataset = response.lista;
			$scope.nreg = parseInt(response.nreg);}
	});

	$scope.nm = function(nr){
		return new Array(nr);
	}

	$scope.mas = function(nex){
		$http.post('modelo.php',{accion:7,nex:nex})
	.success(function (response){
		if(response.msg){
			alert(response.msg);}
		else {
			$scope.dataset = response.lista;
			//$scope.nreg = parseInt(response.nreg);
			//console.log(response.nreg)
		}
	});
	}
});