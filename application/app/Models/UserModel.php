<?php

namespace App\Models{

	use Illuminate\Foundation\Auth\User as Authenticatable;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\DB;
	use Illuminate\Support\Facades\Session;

	class UserModel extends Authenticatable
	{

		// use HasApiTokens, HasFactory, Notifiable;
		protected $connection = 'mysql2';

		protected $table = 'tb_acl_usuario AS U';

		/**
		 * The attributes that are mass assignable.
		 *
		 * @var array<int, string>
		 */
		protected $fillable = [
			'name',
			'email',
			'password',
		];

		/**
		 * The attributes that should be hidden for serialization.
		 *
		 * @var array<int, string>
		 */
		protected $hidden = [
			'password',
			'remember_token',
		];

		/**
		 * The attributes that should be cast.
		 *
		 * @var array<string, string>
		 */
		protected $casts = [
			'email_verified_at' => 'datetime',
		];

		public $timestamps = false;

		/**
		 * Autentica usuário no sistema
		 */
		public function auth(Request $request)
		{

			$statusCode = 200;

			if (isset($request->login)) {

				$user = $this->select(
					'U.id', 'U.senha', 'U.permissao', 'U.nome', 'U.login', 'U.email',
					'G.id AS id_grupo', 'G.grupo'
				)
					->join('tb_acl_grupo AS G', 'G.id', '=', 'U.id_grupo')
					->where(function ($where) {
						$where->where('U.login', request()->login)
							->orWhere('U.email', request()->login);
					})
					->where('U.status', '1')
					->where('G.status', '1')
					->first();

				if (!isset($user)) {

					$statusCode         = 401;
					$data['status']     = 401;
					$data['statusCode'] = $statusCode;
					$data['message']    = 'Usuário inválido';
					$data['data']       = null;
					$data['errors']     = ['login' => 'Usuário inativo ou removido.'];
					Session::forget('userlogin');

				} else {

					$modulo_path = request()->url;

					$path   = explode(url('/'), $modulo_path);
					$modulo = $path;

					if (count($path) > 0) {
						foreach ($path as $ind => $val) {
							if (!empty($path[$ind])) {
								$modulo = $path[$ind];
								break;
							}
						}
					}

					$path = explode('/', $modulo);

					if (count($path) > 0) {
						foreach ($path as $ind => $val) {
							if (!empty($path[$ind])) {
								$modulo = $path[$ind];
								break;
							}
						}
					}

					$path = '/' . ($modulo);

					/*
					 * Se o usuário não for do grupo "Super Administrador",
					 * deveremos verificar se ele tem autorização para acessar
					 * o módulo.
					 * Se o usuário não tiver permissão para acessar o módulo,
					 * paramos por aqui.
					 */
					if ($user->id_grupo > 1) {

						// Verificar se o usuário está apto a acessar o módulo
						$modulo = $this->from('tb_acl_modulo_grupo AS MG')
							->select('id_grupo', 'id_modulo')
							->join('tb_acl_modulo AS M', 'M.id', '=', 'MG.id_modulo')
							->where('MG.id_grupo', $user->id_grupo)
							->where('M.path', $path)
							->get()
							->first();

						if (!isset($modulo)) {

							$data['status']  = 401;
							$statusCode      = 401;
							$data['message'] = 'Acesso Proibido';
							$data['data']    = null;
							// $data['errors']  = ['login' => 'Usuário não tem permissão para abrir este módulo.'];
							$data['errors'] = ['login' => 'Usuário inativo ou removido.'];

							Session::forget('userlogin');

							return response($data, $statusCode);

						}

					}

					$timestamp  = $path . microtime();
					$token      = uniqid(md5($timestamp));
					$ip         = request()->ip();
					$user_agent = request()->header('user-agent');

					/*
					 * Antes de iniciar uma nova sessão,
					 * precisamos verificar se já existe uma sessão de usuário
					 * iniciada em nossa base de dados.
					 */

					$session_exists = $this->select('id_usuario', 'id_modulo', 'token', 'ip', 'user_agent')
						->from('tb_acl_usuario_session')
						->where('id_usuario', function ($where) {
							$where->select('id')
								->from('tb_acl_usuario')
								->where('login', request()->login)
								->orWhere('email', request()->login);
						})
						->where('ip', request()->ip())
						->where('user_agent', request()->header('user-agent'))
						->whereNull('expired_at')
						->get()
						->first();

					// Se já existir uma sessão ativa, deveremos apenas atualizar aquela sessão

					$modulo = $this->from('tb_acl_modulo AS M')
						->select('id', 'homepage')
						->where('M.path', $path)
						->get()
						->first();

					if (!isset($modulo)) {

						$statusCode         = 401;
						$data['status']     = 401;
						$data['statusCode'] = $statusCode;
						$data['message']    = 'Por favor, atualize a página para acessar este módulo.';
						$data['data']       = null;
						// $data['errors']  = ['login' => 'Por favor, atualize a página.'];

						return response($data, $statusCode);

					}

					if ($session_exists) {

						// Atualiza a sessão, pois,
						// o usuário pode ter voltado para inserir outro nome de usuário
						// e acabou inserindo o mesmo nome.
						$this->from('tb_acl_usuario_session')
							->where('token', $session_exists->token)
							->update([
								'id_modulo'  => $modulo->id,
								'token'      => $token,
								'started_at' => date('Y-m-d H:i:s'),
							]);

					} else {

						$this->from('tb_acl_usuario_session')->insert([
							'id_usuario' => $user->id,
							'id_modulo'  => $modulo->id,
							'token'      => $token,
							'ip'         => $ip,
							'user_agent' => $user_agent,
						]);

					}

					Session::put('userlogin', [
						'id'         => $user->id,
						'nome'       => $user->nome,
						'login'      => $user->login,
						'email'      => $user->email,
						'id_modulo'  => $modulo->id,
						'homepage'   => $modulo->homepage,
						'modulo'     => $path,
						'token'      => $token,
						'ip'         => $ip,
						'user_agent' => $user_agent,
					]);

					$statusCode           = 201;
					$data['data']['user'] = Session::get('userlogin')['nome'];
					$data['message']      = null;
					$data['status']       = 'success';
					$data['statusCode']   = $statusCode;

				}

			}

			if (isset($request->senha)) {

				$user = $this->select(
					'U.id', 'U.senha', 'U.permissao', 'U.nome', 'U.login', 'U.email',
					'G.id AS id_grupo', 'G.grupo', 'G.permissao AS grupo_permissao'
				)
					->join('tb_acl_grupo AS G', 'G.id', '=', 'U.id_grupo')
					->where('U.id', Session::get('userlogin')['id'])
					->where('U.senha', hashCode($request->senha))
					->where(function ($where) {
						$where->where('U.login', Session::get('userlogin')['login'])
							->orWhere('U.email', Session::get('userlogin')['email']);
					})
					->where('U.status', '1')
					->where('G.status', '1')
					->first();

				if (isset($user)) {

					// Session::forget('userlogin');
					// $token = hashCode(dirname($_SERVER['REQUEST_URI']) . time());
					// Verificar todos os privilégios do usuário como Rotas e Acessos

					$this->user = $user;

					$token = Session::get('userlogin')['token'];

					$session[$token] = [
						'id'              => $user->id,
						'nome'            => $user->nome,
						'login'           => $user->login,
						'email'           => $user->email,
						'id_grupo'        => $user->id_grupo,
						'grupo'           => $user->grupo,
						'senha'           => $user->senha,
						'permissao'       => $user->permissao,
						'grupo_permissao' => $user->grupo_permissao,
						'id_modulo'       => Session::get('userlogin')['id_modulo'],
						'modulo'          => Session::get('userlogin')['modulo'],
						'token'           => Session::get('userlogin')['token'],
						'ip'              => Session::get('userlogin')['ip'],
						'user_agent'      => Session::get('userlogin')['user_agent'],
					];

					$url = $this->select('name')
						->from('tb_acl_modulo_routes')
						->where('id', Session::get('userlogin')['homepage'])
						->first();

					if (!isset($url)) {
						$url = $this->select('name')
							->from('tb_acl_modulo_routes')
							->where('id_parent', '0')
							->where('id', function ($query) {
								$query->select(DB::raw('MIN(id) AS id'))
									->from('tb_acl_modulo_routes')
									->where('status', '1')
									->where('type', 'any')
									->where('id_parent', '0')
									->where('id_controller', function ($query) {
										$query->select('id')
											->from('tb_acl_modulo_controller')
											->whereColumn('id', 'id_controller')
											->where('id_modulo', Session::get('userlogin')['id_modulo']);
									});
							})
							->first();
					}

					// Atualiza a última vez que o usuário logou no sistema.
					$this->where('id', $user->id)->update(['ultimo_login' => date('Y-m-d H:i:s')]);

					Session::forget('userlogin');
					Session::put('userdata', $session);
					Session::put('app_session', $token);

					$data['url']           = isset($url) ? route($url->name) : $request->url;
					$data['message']       = 'Usuário logado com sucesso!';
					$data['data']['user']  = Session::get('userdata')[$token]['nome'];
					$data['data']['token'] = Session::get('app_session');
					$data['status']        = 'success';
					$data['statusCode']    = $statusCode;
					$statusCode            = 200;

				} else {

					$statusCode         = 401;
					$data['message']    = 'Usuário inválido';
					$data['data']       = null;
					$data['errors']     = ['senha' => 'senha inválida'];
					$data['status']     = 'error';
					$data['statusCode'] = $statusCode;

				}

			}

			return response($data, $statusCode);

		}

		public function getSessionData($data)
		{

			return Sessin::get($data);

		}

		public function getPrivileges()
		{

			dump(Session::get('userdata'));

		}

	}

}
