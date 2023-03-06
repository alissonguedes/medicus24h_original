<?php

namespace App\Http\Middleware{

	// use App\Models\UserModel;
	use App\Models\PermissaoModel;
	use Closure;
	// use Illuminate\Support\Facades\DB;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Route;
	use Illuminate\Support\Facades\Session;

	class CheckPermissions
	{

		public function handle(Request $request, Closure $redirector)
		{

			$this->permissao = new PermissaoModel();

			$route_name   = Route::currentRouteName();
			$route_action = Route::currentRouteAction();

			if (Session::exists('userdata')) {

				$this->permissao->checkPermissao($route_name);
				// $this->user    = new UserModel();
				// $this->session = Session::get('userdata')[Session::get('app_session')];

				// $permissoes = $this->user->select(
				// 	'Modulo.id AS modulo_id', 'Modulo.modulo', 'Modulo.path', 'Modulo.permissao AS modulo_permissao', 'Modulo.status AS modulo_status',
				// 	'Controller.id AS controller_id',
				// 	DB::raw(
				// 		'CONCAT(
				// 			(SELECT namespace FROM tb_acl_modulo WHERE id =
				// 				(SELECT id_modulo FROM tb_acl_modulo_controller WHERE id = id_controller)
				// 			),
				// 			(SELECT controller FROM tb_acl_modulo_controller WHERE id = id_controller)
				// 		) AS controller'
				// 	),
				// 	'Controller.permissao AS controller_permissao', 'Controller.restrict AS controller_restrict', 'Controller.status AS controller_status',
				// 	'Rota.id AS rota_id', 'Rota.type', 'Rota.route', 'Rota.action', 'Rota.name', 'Rota.filter', 'Rota.permissao AS rota_permissao', 'Rota.restrict AS rota_restrict', 'Rota.status AS rota_status'
				// )
				// 	->from('tb_acl_modulo AS Modulo')

				// 	->join('tb_acl_modulo_controller AS Controller', 'Controller.id_modulo', '=', 'Modulo.id')
				// 	->join('tb_acl_modulo_routes AS Rota', 'Rota.id_controller', '=', 'Controller.id')

				// 	->where(function ($where) {

				// 		$where->orWhere('Controller.permissao', '<=', $this->session['permissao']);
				// 		$where->orWhere('Controller.permissao', '<=', $this->session['grupo_permissao']);

				// 	})

				// 	->where(function ($where) {
				// 		$where->orWhere('Rota.permissao', '<=', $this->session['permissao']);
				// 		$where->orWhere('Rota.permissao', '<=', $this->session['grupo_permissao']);
				// 	})

				// 	->where('Modulo.permissao', '>', 0)
				// 	->where('Controller.permissao', '>', 0)
				// 	->where('Rota.permissao', '>', 0)
				// ;

				// if (!empty($route_name)) {
				// 	$permissoes->where('Rota.name', $route_name);
				// }

				// if (!empty($route_action)) {

				// 	$route_action = explode('@', $route_action);
				// 	$controller   = $route_action[0];
				// 	$action       = $route_action[1];

				// 	// $permissoes->where('controller', $controller);
				// 	$permissoes->where('id_controller', function ($query) use ($controller) {
				// 		$query->select('id')
				// 			->from('tb_acl_modulo_controller')
				// 			->where(
				// 				DB::raw('
				// 				CONCAT(
				// 					(SELECT namespace FROM tb_acl_modulo WHERE id = id_modulo),
				// 					tb_acl_modulo_controller.controller
				// 				)'
				// 				),
				// 				$controller
				// 			);
				// 	});
				// 	$permissoes->where('Rota.action', $action);

				// }

				// $permissoes = $permissoes
				// 	->get()
				// 	->first();

				// if (
				// 	!isset($permissoes) ||
				// 	(
				// 		(
				// 			(
				// 				$permissoes->rota_status &&
				// 				$permissoes->controller_status &&
				// 				$permissoes->modulo_status
				// 			) == 0
				// 			||
				// 			(
				// 				$permissoes->rota_permissao &&
				// 				$permissoes->controller_permissao &&
				// 				$permissoes->modulo_permissao
				// 			) == 0
				// 		)
				// 		&&
				// 		Session::get('userdata')[Session::get('app_session')]['id_grupo'] > 1
				// 	)
				// ) {
				// 	return abort('403', 'Você não possui permissão para ver esta página');
				// }

			}

			return $redirector($request);

		}

	}

}
