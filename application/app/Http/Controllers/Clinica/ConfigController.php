<?php

namespace App\Http\Controllers\Clinica{

	// use App\Models\Admin\IdiomaModel;
	use App\Models\ConfigModel;
	use App\Models\ModuloModel;
	use Illuminate\Http\Request;
	use Illuminate\Validation\Rule;

	class ConfigController extends Controller
	{

		public function __construct()
		{
			$this->config_model = new ConfigModel();
			$this->modulo_model = new ModuloModel();
			// $this->idioma_model = new IdiomaModel();
		}

		public function index(Request $request)
		{

			if ($request->ajax()) {
				$dados['paginate'] = $this->menu_model->getMenus()->paginate();
				return view('admin.menus.list', $dados);
			}

			$dados['modulos'] = $this->modulo_model->getModulos();

			return view('admin.menus.index', $dados);

		}

		public function show_form(Request $request, $id = null)
		{

			return view('admin.menus.edit');
			// return redirect()->route('admin.menus')->send();

		}

		public function create(Request $request)
		{

			$request->validate([
				// 'titulo' => ['required', Rule::unique('tb_acl_menu', 'label')->ignore($request->id, 'id'), 'max:255'],
				'titulo' => ['required', Rule::unique('tb_acl_menu', 'label'), 'max:255'],
				'modulo' => ['required'],
			]);

			$id      = $this->menu_model->insertMenu($request);
			$status  = 'success';
			$message = 'As configurações foram salvas com sucesso!';
			$url     = url()->route('admin.menus.edit', $id);
			$type    = 'send';

			return json_encode(['status' => $status, 'message' => $message, 'type' => $type, 'url' => $url], 200);

		}

		public function patch(Request $request)
		{

			return $this->config_model->patch([$request->config => $request->value]);

		}

		public function delete(Request $request)
		{

		}

	}

}
