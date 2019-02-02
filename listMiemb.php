<div   ng-controller="miembros" class="container">
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-8">
						<h4>Lista de Miembros ({{total}})</h4>
					</div>
					<div class="col-xs-4">
						<label class="control-label">Buscar</label>
						<input class="form-control" type="text" ng-model="buscarM">
					</div>
				</div>	
			</div>
			<div class="panel-body">
				<table class="table table-hover table-condensed">
					<thead>
						<tr>
							<th>Cedula</th>
							<th>Nombre</th>
							<th>Apellido</th>
							<th>Telefono</th>
							<th>Correo</th>
							<th>Fecha de Nacimiento</th>
							<th>Fecha de Ingreso</th>
							<th>Grado</th>
							<th>Pagar</th>
							<th><span class="glyphicon glyphicon-eye-open"></span></th>
							<th><span class="glyphicon glyphicon-pencil"></span></th>
							<!-- <th><span class="glyphicon glyphicon-remove"></span></th> -->
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="Lista in dataset | filter: buscarM" >
							<td>{{Lista.cedula}}</td>
							<td>{{Lista.nombre}}</td>
							<td>{{Lista.apellido}}</td>
							<td>{{Lista.cel}}</td>
							<td>{{Lista.eMail}}</td>
							<td>{{Lista.f_nac}}</td>
							<td>{{Lista.f_ingr}}</td>
							<td>{{Lista.G}}</td>
							<td>
								<a href="#/pagar">
									<button ng-click="p(Lista.cedula, Lista.nombre, Lista.apellido)" class="btn btn-default btn-xs">
									Pagar
									</button>
								</a>
							</td>
							<td>
								<a href="#/Lpagos">
									<button ng-click="p(Lista.cedula, Lista.nombre, Lista.apellido)" class="btn btn-default btn-xs">
										<span class="glyphicon glyphicon-eye-open"></span>
									</button>
								</a>
							</td>
							<td>
								<a href="#/Modi">
									<button ng-click="modi(Lista.cedula)" class="btn btn-default btn-xs">
										<span class="glyphicon glyphicon-pencil"></span>
									</button>
								</a>
							</td>
							<!--<td><button ng-click="elim(Lista.cedula)" class="btn btn-default btn-xs">
									<span class="glyphicon glyphicon-remove"></span>
								</button></td>-->
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>