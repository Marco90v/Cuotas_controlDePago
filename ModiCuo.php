<div ng-controller="ModifiCuota" class="container">
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-8">
						<h4>Modificar Cuotas de Pago</h4>
					</div>
					<div class="col-xs-4">
						<label class="control-label">Buscar</label>
						<input class="form-control" type="text" ng-model="buscarM">
					</div>
				</div>	
			</div>
			<div class="panel-body">
				<div class="col-xs-6 col-xs-offset-3 ">
					<table class="table table-hover table-condensed">
						<thead>
							<tr>
								<th>Fecha de registro de Cuota</th>
								<th>Monto</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="Lista in dataset | filter: buscarM" >
								<td>{{Lista.fech}}</td>
								<td>{{Lista.monto}}</td>
							</tr>
						</tbody>
					</table>
				<br/>
					<div class="btn-toolbar" role="toolbar">
						<div class="btn-group">
							<button ng-repeat="i in nm(nreg) track by $index" ng-click ="mas($index + 1)" type="button" class="btn btn-default">{{$index + 1}}</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>