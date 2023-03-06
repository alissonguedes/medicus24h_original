<?php

use App\Models\ConfigModel;
use App\Models\MenuModel;
use App\Models\ModuloModel;
use Illuminate\Support\Facades\DB;

if (!function_exists('data')) {
	function data($data, $format = 'd.m.Y H:i:s', $new_format)
	{
		$mes  = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
		$data = date($format, strtotime($data));
		$data = preg_replace('/\.(\d){2}\./', $new_format . $mes[date('m', strtotime($data)) - 1] . $new_format, $data);

		return $data;
	}
}

if (!function_exists('idade')) {

	function idade($data, $exibir_horas = false)
	{

		if (!$data) {
			return 'Idade não informada';
		}

		$date  = date('Y-m-d', strtotime(str_replace('/', '-', $data)));
		$date  = date_create($date);
		$hoje  = date_create();
		$idade = date_diff($date, $hoje);

		$ano = $idade->y > 0 ? ($idade->y . ($idade->y === 1 ? ' ano' : ' anos')) : null;
		$mes = $idade->m > 0 ? ($idade->m . ($idade->m === 1 ? ' mês' : ' meses')) : null;
		$dia = $idade->d > 0 ? ($idade->d . ($idade->d === 1 ? ' dia' : ' dias')) : null;

		$tempo = $ano . ($ano && $mes ? ', ' : null) . $mes . ($dia ? ' e ' : null) . $dia;

		if ($exibir_horas) {
			$tempo .= ' - ' . $idade->h . 'h' . $idade->i . 'm' . $idade->s . 's';
		}

		return $tempo;

	}

}

if (!function_exists('date_translate')) {
	function date_translate($input_date, $input_format)
	{

		$to_format   = null;
		$output      = null;
		$str         = null;
		$calendar    = [];
		$days        = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];
		$shortDays   = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];
		$abrevDays   = ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'];
		$months      = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
		$monthsShort = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];

		// $output         = null;
		// $str            = null;
		// $calendar       = [];
		// $days           = ['Sunday' => 'Domingo', 'Monday' => 'segunda', 'Tuesday' => 'Terça', 'Wednesday' => 'Quarta', 'Thursday' => 'Quinta', 'Friday' => 'Sexta', 'Saturday' => 'Sábado'];
		// $shortDays      = ['Sun' => 'Dom', 'Mon' => 'Seg', 'Tue' => 'Ter', 'Wed' => 'Qua', 'Thu' => 'Qui', 'Fri' => 'Sex', 'Sat' => 'Sáb'];
		// $months         = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
		// $monthsShort    = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
		// $weekdays       = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];
		// $weekdaysShort  = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];
		// $weekdaysAbbrev = ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'];

		// $format  = limpa_string($input_format, '-', false); // preg_replace(/' ', '.', ':', '-', '/', '\d\e'], ' ', $format);
		$formats = explode(' ', $input_format);
		// echo '-> ';
		// print_r($formats);

		$date = limpa_string($input_date, '-', false);
		$date = explode('-', $date);

		foreach ($formats as $f) {

			$d = strtotime($input_date);

			if (limpa_string($f, '', false) === 'l') {
				$calendar[] = $days[date('w', $d)];
			}

			if (limpa_string($f, '', false) === 'd') {
				$calendar[] = date('d', $d);
			}

			if (limpa_string($f, '', false) === 'D') {
				$calendar[] = $shortDays[date('w', $d)];
			}

			if (limpa_string($f, '', false) === 'F') {
				$calendar[] = $months[date('n', $d) - 1];
			}

			if (limpa_string($f, '', false) === 'Y') {
				$calendar[] = date('Y', $d);
			}

			if (limpa_string($f, '', false) === 'y') {
				$calendar[] = date('y', $d);
			}

			$h = limpa_string($f, ' ', false);
			$h = explode(' ', $h);

			if ((isset($h[0]) && $h[0] === 'H') || limpa_string($f, '', false) === 'H') {
				$calendar[] = date('H', $d);
			}

			if ((isset($h[1]) && $h[1] === 'i') || limpa_string($f, '', false) === 'i') {
				$calendar[] = date('i', $d);
			}

			if ((isset($h[2]) && $h[2] === 's') || limpa_string($f, '', false) === 's') {
				$calendar[] = date('s', $d);
			}

			if (preg_match('/\{[a-z0-9]+\}/', $f)) {
				$calendar[] = str_replace(['{', '}'], '', $f);
			}

		}

		if (preg_match('/\{[a-z0-9]+\}/', $input_format)) {

			preg_match_all('/\{[a-z]+\}/', $input_format, $out);
			$f = str_replace(['{', '}'], '', $out[0][0]);
			$f = addcslashes($f, 'a..z');

			$to_format = preg_replace('/\{[a-z]+\}/', $f, $input_format);

		}

		$ex = explode(' ', $input_format);

		foreach ($ex as $ind => $e) {

			if (preg_match('/\{[a-z0-9]+\}/', $e)) {
				$f        = addcslashes($e, 'a..z');
				$o        = str_replace(['{', '}'], '', $f);
				$output[] = $e;
			} else {
				$f  = limpa_string($e, ' ', false);
				$ex = explode(' ', $f);

				if (count($ex) > 1) {
					foreach ($ex as $i => $a) {
						$output[$ind + $i] = $a;
					}
				} else {
					if (!empty($f)) {

						if (preg_match('/\{[a-z0-9]+\}/', $f)) {
							$o        = addcslashes($f, 'a..z');
							$o        = str_replace(['{', '}'], '', $o);
							$output[] = $o;
						} else {
							$o        = $f;
							$output[] = $o;
						}
					}
				}
			}

		}

		$out = date($to_format, strtotime($input_date));

		$f = explode(' ', $to_format);

		$c = null;
		for ($i = 0; $i < count($f); $i++) {

			preg_match_all('/\,|\/|\.|\:|\-|\/\s/', $f[$i], $separator);

			if (count($separator[0]) > 0 && count($separator[0]) < 2) {

				$scal = null;

				for ($s = 0; $s <= count($separator[0]); $s++) {

					if ($scal != $calendar[$i]) {
						$scal = $calendar[$i + $s];
					} else {
						$scal = '';
					}

					$c .= $scal;

					if ($s < count($separator[0])) {
						$c .= $separator[0][$s];
					}

				}

			} else {

				$c .= $calendar[$i];

				if (count($separator[0]) > 1) {
					for ($s = 0; $s <= count($separator); $s++) {
						$c .= $separator[0][$s] . $calendar[$i + $s + 1];
					}
				}

			}

			$c .= ' ';

		}

		return $c;

	}

}

if (!function_exists('convert_to_date')) {
	function convert_to_date($input_date, $to_format = 'Y-m-d', $bd = true)
	{

		$format   = null;
		$datetime = explode(' ', $input_date);

		// if (count($datetime) > 1) {
		// 	$date_str = $datetime[0];
		// 	$time_str = $datetime[1];
		// } else {
		// 	$date_str = $input_date;
		$time_str = null;
		// }

		$date_str = str_replace(['-', '/'], '-', $input_date);

		if (preg_match('/^(\d{2})\-(\d{2})-(\d{4})$/', $date_str)) {
			// $date = explode('-', $input_date);
			// $date = array_reverse($date);
			// $date = implode('-', $date);
			$date = strtotime($date_str);
			$date = date($to_format, $date);
		} else if (preg_match('/^(\d{2})\-(\d{2})\-(\d{4})(\s)(\d{2})\:(\d{2})(\:(\d{2}))?$/', $date_str)) {
			$date = strtotime($date_str);
			$date = date($to_format, $date);
		} else if (preg_match('/(\d{4})\-(\d{2})\-(\d{2})((\d{2})\:(\d{2})(\:(\d{2}))?)/', $date_str)) {
			$date = $date_str . (!is_null($time_str) ? ' ' . $time_str : null);
		} else if (preg_match('/^([dDjlLNSwWzFmMntoYyaABgGhHisueIOPTZcrU]((\s?\W?)?)+)+$/', $date_str)) {
			$format = $date_str;
			$date   = date($format, strtotime('now'));
		}

		if (is_null($format)) {
			$format = !is_null($time_str) ? 'Y-m-d H:i:s' : 'Y-m-d';
		}

		if (!$bd) {
			// try {

			// $date = \Carbon\Carbon::createFromFormat($to_format, $date)->format($to_format);

			$datec = strtotime($date);
			$datec = date('Y-m-d H:i:s', $datec);
			// $datec = date_format($d, $to_format);

			// echo $datec;

			// return $date;

			return date_translate($datec, $to_format);

			// } catch (Exception $e) {
			// 	throw new ErrorException($to_format . ' ' . $e);
			// }
		} else {

			$date = \Carbon\Carbon::createFromFormat($to_format, $date)->format($format);

			return $date;

		}

	}

}

if (!function_exists('get_config')) {
	function get_config($config)
	{
		$cfg = new ConfigModel();
		// return $cfg->getConfigByKey($config)->first()->value ?? null;
		return $cfg->getConfigByKey($config) ?? null;
	}
}

function tradutor($traducao, $lang = null, $except = null)
{
	$idioma = is_null($lang) ? (isset($_COOKIE['idioma']) ? $_COOKIE['idioma'] : get_config('language')) : $lang;

	// Formata a data e hora de acordo com o Idioma
	if (is_object($traducao)) {
		$date = (string) $traducao;

		switch ($idioma) {
			case 'en':$formato = 'Y-m-d h:ia';
				break;
			case 'pt-br':$formato = 'd/m/Y H\hi';
				break;
			case 'hr':$formato = 'd-m-y h:ia';
				break;
		}

		return date($formato, strtotime($date));
	}

	$return = is_string($traducao) ? json_decode($traducao, true) : $traducao;

	if (is_array($return) && array_key_exists($idioma, $return)) {
		if (!empty($return[$idioma])) {
			return $return[$idioma];
		}
	} else {
		return tradutor([$idioma => $traducao]);
	}

	$catch = [
		'en'    => 'Translation not available for this language',
		'hr'    => 'A fordítás nem érhetó el ezen a nyelven',
		'pt-br' => 'Tradução não disponível para este idioma',
	];

	$except = !is_null($except) ? $except : $catch;

	return $except[$idioma];
}

if (!function_exists('hashCode')) {
	function hashCode($str, $min = 32, $max = 92)
	{
		$pass          = hash('whirlpool', $str);
		$salt          = hash('sha512', $str);
		$password      = substr($pass, $min, 92) . substr($salt, $min, 54);
		$password_hash = hash('sha512', hash('md5', $password));
		$hash          = substr(hash('whirlpool', hash('sha512', $pass . $salt . $password . $password_hash)), 0, 90);

		return !empty($str) ? substr(hash('whirlpool', hash('sha512', $hash)), 0, 77) : null;

		// return !empty($str) ? substr(hash('sha512', $str), 0, 50) : null;
	}
}

function configuracoes()
{
}

/**
 * Remove caratecres especiais
 * Converte todos os caracteres de um arquivo para caixa baixa
 * Remove espaçamentos.
 */
function limpa_string($string, $replace = '-', $to_lower = true)
{
	$output = [];
	$a      = ['Á' => 'a', 'À' => 'a', 'Â' => 'a', 'Ä' => 'a', 'Ã' => 'a', 'Å' => 'a', 'á' => 'a', 'à' => 'a', 'â' => 'a', 'ä' => 'a', 'ã' => 'a', 'å' => 'a', 'a' => 'a', 'Ç' => 'c', 'ç' => 'c', 'Ð' => 'd', 'É' => 'e', 'È' => 'e', 'Ê' => 'e', 'Ë' => 'e', 'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e', 'Í' => 'i', 'Î' => 'i', 'Ï' => 'i', 'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i', 'Ñ' => 'n', 'ñ' => 'n', 'Ó' => 'o', 'Ò' => 'o', 'Ô' => 'o', 'Ö' => 'o', 'Õ' => 'o', 'ó' => 'o', 'ò' => 'o', 'ô' => 'o', 'ö' => 'o', 'õ' => 'o', 'ø' => 'o', 'œ' => 'o', 'Š' => 'o', 'Ú' => 'u', 'Ù' => 'u', 'Û' => 'u', 'Ü' => 'u', 'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u', 'Ý' => 'y', 'Ÿ' => 'y', 'ý' => 'y', 'ÿ' => 'y', 'Ž' => 'z', 'ž' => 'z'];
	$string = strtr($string, $a);
	$regx   = [' ', '.', '+', '@', '#', '!', '$', '%', '¨', '&', '*', '(', ')', '_', '-', '+', '=', ';', ':', ',', '\\', '|', '£', '¢', '¬', '/', '?', '°', '´', '`', '{', '}', '[', ']', 'ª', 'º', '~', '^', "\'", '"'];

	$tolowercase = $to_lower ? strtolower($string) : $string;
	$replacement = str_replace($regx, '|', trim($tolowercase));
	$explode     = explode('|', $replacement);

	for ($i = 0; $i < count($explode); ++$i) {
		if (!empty($explode[$i])) {
			$output[] = trim($explode[$i]);
		}
	}

	return implode($replace, $output);
}

function download($path, $filename)
{
	$headers = null;

	// $headers .= ('Content-Description: File Transfer');
	// $headers .= ('Content-Type: application/octet-stream');
	// $headers .= ('Content-Disposition: attachment; filename=' . $filename);
	// $headers .= ('Content-Transfer-Encoding: binary');
	// $headers .= ('Expires: 0');
	// $headers .= ('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	// $headers .= ('Pragma: public');
	// $headers .= ('Content-Length: ' . Storage::size($path));

	return Storage::download($path, $filename);
}

/**
 * Função para exibir o endereço.
 *
 * @param array $config [ col, set, div ]
 * @param col => string - the column name
 * @param set => boolean - show or hide from list
 * @param div => string - separator caracter
 * @param array [ 'col' => 'column1', 'set' => boolean, 'div' => '<separator>']
 */
function exibir_endereco(array $config = [
	[
		'col' => 'address',
		'set' => true,
		'div' => ', ',
	],
	[
		'col' => 'address_nro',
		'set' => true,
		'div' => '<br> ',
	],
	[
		'col' => 'cep',
		'set' => true,
		'div' => ' - ',
	],
	[
		'col' => 'bairro',
		'set' => true,
		'div' => ', ',
	],
	[
		'col' => 'complemento',
		'set' => true,
		'div' => '<br>',
	],
	[
		'col' => 'cidade',
		'set' => true,
		'div' => ', ',
	],
	[
		'col' => 'uf',
		'set' => true,
		'div' => ' - ',
	],
	[
		'col' => 'pais',
		'set' => true,
		'div' => '',
	],
]) {
	$endereco = null;

	foreach ($config as $ind => $val) {
		$local = null;

		if (!empty($val) && !is_null($config[$ind++])) {
			if (!empty(get_config($val['col']))) {
				$local = get_config($val['col']);
			}

			if ($ind < count($config)) {
				if (!is_null(get_config($config[$ind++]['col']))) {
					/*
					 * Aqui, verifica se a condição do próximo array
					 * é válida para exibir o próximo caráctere separador
					 */
					if (!is_null($local)) {
						if ($ind < count($config)) {
							$local .= $val['div'];
						}
					}
				}
			}
		}

		$endereco .= $local;
	}

	return $endereco;
}

if (!function_exists('base_url')) {
	function base_url()
	{

		$path     = '/';
		$base_url = explode('/', request()->getRequestUri());

		foreach ($base_url as $ind => $base) {

			if ($base_url[$ind] == '') {
				$base_url[$ind] = '/';
			}

			$dir = app_path() . '/Http/Controllers/' . ucfirst(str_replace('/', '', $base_url[$ind]));
			if ($base_url[$ind] != '/' && is_dir($dir)) {
				$path = $base;
				break;
			}

		}

		return url($path) . '/';

	}
}

if (!function_exists('site_url')) {
	function site_url()
	{

		return url('/') . '/';

	}
}

/*
 * Fução para obter os menus da página
 */
if (!function_exists('getMenus')) {

	/*
	 * Novo menu
	 * O menu antigo não separava por grupos
	 */
	function getMenus($local, $id, $attributes = [])
	{

		$ul = null;

		$menuModel   = new MenuModel();
		$moduloModel = new ModuloModel();
		$modulo      = explode('/', request()->path())[0];
		$modulo      = '/' . $modulo;

		$idModulo = $moduloModel->select('id')
			->from('tb_acl_modulo')
			->where('path', $modulo)
			->get()
			->first();

		$getMenus = $menuModel->select('Menu.*')
			->from(DB::raw('tb_acl_menu AS Menu, tb_acl_modulo AS Modulo, tb_acl_modulo_menu AS MMenu'))
			->whereColumn('MMenu.id_menu', 'Menu.id')
			->whereColumn('MMenu.id_modulo', 'Modulo.id')
			->where('Modulo.id', function ($query) use ($modulo) {
				$query->select('id')
					->from('tb_acl_modulo')
					->where('path', $modulo);
			})

		// ->where('id', function ($query) use ($local) {
		// 	$query->select('value')
		// 		->from('tb_sys_config')
		// 		->where('config', $local)
		// 		->where('value', get_config($local))
		// 		->whereColumn('id_modulo', 'id_modulo');
		// })

			->where('Menu.status', '1')
			->where('Modulo.status', '1')
			->where('MMenu.status', '1');

		if ($moduloModel->getIsRestrictModulo($modulo)) {

			if (session()->exists('userdata') && session()->exists('app_session')) {
				$getMenus = $getMenus->where('Menu.id_grupo', session()->get('userdata')[session()->get('app_session')]['id_grupo']);
			}

		}

		$getMenus = $getMenus->get();

		if ($getMenus->count() > 0) {

			foreach ($getMenus as $menu) {

				$items = $menuModel->select('Item.*')
					->from(DB::raw('tb_acl_menu_item AS Item'))
					->where('id_parent', $id)
					->whereIn('Item.id', function ($query) use ($menu) {
						$query->select('id_item')
							->from('tb_acl_menu_item_menu')
							->whereColumn('id_item', 'id')
							->where('status', '1')
							->where('id_menu', $menu->id);
					})
					->orderBy('ordem', 'asc')
					->orderBy('descricao', 'asc')
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

						$submenus = $menuModel->from('tb_acl_menu_item')
							->where('id_parent', $item->id)
							->where('status', '1')
							->get();

						$route = $menuModel->select('name')
							->from('tb_acl_modulo_routes')
							->where('status', '1')
							->where('type', 'any')
							->where(function ($query) {
								$query->where('id_parent')
									->orWhere('id_parent', '0');
							})
							->where('id_controller', $item->id_controller);

						$id_route = $item->id_route > 0 ? $item->id_route : null;

						if (!is_null($id_route)) {
							$route->where('id', $id_route);
						}

						$route = $route->first();

						if (isset($route)) {

							$label = $menuModel->select('descricao AS titulo')
								->from('tb_acl_menu_item_descricao')
								->where('id_item', $item->id)
								->first();

							if (!isset($label)) {
								$label = (object) ['titulo' => 'no title'];
							}

							if ($item->divider) {
								$ul .= '<li class="divider" style="margin: 10px 0;"></li>';
							}

							if ($item->item_type) {
								$ul .= '<li class="menu-description"><h6 style="padding-left: 25px; color: var(--grey-accent-4); font-size: 10px; line-height: 3; text-transform: uppercase; font-weight: bold;">' . $item->item_type . '</h6></li>';
							}

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

							$ul .= '<li>';

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

							$ul .= ' </li>';

						}

					}

					$ul .= '</ul>';

				}

			}

		}

		return $ul;

	}

}

if (!function_exists('RecursiveRemove')) {
	function RecursiveRemove($path)
	{

		die('Para utilizar esta função, comente esta linha dentro do arquivo.');

		$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));

		$files = null;

		foreach ($rii as $file) {

			if ($file->isDir()) {
				continue;
			}

			$files = $file->getPathname();
			unlink($files);

		}

	}
}

if (!function_exists('go')) {

	function go($url, $params = null)
	{

		$route  = $url;
		$modulo = new App\Models\ModuloModel();

		$route = $modulo->getRoute($url);

		return isset($route->name) ? route($route->name, $params ?? null) : $route;

	}

}

if (!function_exists('gera_cartao')) {

	function gera_cartao($codigo = null, $format = false, $separator = ' ')
	{

		$faker = new Faker\Factory();

		if (empty($codigo)) {

			$codigo = $faker->create('pt_BR')->imei();

		}

		if (!isValidImei($codigo)) {
			return $codigo . ' -> not Valid';
		}

		if ($format) {
			$number = substr($codigo, 0, 3) . $separator . substr($codigo, 3, 3) . $separator . substr($codigo, 6, 6) . $separator . substr($codigo, 12, 3);
		} else {
			$number = $codigo;
		}

		return $number;
	}

	function sumDig($n)
	{
		$a = 0;
		while ($n > 0) {
			$a = $a + $n % 10;
			$n = $n / 10;
		}
		return $a;
	}

	function isValidImei($n)
	{

		$s   = (string) ($n);
		$len = strlen($s);

		if ($len != 15) {
			return false;
		}
		$sum = 0;
		for ($i = $len; $i >= 1; $i--) {
			$d = (int) ($n % 10);
			if ($i % 2 === 0) {
				$d = 2 * $d;
			}
			$sum += sumDig($d);
			$n = $n / 10;
		}
		return ($sum % 10 === 0);
	}

}

if (!function_exists('credit_card')) {

	function credit_card($ncard = null, $min = 16, $max = 16)
	{

		if (empty($ncard)) {

			$ncard = rand(4, 6);

			for ($start = $min, $end = $max; $start < $min, $end > 0; $start++, $end--) {

				if (strlen($ncard) < $max) {
					$ncard .= rand(0, 9);
				}

			}

		}

		$last_val = (int) substr($ncard, -1);

		$doubles = [];

		for ($i = 0, $t = strlen($ncard); $i < $t; $i++) {

			$doubles[] = substr($ncard, $i, 1) * ($i % 2 == 0 ? 2 : 1);

		}

		$sum = 0;

		foreach ($doubles as $double) {
			for ($i = 0, $t = strlen($double); $i < $t; ++$i) {
				$sum += (int) substr($double, $i, 1);
			}
		}

		if ($last_val === (10 - $sum % 10) % 10) {

			return true;

		} else {

			// credit_card();

		}

		return false;

	}

}

if (!function_exists('random')) {

	function random($array = [])
	{

		if (empty($array)) {
			return 'Conjunto de elementos não foi definido.';
		}

		$rand = rand(0, count($array) - 1);

		return $array[$rand];

	}
}
