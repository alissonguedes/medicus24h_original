<?php

use App\Models\ModuloModel;

$this->modulos = new ModuloModel();

// Listagem de todos os módulos existentes no sistema, independemente de privilégios de acesso.
if ($this->modulos->getModulos()->count() > 0) {

	Route::middleware([
		'usermodules',
		'usersession',
		'checkprivileges',
		// 'checkpermission',
	])->group(function () {

		foreach ($this->modulos->getModulos() as $modulo) {

			$this->id_modulo        = $modulo->id;
			$this->path_modulo      = $modulo->path;
			$this->permissao_modulo = $modulo->permissao;
			$this->restrict_modulo  = $modulo->restrict;

			// echo 'Route::prefix("' . $this->path_modulo . '")->group(function() {<br>
			// &nbsp;&nbsp;&nbsp;&nbsp;<br>';

			Route::prefix($this->path_modulo)->group(function () {

				// if ($this->modulos->getControllers($this->id_modulo)->count() > 0) {

				// 	foreach ($this->modulos->getControllers($this->id_modulo) as $controller) {

				// 		$this->id_controller        = $controller->id;
				// 		$this->id_modulo_controller = $controller->id_modulo;
				// 		$this->namespace_controller = $controller->namespace;
				// 		$this->permissao_controller = $controller->permissao;
				// 		$this->restrict_controller  = $controller->restrict;

				$this->modulos->getRoutes($this->id_modulo);

				// 	}

				// }

			});

			// echo '<br>';
			// echo '});<br><br>';

		}

	});

}
