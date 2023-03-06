<?php

namespace App\Models;

use App\Models\AppModel;
use App\Models\FuncionarioModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartamentoModel extends AppModel
{

	use HasFactory;

	private $path = 'assets/clinica/img/departamentos/';

	protected $table = 'tb_departamento';
	protected $order = [
		null,
		'titulo',
		'descricao',
		'created_at',
		'updated_at',
		'status',
	];

	public function __construct()
	{

		$this->funcionario_model = new FuncionarioModel();

	}

	public function getDepartamentos($data = null)
	{

		$get = $this->select(
			'id',
			'titulo',
			'descricao',
			DB::raw('DATE_FORMAT(created_at, "%d/%m/%Y") AS data_cadastro'),
			DB::raw('DATE_FORMAT(updated_at, "%d/%m/%Y") AS data_atualizacao'),
			'status'
		);

		if (isset($data) && $search = $data['search']['value']) {
			$get->where(function ($query) use ($search) {
				$query
					->orWhere('id', 'like', $search . '%')
					->orWhere('titulo', 'like', $search . '%')
					->orWhere('descricao', 'like', $search . '%');
			});
		}

		// Order By
		if (isset($_GET['order']) && $_GET['order'][0]['column'] != 0) {
			$get->orderBy($this->order[$_GET['order'][0]['column']], $_GET['order'][0]['dir']);
		} else {
			$get->orderBy($this->order[1], 'asc');
		}

		return $get->paginate(isset($_GET['length']) ? $_GET['length'] : 50);

	}

	public function getDepartamentoById($id)
	{

		return $this->getDepartamentos()
			->where('id', $id)
			->first();

	}

	public function getDepartamentoEmpresa($id_empresa, $id_departamento = null)
	{

		$dp = $this->select('id', 'titulo', 'descricao', 'status')
			->from('tb_departamento')
			->whereIn('id', function ($query) use ($id_empresa, $id_departamento) {
				$query->select('id_departamento')
					->from('tb_departamento_empresa')
					->whereColumn('id_departamento', 'tb_departamento.id')
					->where('id_empresa', $id_empresa)
					->where('id_departamento', $id_departamento);
			})
			->get()
			->first();

		return $dp;

	}

	public function uploadImage(Request $image)
	{
		$imagem = null;

		if ($image->file('imagem')) {
			$file     = $image->imagem;
			$fileName = sha1($file->getClientOriginalName());
			$fileExt  = $file->getClientOriginalExtension();
			$imgName  = explode('.', $file->getClientOriginalName());
			$origName = limpa_string($imgName[count($imgName) - 2], '-') . '.' . $fileExt;
			$imagem   = limpa_string($fileName) . '.' . $fileExt;
			$file->storeAs($this->path, $imagem);
			$imagem = $this->path . $imagem;
		}

		return $imagem;

	}

	public function cadastraDepartamento($post)
	{

		$id        = $post->id;
		$titulo    = $post->titulo;
		$descricao = $post->descricao;
		$imagem    = $this->uploadImage($post);
		$status    = $post->status ?? '0';

		$data = [
			'titulo'    => $titulo,
			'descricao' => $descricao,
			// 'imagem'              => $imagem,
			'status'    => $status,
		];

		$id = $this->from('tb_departamento')
			->insertGetId($data);

		return $id;

	}

	public function editaDepartamento(Request $post, $id)
	{

		$id        = $post->id;
		$titulo    = $post->titulo;
		$descricao = $post->descricao;
		$imagem    = $this->uploadImage($post);
		$status    = $post->status ?? '0';

		$data = [
			'titulo'    => $titulo,
			'descricao' => $descricao,
			// 'imagem'              => $imagem,
			'status'    => $status,
		];

		if (!is_null($imagem)) {
			$data['imagem'] = $imagem;
		}

		$id = $this->from('tb_departamento')
			->where('id', $id)
			->update($data);

		return $id;

	}

	public function atualizaDepartamento($id, $campos = [])
	{

		return $this->from('tb_departamento')
			->whereIn('id', $id)
			->update($campos);

	}

	public function removeDepartamento($id_departamento)
	{
		// return $this->from('tb_departamento')
		// 	->whereIn('id', $id)
		// 	->delete();

		$empresas_removidas     = [];
		$empresas_nao_removidas = [];

		foreach ($id_departamento as $ind => $id) {

			$departamentos = $this->select('id')
				->from('tb_departamento_empresa')
				->where('id_departamento', $id)
				->get();

			if ($departamentos->count() > 0) {

				foreach ($departamentos as $departamento) {

					$issetFuncionarios = $this->funcionario_model->getFuncionariosDepartamento($departamento->id);

					if ($issetFuncionarios) {

						$empresas_nao_removidas[] = $issetFuncionarios->id_departamento;
						array_splice($id_departamento, $ind, 1);

					} else {

						$empresas_removidas[] = $id;

					}

				}

			} else {

				$empresas_removidas['sem_departamentos'][] = $id;

			}

		}

		$departamentos = [];

		if (!empty($id_departamento)) {

			$removidas = $this->from('tb_departamento')
				->whereIn('id', $id_departamento)
				->delete();

			$s = count($id_departamento) > 1 ? 's' : null;

			$id_departamento = $this->select('titulo')
				->from('tb_departamento')
				->whereIn('id', $id_departamento)
				->get();

			foreach ($id_departamento as $departamento) {
				$departamentos[] = $departamento->titulo;
			}

			if ($removidas) {

				$this->error[] = 'O' . $s . ' departamento' . $s . ' "' . (implode(', ', $departamentos)) . '" ' . (count($departamentos) > 1 ? ' foram ' : ' foi ') . ' removido' . $s;

			} else {

				$this->error[] = 'Não foi possível remover o' . $s . ' departamento' . $s . ' "' . (implode(', ', $departamentos)) . '"';

			}
		}

		if (!empty($empresas_nao_removidas)) {

			$id_departamento = $this->select('titulo')
				->from('tb_departamento')
				->whereIn('id', $empresas_nao_removidas)
				->get();

			foreach ($id_departamento as $departamento) {
				$departamentos[] = $departamento->titulo;
			}

			$s             = count($departamentos) > 1 ? 's' : null;
			$this->error[] = 'O' . $s . ' departamento' . $s . ' "' . (implode(', ', $departamentos)) . '" não ' . (count($departamentos) > 1 ? ' podem ' : ' pode ') . ' ser removido' . $s . ' enquanto existirem funcionários cadastrados nele' . $s;
		}

		if (!empty($this->error)) {
			return false;
		}

		return true;

	}

}
