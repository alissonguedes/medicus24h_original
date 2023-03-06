<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class ApiController extends Controller
{

	public function __construct()
	{

	}

	public function translate($lang)
	{

		$translate = [];

		setcookie('idioma', $lang, time() + 60 * 60 * 24 * 30, '/');

		return json_encode(['idioma' => $lang]);

	}

	public function token(Request $request)
	{

		if (Session::has('app_session')) {
			return json_encode(['token' => Session::get('app_session')]);
		}

		return json_encode([]);

	}

	public function getDateTime()
	{

		$time = convert_to_date('d/m/Y H:i:s', 'l, d F Y, H:i');
		return response()->json($time);

	}

	public function upload_img_tinymce(Request $request)
	{

		$path     = 'assets/grupoalertaweb/wp-content/uploads/' . date('Y') . '/' . date('m') . '/paginas/';
		$origName = null;
		$fileName = null;
		$image    = null;

		if ($request->file('file')) {

			$file = $request->file('file');

			$fileName = sha1($file->getClientOriginalName());
			$fileExt  = $file->getClientOriginalExtension();

			$imgName  = explode('.', $file->getClientOriginalName());
			$origName = limpa_string($imgName[count($imgName) - 2], '_') . '.' . $fileExt;
			$image    = limpa_string($fileName) . '.' . $fileExt;

			$file->storeAs($path, $image);

		}

		$location = asset($path . $image);
		return json_encode(['location' => $location]); // response(json_encode([ 'location' => $location ]), 200);

	}

	/**
	 * Obtém a versão do produto
	 */
	public function get_version()
	{

		$config = new \App\Models\Admin\ConfigModel();

		$versao = $config->select('config', 'value AS versao')
			->from('tb_sys_config')
			->where('config', 'version')
			->get()
			->first();

		return (float) $versao->versao;

	}

	/**
	 * Obtém as atualizações do sitema [CONTINUAR DEPOIS]
	 */
	public function get_updates()
	{

		if (Session::has('userdata') && Session::get('userdata')['id_grupo'] === 1) {

			$updates = false;
			// $fileversion = BASEDIR . 'version';
			$fileversion = file_get_contents('CAMINHO_DO_ARQUIVO_AQUI');
			$new_version = file_put_contents($fileversion, BASEDIR . 'version', FILE_APPEND);
			$old_version = $this->get_version();

			dump($new_version);
			if ($old_version < $new_version) {
				$updates = true;
			}

			return response(['updates' => $updates], 200);

		}

		return false;

	}

	public function getCep(Request $request, $cep)
	{

		$data = [
			'status'  => 'success',
			'message' => null,
			'fields'  => [
				// 'cep' => null,
				'cidade'     => null,
				'logradouro' => null,
				'bairro'     => null,
				'uf'         => null,
			],
		];

		$url    = 'https://viacep.com.br/ws/' . limpa_string($cep) . '/json';
		$json   = file_get_contents($url);
		$result = json_decode($json);

		if (isset($result->erro)) {
			$message         = 'CEP não encontrado';
			$data['status']  = 'error';
			$data['message'] = $message;
			$data['errors']  = ['cep' => $message];
			return json_encode($data);
		} else {
			$data['fields'] = [
				// 'cep'        => $result->cep,
				'cidade'     => $result->localidade,
				'logradouro' => $result->logradouro,
				'bairro'     => $result->bairro,
				'uf'         => $result->uf,
			];
		}

		return $data;

	}

	public function include_js_app()
	{

		$includes = [];
		$path     = storage_path('public/js/app');
		$dir      = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));

		foreach ($dir as $file) {

			if ($file->isDir()) {
				continue;
			}

			$public_path = explode(storage_path('public'), $file->getPath());

			$includes[] = ['path' => asset($public_path[1] . '/' . $file->getFilename())];

		}

		return response()->json($includes);

	}

}
