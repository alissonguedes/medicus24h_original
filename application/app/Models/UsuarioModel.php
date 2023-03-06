<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UsuarioModel extends Authenticatable
{
	use HasFactory, Notifiable;

	protected $connection = 'mysql2';
	protected $table      = 'tb_acl_usuario';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	private $order = [];

	public function getUsuario(Request $request, $find = null)
	{

		$get = $this->select(
			'tb_acl_usuario.id',
			'tb_acl_usuario.id_grupo',
			DB::raw('(SELECT grupo FROM tb_acl_grupo WHERE id = id_grupo) as grupo'),
			'tb_acl_usuario.nome',
			'tb_acl_usuario.email',
			'tb_acl_usuario.login',
			'tb_acl_usuario.ultimo_login',
			'tb_acl_usuario.status'
		);

		if (!is_null($find)) {
			$get->where('id', $find);
			return $get;
		}

		// if (isset($_GET['search']['value']) && !empty($_GET['search']['value'])) {
		if ($request->search) {
			$get->where(function ($get) use ($request) {
				$search = $request->search;
				$get->orWhere('tb_acl_usuario.id', 'like', $search . '%')
					->orWhere('tb_acl_usuario.login', 'like', $search . '%')
					->orWhere('tb_acl_usuario.email', 'like', $search . '%');
			});
		}

		$this->order = [
			'',
			'tb_acl_usuario.nome',
			DB::raw('(SELECT grupo FROM tb_acl_grupo WHERE tb_acl_grupo.id = tb_acl_usuario.id_grupo)'),
			'tb_acl_usuario.email',
			'tb_acl_usuario.ultimo_login',
			'tb_acl_usuario.status',
			'',
		];

		// Order By
		if ($request->order && $request->direction) {
			$get->orderBy($this->order[$request->order], $request->direction);
		} else {
			$get->orderBy($this->order[1], 'asc');
		}

		return $get->paginate($_GET['length'] ?? null);

	}

	public function getGrupos()
	{
		return $this->from('tb_acl_grupo')->where('status', '1')->get();
	}

	public function auth($login = null, $senha = null)
	{

		if (!is_null($login)) {

			$user = $this->select('id', 'id_grupo', 'senha', 'permissao', 'nome', 'login', 'email', 'senha')
				->where('login', $login)
				->orWhere('email', $login)
				->first();

			if (isset($user)) {

				Session::put('id', $user->id);
				Session::put('id_grupo', $user->id_grupo);
				Session::put('senha', $user->senha);
				Session::put('permissao', $user->permissao);

				Session::put('userlogin', ['nome' => $user->nome, 'login' => $user->login, 'email' => $user->email]);

				return true;

			}

		}

		if (!is_null($senha)) {

			if (Session::has('senha') && hashCode($senha) === Session::get('senha')) {

				$session              = Session::get('userlogin');
				$session['id']        = Session::get('id');
				$session['id_grupo']  = Session::get('id_grupo');
				$session['permissao'] = Session::get('permissao');

				$token = hashCode(dirname($_SERVER['REQUEST_URI']) . time());

				Session::put('userdata', $session);
				Session::put('app_session', $token);

				Session::forget(['userlogin', 'id', 'id_grupo', 'senha', 'permissao', 'login', 'email']);

				return true;

			}

		}

		return false;

	}

	public function create($request)
	{

		$path     = 'assets/embaixada/img/usuarios/';
		$origName = null;
		$fileName = null;
		$imagem   = null;

		if ($request->file('imagem')) {

			$file = $request->file('imagem');

			$fileName = sha1($file->getClientOriginalName());
			$fileExt  = $file->getClientOriginalExtension();

			$imgName = explode('.', ($file->getClientOriginalName()));

			$origName = limpa_string($imgName[count($imgName) - 2], '_') . '.' . $fileExt;
			$imagem   = limpa_string($fileName) . '.' . $fileExt;

			$file->storeAs($path, $imagem);

		}

		$traducao = [];
		$data     = [
			'id_grupo' => $request->grupo,
			'nome'     => $request->nome,
			'email'    => $request->email,
			'login'    => $request->login,
			'status'   => isset($request->status) ? $request->status : '1',
		];

		foreach ($_POST as $ind => $val) {

			$lang = explode(':', $ind);
			if (count($lang) == 2) {
				$traducao[$lang[1]][$lang[0]] = $val;
			}

		}

		if (!is_null($imagem)) {
			$data['imagem'] = $path . $imagem;
		}

		if (!empty($_POST['senha'])) {
			$data['senha'] = hashCode($request->senha);
		}

		return $this->insert($data);

	}

	public function edit($request, $field = null)
	{

		if (is_null($field)) {

			$path     = 'assets/embaixada/img/usuarios/';
			$origName = null;
			$fileName = null;
			$imagem   = null;

			if ($request->file('imagem')) {

				$file = $request->file('imagem');

				$fileName = sha1($file->getClientOriginalName());
				$fileExt  = $file->getClientOriginalExtension();

				$imgName = explode('.', ($file->getClientOriginalName()));

				$origName = limpa_string($imgName[count($imgName) - 2], '_') . '.' . $fileExt;
				$imagem   = limpa_string($fileName) . '.' . $fileExt;

				$file->storeAs($path, $imagem);

			}

			$traducao = [];
			$data     = [
				'id_grupo' => $request->grupo,
				'nome'     => $request->nome,
				'email'    => $request->email,
				'login'    => $request->login,
				'status'   => isset($request->status) ? $request->status : '1',
			];

			foreach ($_POST as $ind => $val) {

				$lang = explode(':', $ind);
				if (count($lang) == 2) {
					$traducao[$lang[1]][$lang[0]] = $val;
				}

			}

			if (!is_null($imagem)) {
				$data['imagem'] = $path . $imagem;
			}

			if (!empty($_POST['senha'])) {
				$data['senha'] = hashCode($request->senha);
			}

			return $this->where('id', $request->id)->update($data);

		} else {

			$data = [$field => $request->value];

			return $this->whereIn('id', $request->id)->update($data);

		}

	}

	public function remove($request)
	{

		return $this->whereIn('id', $request->id)->delete();

	}

}
