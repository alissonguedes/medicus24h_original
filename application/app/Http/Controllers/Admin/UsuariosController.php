<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use \App\Models\Admin\UsuarioModel;

class UsuariosController extends Controller
{

	public function __construct()
	{

		$this->usuario_model = new UsuarioModel();

	}

	public function index(Request $request)
	{

		if (!Session::has('userdata')) {
			if ($request->ajax()) {
				return abort(403);
			} else {
				return redirect()->route('admin.usuarios.login');
			}

		}

		if ($request->ajax()) {
			$dados['paginate'] = $this->usuario_model->getUsuario();

			return view('admin.usuarios.list', $dados);
		}

		return view('admin.usuarios.index');
	}

	public function show_form(Request $request, $id = null)
	{

		if (!Session::has('userdata')) {
			if ($request->ajax()) {
				return abort(403);
			} else {
				return redirect()->route('admin.usuarios.login');
			}

		}

		$dados = [];

		if (!is_null($id)) {
			$dados['row'] = $this->usuario_model->getUsuario($id)->first();
		}

		$dados['grupos'] = $this->usuario_model->getGrupos();

		return view('admin.usuarios.form', $dados);

	}

	public function insert(Request $request)
	{

		if (!Session::has('userdata')) {
			if ($request->ajax()) {
				return abort(403);
			} else {
				return redirect()->route('admin.usuarios.login');
			}

		}

		$request->validate([
			'nome'  => ['required', 'max:255'],
			'grupo' => ['required'],
			'login' => ['required', 'unique:tb_acl_usuario,login'],
			'email' => ['required', 'unique:tb_acl_usuario,email'],
		]);

		$url  = url('admin/usuarios ');
		$type = 'back';

		if ($this->usuario_model->create($request)) {
			$status  = 'success';
			$message = 'Idioma cadastrado com sucesso!';
		} else {
			$status  = 'error';
			$message = 'Não foi possível cadastrar o idioma. Por favor, tente novamente.';
		}

		return json_encode(['status' => $status, 'message' => $message, 'type' => $type, 'url' => $url]);
	}

	public function update(Request $request)
	{

		if (!Session::has('userdata')) {
			if ($request->ajax()) {
				return abort(403);
			} else {
				return redirect()->route('admin.usuarios.login');
			}

		}

		$request->validate([
			'nome'  => ['required', 'max:255'],
			'grupo' => ['required'],
			'login' => [
				'required',
				Rule::unique('tb_acl_usuario', 'login')->ignore($_POST['id'], 'id'),
			],
			'email' => [
				'required',
				Rule::unique('tb_acl_usuario', 'email')->ignore($_POST['id'], 'id'),
			],
		]);

		$url  = url('admin/usuarios ');
		$type = 'back';

		if ($this->usuario_model->edit($request)) {
			$status  = 'success';
			$message = 'Usuario atualizado com sucesso!';
		} else {
			$status  = 'error';
			$message = 'Não foi possível atualizar o usuario. Por favor, tente novamente.';
		}

		return json_encode(['status' => $status, 'message' => $message, 'type' => $type, 'url' => $url]);
	}

	public function replace(Request $request, $field)
	{

		if (!Session::has('userdata')) {
			if ($request->ajax()) {
				return abort(403);
			} else {
				return redirect()->route('admin.usuarios.login');
			}

		}

		$url  = url('admin/usuarios');
		$type = null;

		if ($this->usuario_model->edit($request, $field)) {
			$status  = 'success';
			$message = 'Usuario atualizado com sucesso!';
		} else {
			$status  = 'error';
			$message = 'Não foi possível atualizar o usuario. Por favor, tente novamente.';
		}

		return json_encode(['status' => $status, 'message' => $message, 'type' => $type, 'url' => $url]);
	}

	public function delete(Request $request)
	{

		if (!Session::has('userdata')) {
			if ($request->ajax()) {
				return abort(403);
			} else {
				return redirect()->route('admin.usuarios.login');
			}

		}

		$url  = url('admin/usuarios');
		$type = 'back';

		if ($this->usuario_model->remove($request)) {
			$status  = 'success';
			$message = 'Usuario removido com sucesso!';
		} else {
			$type    = null;
			$status  = 'error';
			$message = 'Não foi possível remover o usuario. Por favor, tente novamente.';
		}

		return json_encode(['status' => $status, 'message' => $message, 'type' => $type, 'url' => $url]);
	}
}
