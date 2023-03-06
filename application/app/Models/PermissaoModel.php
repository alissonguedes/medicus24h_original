<?php

namespace App\Models{

	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Support\Facades\Session;

	class PermissaoModel extends Model
	{

		use HasFactory;

		public function __construct()
		{
			$this->connection = env('DB_CONNECTION_2');
		}

		public function getPermissao($rota = null)
		{

			$this->session = Session::get('userdata')[Session::get('app_session')];
			return $this->from('tb_acl_modulo_routes AS Rota')
				->where('name', $rota)
				->where('status', '1')
				->where(function ($where) {
					$where->orWhere('Rota.permissao', '<=', $this->session['permissao']);
					$where->orWhere('Rota.permissao', '<=', $this->session['grupo_permissao']);
				})
			// ->whereIn('C.id', function ($query) {
			// 	$query->select('id_controller')
			// 		->from('tb_acl_menu_item')
			// 		->whereIn('id', function ($query) {
			// 			$query->select('id_item')
			// 				->from('tb_acl_menu_item_menu')
			// 				->whereColumn('id_item', 'id');
			// 		});
			// })
				->get()->first() ? true : false;

		}

		public function checkPermissao($route)
		{

			$this->session = Session::get('userdata')[Session::get('app_session')];

			return $this->from('tb_acl_modulo_routes AS Rota')
				->where('name', $route)
				->where('status', '1')
			// ->where(function ($where) {
			// 	$where->orWhere('Rota.permissao', '<=', $this->session['permissao']);
			// 	$where->orWhere('Rota.permissao', '<=', $this->session['grupo_permissao']);
			// })
				->where('id_controller', function ($query) {
					$query->select('id')
						->from('tb_acl_modulo_controller')
						->whereIn('id', function ($query) {
							$query->select('id_controller')
								->from('tb_acl_menu_item')
								->whereColumn('id_controller', 'id')
								->whereIn('id', function ($query) {
									$query->select('id_item')
										->from('tb_acl_menu_item_menu')
										->whereColumn('id_item', 'id');
									// ->where('')
								});
						});
				})
				->get()->first() ? true : false;

		}

	}

}
