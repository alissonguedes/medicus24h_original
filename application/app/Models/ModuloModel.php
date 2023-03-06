<?php

namespace App\Models{

	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Support\Facades\DB;
	use Illuminate\Support\Facades\Route;

	class ModuloModel extends Model
	{

		use HasFactory;

		// protected $connection = 'mysql2';

		public function __construct()
		{
			$this->connection = env('DB_CONNECTION_2');
		}

		public function getModulos($id = null)
		{

			return $this->select('*')
				->from('tb_acl_modulo')
			// ->where('status', '1')
				->orderBy('path', 'asc')
				->get();

		}

		public function getControllers($id_modulo = null)
		{

			return $this->from('tb_acl_modulo_controller')
				->where('id_modulo', $id_modulo)
			// ->where('status', '1')
				->get();

		}

		public function getRoutes($id = null, $id_parent = null)
		{

			$routes = $this->select(
				'id',
				'id_controller',
				DB::raw('(SELECT id_modulo FROM tb_acl_modulo_controller WHERE id = id_controller) AS id_modulo'),
				// DB::raw('(SELECT path FROM tb_acl_modulo WHERE id = (SELECT id_modulo FROM tb_acl_modulo_controller WHERE id = id_controller)) AS modulo'),
				'id_parent',
				'type',
				'route',
				DB::raw(
					'CONCAT(
						(SELECT namespace FROM tb_acl_modulo WHERE id =
							(SELECT id_modulo FROM tb_acl_modulo_controller WHERE id = id_controller)
						),
						(SELECT controller FROM tb_acl_modulo_controller WHERE id = id_controller)
					) AS controller'
				),
				'action',
				'name',
				'filter',
				'permissao',
				'restrict'
			)
				->from('tb_acl_modulo_routes');

			$routes = $routes->where('status', '1');

			if (gettype($id) === 'string') {
				$routes = $routes->where('name', $id);
				return $routes;
			}

			$routes->where('id_controller', function ($query) use ($id) {

				$query->select('C.id')
					->from('tb_acl_modulo_controller AS C')
					->whereColumn('id_controller', 'C.id')
					->where('C.id_modulo', $id);

			});

			$routes = $routes->where('id_parent', $id_parent)
				->orderBy('id_controller')
				->get();

			if ($routes->count() > 0) {

				foreach ($routes as $route) {

					$subroute = $this->from('tb_acl_modulo_routes')
						->where('id_parent', $route->id)
					// ->where('id_controller', $route->id_controller)
						->where('status', '1')
						->get();

					if ($subroute->count() === 0) {

						$type_route = $route->type;

						if (!empty($route->name)) {
							Route::$type_route($route->route, [$route->controller, $route->action])->name($route->name);
							// echo $route . '<br>';
							// echo 'Route::' . $type_route . '("' . $route->route . '", ["' . $route->controller . '", "' . $route->action . '"])->name("' . $route->name . '"); // ' . url($route->modulo . $route->route) . ' <br>';
						} else {
							Route::$type_route($route->route, [$route->controller, $route->action]);
							// echo $route . '<br>';
							// echo 'Route::' . $type_route . '("' . $route->route . '", ["' . $route->controller . '", "' . $route->action . '"]); // ' . route($route->name) . ' ;<br>';
						}

					} else {

						// echo 'Route::prefix("' . $route->route . '")->group(function ($router) use ($route) {<br>';
						Route::prefix($route->route)->group(function ($router) use ($route) {
							$this->getRoutes((int) $route->id_modulo, $route->id);
						});
						// echo '});<br>';

					}

				}

			}

		}

		public function getRoute($url)
		{

			return $this->getRoutes($url)->first() ?? 'Não existe uma rota válida';

		}

		public function getIsRestrictModulo($modulo)
		{

			return $this->from('tb_acl_modulo')
				->where('path', $modulo)
				->where('restrict', 'yes')
				->get()
				->first() ? true : false;

		}

		public function getIsRestrictController($controller)
		{

			return $this->from('tb_acl_modulo_controller')
				->where(DB::raw('CONCAT((SELECT namespace FROM tb_acl_modulo WHERE id = id_modulo), controller)'), $controller)
				->where('restrict', 'yes')
				->get()
				->first() ? true : false;
		}

		public function getIsRestrictRoute($controller, $action, $name)
		{

			$this->name = $name;

			return $this->from('tb_acl_modulo_routes')
				->where('id_controller', function ($query) use ($controller) {
					$query->select('id')
						->from('tb_acl_modulo_controller')
						->where(
							DB::raw('
								CONCAT(
									(SELECT namespace FROM tb_acl_modulo WHERE id = id_modulo),
									tb_acl_modulo_controller.controller
								)'
							),
							$controller
						);
				})
				->where('action', $action)
				->where(function ($where) {
					$where->orWhereNull('name')
						->orWhere('name', $this->name);
				})
				->where('restrict', 'yes')
				->get()
				->first() ? true : false;
		}

	}

}
