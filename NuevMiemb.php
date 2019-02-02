<div ng-controller="nuevoM" class="container">
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">Nuevo Miembro</div>
			</div>
			<div class="panel-body">
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label class="col-xs-5 control-label">Cedula</label>
						<div class="col-xs-3"><input class="form-control" type="text" ng-model="ced"></div>
					</div>
					<div class="form-group">
						<label class="col-xs-5 control-label">Nombre</label>
						<div class="col-xs-3"><input type="text" ng-model="nomb" class="form-control"></div>
					</div>
					<div class="form-group">
						<label class="col-xs-5 control-label">Apellido</label>
						<div class="col-xs-3"><input type="text" ng-model="apell" class="form-control"></div>
					</div>
					<div class="form-group">
						<label class="col-xs-5 control-label">Telefono</label>
						<div class="col-xs-3"><input type="text" ng-model="cel" class="form-control"></div>
					</div>
					<div class="form-group">
						<label class="col-xs-5 control-label">Correo</label>
						<div class="col-xs-3"><input type="text" ng-model="eMail" class="form-control"></div>
					</div>
					<div class="form-group">
						<label class="col-xs-5 control-label">Fecha de Nacimiento</label>
						<div class="col-xs-3"><input ng-model="dateN" type="date" ng-value="{{date | date:'dd/MM/yyyy'}}" date-parser="dd/MM/yyyy" required class="form-control"></div>
					</div>
					<div class="form-group">
						<label class="col-xs-5 control-label">Fecha de Ingreso</label>
						<div class="col-xs-3"><input ng-model="dateI" type="date" ng-value="{{date | date:'dd/MM/yyyy'}}" date-parser="dd/MM/yyyy" required class="form-control"></div>
					</div>
					<div class="form-group">
						<label class="col-xs-5 control-label">Grado</label>
						<div class="col-xs-3"><input type="text" ng-model="Grado" class="form-control" placeholder="1" ng-disabled="{{valor==true}}"></div>
					</div>
					<!--<div class="form-group">
						<label class="col-xs-5 control-label">Grado</label>
						<div class="col-xs-3"><input type="text" ng-model="G" class="form-control"></div>
					</div>-->
				</form>
				<div class="col-xs-offset-6">
				<button ng-click="guardar()" class="btn btn-success btn-xs">
					<span class="glyphicon glyphicon-floppy-save"></span>
					Guardar 
				</button>
				</div>
			</div>
		</div>		
	</div>
</div>