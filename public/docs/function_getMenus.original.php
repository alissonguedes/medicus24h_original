	$id = $id == 0 ? null : $id;

		$menu_model = new MenuModel();

		$modulo = explode('/', request()->path())[0];
		$idioma = !isset($_COOKIE['idioma']) ? get_config('language') : $_COOKIE['idioma'];
		$ul     = null;

		// Lista o menu principal da aplicação
		$menu = $menu_model->from('tb_acl_menu')
			->where('id_modulo', function ($query) use ($modulo) {
				$query->select('id')
					->from('tb_acl_modulo')
					->where('path', '/' . $modulo);
			})
			->where('id', function ($query) use ($local) {
				$query->select('value')
					->distinct(true)
					->from('tb_sys_config')
					->where('config', $local)
					->where('value', get_config($local))
					->whereColumn('id_modulo', 'id_modulo');
			})
			->where('status', '1')
			->get()
			->first();

		// lista outros menus que são incluídos na aplicação
		if (!isset($menu)) {
			$menu = $menu_model->from('tb_acl_menu')
				->where('id_modulo', function ($query) use ($modulo) {
					$query->select('id')
						->from('tb_acl_modulo')
						->where('path', '/' . $modulo);
				})
				->where('id', function ($query) use ($local) {
					$query->select('id_menu')
						->from('tb_acl_menu_descricao')
						->whereColumn('id_menu', 'id')
						->where('descricao', $local);
				})
				->get()
				->first();
			// $ul .= 'Nenhum menu neste módulo';
		}

		iif (isset($menu)) {
			$items = $menu_model->from('tb_acl_menu_item')
				->where('id_menu', $menu->id)
				->where('id_parent', $id)
				->orderBy('ordem', 'asc')
				->where('status', '1')
			// ->whereIn('id_item', function ($query) use ($menu) {
			// $query->select('id')
			// 	->from('tb_acl_modulo_controller AS C')
			// 	->whereColumn('C.id', 'id_item')
			// 	->where('C.status', '1')
			// 	->whereIn('C.id', function ($query) use ($menu) {
			// 		$query->select('id_controller')
			// 			->from('tb_acl_modulo_routes AS R')
			// 			->whereColumn('R.id_controller', 'C.id');
			// 		// ->where('R.status', '1');
			// 	})
			// // $query->select('id_controller')
			// 	->from('tb_acl_modulo_routes')
			// 	->whereColumn('id_controller', 'id_item')
			// 	->where('status', '1')
			// // ->where('type', 'any')
			// 	->where('id_parent', '0')
			// ;
			// })
				->get();

			if ($items->count() > 0) {
				$params = null;
				if (!empty($attributes)) {
					foreach ($attributes as $ind => $val) {
						$params .= ' ' . $ind . '="' . $val . '"';
					}
				}

				$ul = '<ul' . $params . '>';

				foreach ($items as $item) {

					$label = $menu_model->from('tb_acl_menu_item_descricao')
						->where('id_item', $item->id)
						->where('id_idioma', function ($query) {
							$query->select('id')
								->from('tb_sys_idioma')
								->where('sigla', (isset($_COOKIE['idioma']) ? $_COOKIE['idioma'] : get_config('language')))
								->get()
								->first();
						})
						->get()
						->first();

					// Se não existir uma tradução válida para o Idioma selecionado, será obtido o Idioma padrão
					if (!isset($label)) {
						$label = $menu_model->from('tb_acl_menu_item_descricao')
							->where('id_item', $item->id)
							->where('id_idioma', function ($query) {
								$query->select('id')
									->from('tb_sys_idioma')
									->where('sigla', get_config('language'))
									->get()
									->first();
							})
							->get()
							->first();
					}

					if (!isset($label)) {
						$label = (object) ['titulo' => 'no title'];
					}

					$submenus = $menu_model->from('tb_acl_menu_item')
						->where('id_parent', $item->id)
						->where('status', '1')
						->get();

					$route = $menu_model->select('name')
						->from('tb_acl_modulo_routes')
						->where('status', '1')
						->where('type', 'any')
						->where(function ($query) {
							$query->where('id_parent')
								->orWhere('id_parent', '0');
						})
						->where('id_controller', $item->id_item);

					$id_route = $item->id_route > 0 ? $item->id_route : null;

					if (!is_null($id_route)) {
						$route->where('id', $id_route);
					}

					$route = $route->first();

					if (isset($route)) {

						if ($item->divider) {
							$ul .= '<li class="divider" style="margin: 10px 0;"></li>';
						}

						if ($item->item_type) {
							$ul .= '<li class="menu-description"><h6 style="padding-left: 25px; color: var(--grey-accent-4); font-size: 10px; line-height: 3; text-transform: uppercase; font-weight: bold;">' . $item->item_type . '</h6></li>';
						}

						$ul .= '<li>';

						$target = 'target="' . $item->target . '"' ?? null;
						$a      = null;

						if ($submenus->count() > 0) {
							$a = 'class="collapsible-header waves-effect waves-cyan" href="javascript:void(0);" tabindex="0"';
						} else {
							if (isset($route)) {
								$a = 'href="' . route($route->name) . '"';
							} else {
								$a = 'href="#"';
							}
						}

						$ul .= '<a ' . $a . ' ' . $target . '>';
						$ul .= $item->icon ? (preg_match('[^fa\-]', $item->icon) ? '<span class="fa-icon fa-solid ' . $item->icon . '"></span>' : '<span class="material-symbols-outlined">' . $item->icon . '</span>') : '<span class="material-symbols-outlined">radio_button_unchecked</span>';

						$ul .= '<span class="menu-title">' . $label->titulo . '</span>';
						$ul .= '</a>';

						if ($submenus->count() > 0) {
							$ul .= '<div class="collapsible-body">';
							$ul .= getMenus($local, $item->id, [
								'class'            => 'collapsible collapsible-sub',
								'data-collapsible' => 'accordion',
							]);
							$ul .= '</div>';
						}

						$ul .= '</li>';

					}

				}

				$ul .= '</ul>';
			}
		}

		return $ul;
