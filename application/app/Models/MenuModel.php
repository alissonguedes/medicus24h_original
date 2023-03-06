<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MenuModel extends Model
{

	use HasFactory;

	protected $table = 'tb_acl_menu';

	protected $order = [
		null,
		'titulo',
		'tb_acl_menu.created_at',
		'tb_acl_menu.updated_at',
		'tb_acl_menu.status',
		null,
	];

	public function __construct()
	{
		$this->connection = env('DB_CONNECTION_2');
	}

	public function getMenus($menu = null)
	{

		$get = $this->select(
			'tb_acl_menu.id',
			DB::raw('(SELECT titulo FROM tb_acl_menu_descricao WHERE id_menu = tb_acl_menu.id AND id_idioma = ' . DB::raw('(SELECT id FROM tb_sys_idioma WHERE sigla = "' . $_COOKIE['idioma']) . '")) AS titulo'),
			DB::raw('(SELECT descricao FROM tb_acl_menu_descricao WHERE id_menu = tb_acl_menu.id AND id_idioma = ' . DB::raw('(SELECT id FROM tb_sys_idioma WHERE sigla = "' . $_COOKIE['idioma']) . '")) AS slug'),
			'tb_acl_menu.created_at',
			'tb_acl_menu.updated_at',
			'tb_acl_menu.status'
		);

		// $get->join('tb_acl_modulo_grupo AS G', 'G.id_menu', '=', 'tb_acl_menu.id');

		// $get->join('tb_acl_menu_descricao AS D', 'D.id_menu', '=', 'tb_acl_menu.id');
		// $get->join('tb_sys_idioma AS I', 'I.id', '=', 'D.id_idioma');

		// $get->where('status', '1');

		// if (!is_null($menu)) {
		// 	$get->where('slug', $menu);
		// 	$get->orWhere('link', $menu);
		// }

		if (isset($_GET['search']['value']) && !empty($_GET['search']['value'])) {
			$get->where(function ($query) {
				$query
					->orWhere('D.titulo', 'like', $_GET['search']['value'] . '%')
					->orWhere('D.descricao', 'like', $_GET['search']['value'] . '%')
					->orWhere('D.meta_description', 'like', $_GET['search']['value'] . '%')
					->orWhere('D.meta_title', 'like', $_GET['search']['value'] . '%')
					->orWhere('D.meta_keywords', 'like', $_GET['search']['value'] . '%');
			});

		}

		// $this->orderBy($request->post('order')[0]['column']);
		// Order By
		if (isset($_GET['order']) && $_GET['order'][0]['column'] != 0) {
			$get->orderBy($this->order[$_GET['order'][0]['column']], $_GET['order'][0]['dir']);
		} else {
			$get->orderBy($this->order[1], 'asc');
		}

		return $get;

	}

	public function getMenuById($menu = null)
	{
		return $this->getMenus()
			->join('tb_acl_menu_descricao', 'tb_acl_menu_descricao.id_menu', '=', 'tb_acl_menu.id')
			->where('tb_acl_menu.id', $menu)
			->first();
	}

	public function insertMenu($post)
	{

		$titulo    = $post->titulo;
		$modulo    = $post->modulo;
		$id_idioma = 1;
		$id_menu   = $this->insertGetId(['id_modulo' => $modulo]);
		$data      = [
			'id_menu'   => $id_menu,
			'id_idioma' => $id_idioma,
			'titulo'    => $titulo,
			'descricao' => limpa_string($titulo),
		];

		$this->from('tb_acl_menu_descricao')
			->insert($data);

		return $id_menu;

	}

}
