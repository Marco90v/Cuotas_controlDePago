const cuotas = angular.module('cuotas',['ngRoute', 'ngAnimate']);
var paCed;
var nom;
var apel;

let ruta = "/Codigo/cuotas/modelo/";

cuotas.config(['$routeProvider',
              function($routeProvider) {
                $routeProvider.
                  when('/ListaMiembros', {
                    templateUrl: 'view/listMiemb.html',
                    //controller: 'miembros'
                  }).
                  when('/NuevoMiembro', {
                    templateUrl: 'view/NuevMiemb.html',
                    controller: 'nuevoM'
                  }).
                  when('/ModificarCuo', {
                    templateUrl: 'view/ModiCuo.html',
                  }).
                  when('/Estadisticas', {
                    templateUrl: 'view/estadis.html',
                  }).
                  when('/Lpagos', {
                    templateUrl: 'view/lista_p.html',
                    //controller: 'pagos'
                  }).
                  when('/pagar', {
                    templateUrl: 'view/p.html',
                    //controller: 'pagos'
                  }).
                  when('/Modi', {
                    templateUrl: 'view/NuevMiemb.html',
                    //controller: 'pagos'
                  }).
                  otherwise({
                    redirectTo: '/',
                      templateUrl: 'view/ini.html',
                      //controller: 'miembros'
                  });
              }]);


cuotas.controller('miembros', function($scope, $http){
	$scope.total = 0;
	$scope.listMiembros= -1;
	$http.post(ruta+'accion.php',{accion:1})
	.then(function (response){
		if(response.data.msg == false){
			$scope.total = 0;
			$scope.listMiembros= 0;
		}else{
			$scope.total = response.data.length;
			$scope.listMiembros= 1;
			$scope.dataset = response.data;
		}
	});
});

cuotas.controller('nuevoM', function($scope, $http){
	$scope.valor=true;
	$scope.guardar = function(){
		$scope.datos.accion=2;
			$http.post(ruta+'accion.php',$scope.datos)
			.then(function (response){
				response.data ? trueNuevo() : falseNuevo();
			});
	}

	function trueNuevo() {
		$scope.datos={};
		$scope.trueNuevo=true;
		$scope.falseNuevo=false;
	}
	function falseNuevo() {
		$scope.trueNuevo=false;
		$scope.falseNuevo=true;
	}

	// $scope.modi = function(cedula){
	// 	$scope.valor=false;
	// 	$http.post('modelo.php', {accion:8, ced:cedula})
	// 	.success(function(response){
	// 		console.log($scope.valor);
	// 	});
	// }
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


cuotas.controller('ModifiCuota', function($scope,$timeout,$http){
	$scope.datos={};
	$scope.listMonto=-1;

	$http.post(ruta+'accion.php',{accion:6})
	.then((response)=>{
		if(response.data.length>0){
			$scope.dataset=response.data;
			$scope.listMonto=1;
		}else{
			$scope.listMonto=0;
		}	
	});

	$scope.guardar = function(){
		$scope.datos.accion=7;
		$scope.datos.monto=$scope.monto;
		$http.post(ruta+'accion.php', $scope.datos)
		.then((response)=>{
			response.data.msg==false ? falseNuevo() : trueNuevo(response.data[0]);
		});
	}
	function trueNuevo(arr) {
		$scope.dataset.push(arr);
		$scope.trueNuevo=true;
		$scope.falseNuevo=false;
		$timeout(()=>{$scope.trueNuevo=false;},3000);
	}
	function falseNuevo() {
		$scope.trueNuevo=false;
		$scope.falseNuevo=true;
	}
});