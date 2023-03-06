<?php

namespace App\Http\Middleware {

	use App\Models\ModuloModel;
	use Closure;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Session;

	/**
	 * Verifica quais os módulos que o usuário
	 * pode acessar antes de abri-los definitivamente.
	 */
	class CheckModules
	{

		/**
		 * Handle an incoming request.
		 *
		 * @param  \Illuminate\Http\Request  $request
		 * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
		 * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
		 */
		public function handle(Request $request, Closure $next)
		{

			$this->modulo_model = new ModuloModel();

			if (Session::exists('userdata')) {

				$modulo_path = request()->path();
				$path        = explode('/', $modulo_path);
				$path        = '/' . $path[0];
				$id_grupo    = Session::get('userdata')[Session::get('app_session')]['id_grupo'];

				$modulo = $this->modulo_model->from('tb_acl_modulo')
					->select('id', 'path', 'restrict', 'status')
					->where('status', '1')
					->where('path', $path)
					->get()
					->first();

				if (isset($modulo) && $modulo->restrict == 'yes' && $id_grupo > 1) {

					$is_auth = $this->modulo_model->from('tb_acl_modulo_grupo')
						->where('id_grupo', $id_grupo)
						->where('id_modulo', $modulo->id)
						->get()
						->first();

					if (!$is_auth) {

						return abort(403, 'Acesso não autorizado');

					}

				}

			}

			return $next($request);
		}

	}

}
