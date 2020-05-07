const cuotas = angular.module('cuotas',['ngRoute', 'ngAnimate']);
const meses = [null,'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
const ruta = "/Codigo/cuotas/modelo/"; // Ruta donde se encuentran los archivos PHP

cuotas.config(['$routeProvider', ($routeProvider)=>{
    $routeProvider
	.when('/ListaMiembros', { templateUrl: 'view/listMiemb.html', controller: 'miembros' })
	.when('/NuevoMiembro', { templateUrl: 'view/NuevMiemb.html', controller: 'nuevoM' })
    .when('/ModificarCuo', { templateUrl: 'view/ModiCuo.html', controller: 'ModifiCuota' })
    .when('/Lpagos/:cedula', { templateUrl: 'view/lista_p.html', controller: 'Lpagos' })
    .when('/pagar/:cedula', { templateUrl: 'view/pagar.html', controller: 'pagar' })
    .when('/Modi/:id', { templateUrl: 'view/NuevMiemb.html', controller: 'edit' })
    .otherwise({ redirectTo: '/', templateUrl: 'view/ini.html', });
}]);

cuotas.controller('miembros', function($scope, $http){
	$scope.total = 0;
	$scope.listMiembros= -1;
	$http.post(ruta+'accion.php',{accion:1})
	.then((response)=>{
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

cuotas.controller('nuevoM', function($scope, $http, $timeout){
	$scope.datos={};
	$scope.datos.estado = "1";
	$scope.guardar = function(){
		if($scope.datos.estado == 1){
			$scope.datos.accion=2;
			$http.post(ruta+'accion.php',$scope.datos)
			.then((response)=>{ response.data.msg ? falseNuevo($scope) : trueNuevo($scope,$timeout); });
		}else{ alert("Estado debe ser activado"); }
	}
});

cuotas.controller('Lpagos', function($scope, $http, $routeParams){
	$scope.listPagos=-1;
	$http.post(ruta+'accion.php',{accion:3,cedula:$routeParams.cedula})
	.then((response)=>{
		if (response.data.msg) { $scope.listPagos=0; }else{
			$scope.listPagos=1;
			$scope.dataset = response.data;
		}
	});
});

cuotas.controller('pagar', function($scope, $http, $routeParams, $timeout){
	$scope.total = 0;
	$scope.listDeuda = -1;
	$http.post(ruta+'accion.php', {accion:4, cedula:$routeParams.cedula})
	.then((response)=>{
		if(response.data.msg==false){ $scope.listDeuda = 0; 
		}else{
			$scope.listDeuda = 1;
			$scope.dataset = response.data;
			$scope.dataset.map((arr)=>{
				arr.mes = meses[arr.mes];
				$scope.total += parseInt(arr.monto);
			});
		}
	});

	$scope.pagar = ()=>{
		if($scope.montoPagar == $scope.total && $scope.montoPagar != 0){
			$http.post(ruta+'accion.php',{accion:5,cedula:cedula, datos:$scope.dataset})
			.then((response)=>{ response.data.msg  ? trueNuevo($scope,$timeout) : falseNuevo($scope); });
		}else if($scope.montoPagar==0){ }
	}
});

cuotas.controller('ModifiCuota', function($scope,$http,$timeout){
	$scope.datos={};
	$scope.listMonto=-1;
	$scope.dataset=[];

	$http.post(ruta+'accion.php',{accion:6})
	.then((response)=>{
		if(response.data.length>0){
			$scope.dataset=response.data;
			$scope.listMonto=1;
		}else{ $scope.listMonto=0; }	
	});

	$scope.guardar = function(){
		$scope.datos.accion=7;
		$scope.datos.monto=$scope.monto;
		$http.post(ruta+'accion.php', $scope.datos)
		.then((response)=>{ response.data.msg ? falseNuevo($scope) : trueNuevo($scope,$timeout,response.data[0]); });
	}
});

cuotas.controller('edit', function($scope, $http,$routeParams,$timeout){
	$http.post(ruta+'accion.php',{accion:8,id:$routeParams.id})
	.then((response)=>{
		$scope.datos={};
		$scope.datos.ced = parseInt(response.data[0].cedula);
		$scope.datos.nomb = response.data[0].nombre;
		$scope.datos.apell = response.data[0].apellido;
		$scope.datos.cel = parseInt(response.data[0].telefono);
		$scope.datos.eMail = response.data[0].correo;
		$scope.datos.dateN = new Date(response.data[0].nacimiento);
		$scope.datos.dateI = new Date(response.data[0].ingreso);
		$scope.datos.estado = response.data[0].estado.toString();		
	});
	$scope.guardar = function(){
		$scope.datos.id = parseInt(id);
		$scope.datos.accion=9;
		$http.post(ruta+'accion.php',$scope.datos)
		.then((response)=>{ response.data ? trueNuevo($scope,$timeout) : falseNuevo($scope); });
	}
});


function trueNuevo(variable,time,arr=false) {
	variable.datos={};
	arr!=false ? variable.dataset.push(arr) : false;
	variable.trueNuevo=true;
	variable.falseNuevo=false;
	time(()=>{variable.trueNuevo=false;},3000);
}
function falseNuevo(variable) {
	variable.msg = 
	variable.trueNuevo=false;
	variable.falseNuevo=true;
}
