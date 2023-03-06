<?php

namespace App\Http\Controllers\Admin{

	// use App\Models\Admin\IdiomaModel;
	use App\Models\MenuModel;
	use App\Models\ModuloModel;
	use Illuminate\Http\Request;
	use Illuminate\Validation\Rule;

	class MenusController extends Controller
	{

		public function __construct()
		{
			$this->menu_model   = new MenuModel();
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

			$dados['row'] = $this->menu_model->getMenuById($id);

			return view('admin.menus.edit', $dados);
			// return redirect()->route('admin.menus')->send();

		}

		public function create(Request $request)
		{

			$request->validate([
				// 'titulo' => ['required', Rule::unique('tb_acl_menu', 'label')->ignore($request->id, 'id'), 'max:255'],
				'titulo' => ['required', Rule::unique('tb_acl_menu_descricao', 'titulo'), 'max:255'],
				'slug'   => [Rule::unique('tb_acl_menu_descricao', 'slug'), 'max:255'],
				'modulo' => ['required'],
			]);

			$id      = $this->menu_model->insertMenu($request);
			$status  = 'success';
			$message = 'Menu adicionado com sucesso!';
			$url     = url()->route('admin.menus.edit', $id);
			$type    = 'send';

			return json_encode(['status' => $status, 'message' => $message, 'type' => $type, 'url' => $url], 200);

		}

		public function edit(Request $request)
		{
			print_r($request->id);
			echo 'Editado';
		}

		public function patch(Request $request)
		{

			$this->menu_model->from('tb_acl_menu')->whereIn('id', $request->id)->update([$request->field => $request->value]);

			$status  = 'success';
			$message = ucfirst($request->field) . ' atualizado com sucesso!';
			$url     = url()->route('admin.menus');
			$type    = 'send';

			return json_encode(['status' => $status, 'message' => $message, 'type' => $type, 'url' => $url], 200);

		}

		public function delete(Request $request)
		{

			$this->menu_model->from('tb_acl_menu')->whereIn('id', $request->id)->delete();

			$status  = 'success';
			$message = 'Registro removido com sucesso!';
			$url     = url()->route('admin.menus');
			$type    = 'send';

			return json_encode(['status' => $status, 'message' => $message, 'type' => $type, 'url' => $url], 200);

		}

	}

}
