<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Session;

class ConfigModel extends Authenticatable
{

	use HasFactory, Notifiable;

	protected $table = 'tb_sys_config';

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

	private $order = [
		null,
		'descricao',
		'status',
	];

	public function __construct()
	{
		$this->connection = env('DB_CONNECTION_2');
	}

	public function debug($get)
	{
		echo '==> ';
		echo '<br>';
		$query = str_replace(array('?'), array('\'%s\''), $get->toSql());
		$query = vsprintf($query, $get->getBindings());
		dump($query);
		echo '<br>';
		echo '==> ';
	}

	public function getConfigByKey($find = null)
	{

		$get = $this->select('U.value')
			->from('tb_acl_usuario_config AS U')
			->join('tb_sys_config AS C', 'C.id', '=', 'U.id_config')
			->where('C.config', $find);

		if (Session::has('userdata')) {
			$get->where('U.id_usuario', Session::get('userdata')[Session::get('app_session')]['id']);
		}

		$config = $get->get()
			->first();

		if (isset($config)) {
			return $config->value;
		}

		$config = $this->select('value')
			->from('tb_sys_config')
			->where('config', $find)
			->where('id_modulo', function ($query) {
				$modulo = explode('/', request()->path())[0];
				return $query->select('id')
					->from('tb_acl_modulo')
					->where('path', '/' . $modulo);
			})
			->get()
			->first();

		if (isset($config)) {
			return $config->value;
		}

		return null;

	}

	public function getConfig_old($find = null)
	{

		$get = $this->select('id', 'config', 'value');

		if (!is_null($find)) {
			$get->where('config', $find);
			$get->orWhere('id', $find);
			return $get;
		}

		// if (isset($_GET['search']['value']) && !empty($_GET['search']['value'])) {
		//     $get->where(function ($get) {
		//         $search = $_GET['search']['value'];
		//         $get->orWhere('id', 'like', $search . '%')
		//             ->orWhere('config', 'like', $search . '%')
		//             ->orWhere('value', 'like', $search . '%');
		//     });
		// }

		// Order By
		if (isset($_GET['order']) && $_GET['order'][0]['column'] != 0) {
			$orderBy[$this->order[$_GET['order'][0]['column']]] = $_GET['order'][0]['dir'];
		} else {
			$orderBy[$this->order[1]] = 'desc';
		}

		foreach ($orderBy as $key => $val) {
			$get->orderBy($key, $val);
		}

		return $get->paginate($_GET['length'] ?? null);

	}

	public function patch($request)
	{

		$return     = null;
		$id_usuario = Session::get('userdata')[Session::get('app_session')]['id'];
		$id_grupo   = Session::get('userdata')[Session::get('app_session')]['id_grupo'];

		foreach ($request as $ind => $val) {

			$config = $this->select('U.id_usuario', 'U.id_config', 'U.value')
				->from('tb_acl_usuario_config AS U')
				->join('tb_sys_config AS C', 'C.id', '=', 'U.id_config')
				->where('C.config', $ind)
				->where('U.id_usuario', $id_usuario)
				->get()
				->first();

			if (isset($config)) {

				$return = $this->from('tb_acl_usuario_config')
					->where('id_usuario', $config->id_usuario)
					->where('id_config', $config->id_config)
					->update(['value' => $val]);

			} else {

				$config = $this->select('id', 'id_modulo', 'config', 'value')
					->from('tb_sys_config')
					->where('config', $ind)
					->where('id_modulo', function ($query) {
						$modulo_path = request()->path();
						$path        = explode('/', $modulo_path);
						$path        = '/' . $path[0];
						$modulo      = $query->from('tb_acl_modulo')
							->select('id')
							->where('path', $path);
					})
					->get()
					->first();

				$return = $this->from('tb_acl_usuario_config')
					->insert([
						'id_usuario' => $id_usuario,
						'id_modulo'  => $config->id_modulo,
						'id_config'  => $config->id,
						'value'      => $val,
					]);

				// if (isset($config)) {
				//     $return = $this->from('tb_sys_config')
				// 		->where('id', $config->id)
				// 		->where('id_modulo', $config->id_modulo)
				// 		->update(['value'=>$val]);
				// }

			}

		}

		if ($return) {
			$data['status']  = 'success';
			$data['message'] = 'Suas preferências foram salvas.';
			$data['data']    = null;
			$statusCode      = 200;
		} else {
			$data['status']  = 'error';
			$data['message'] = 'Erro ao salvar preferências.';
			$data['data']    = null;
			$data['errors']  = [];
			$statusCode      = 200;
		}

		return response($data, $statusCode);

	}

	public function create($request)
	{

		$data     = [];
		$path     = 'assets/embaixada/img/';
		$origName = null;
		$fileName = null;
		$imagem   = null;

		if ($request->file('site_logo')) {

			$file = $request->file('site_logo');

			$fileName = sha1($file->getClientOriginalName());
			$fileExt  = $file->getClientOriginalExtension();

			$imgName = explode('.', ($file->getClientOriginalName()));

			$origName = limpa_string($imgName[count($imgName) - 2], '_') . '.' . $fileExt;
			$imagem   = limpa_string($fileName) . '.' . $fileExt;

			$file->storeAs($path, $imagem);

			$data[] = ['config' => 'site_logo', 'value' => $path . $imagem];
			$data[] = ['config' => 'original_logo_name', 'value' => $origName];

		}

		$traducao = [];

		foreach ($_POST as $ind => $val) {
			if ($ind !== 'site_logo') {
				$data[] = ['config' => $ind, 'value' => (!empty($val) ? $val : null)];
			}

		}

		for ($i = 0; $i < count($data); $i++) {

			$issetConfig = $this->select('config', 'value')->where('config', $data[$i]['config'])->first();

			if (isset($issetConfig)) {
				if ($data[$i]['value'] != $issetConfig->value) {
					$this->where('config', $data[$i]['config'])->update($data[$i]);
				}
			} else {
				$this->insert($data[$i]);
			}

		}

		return true;

	}

}
