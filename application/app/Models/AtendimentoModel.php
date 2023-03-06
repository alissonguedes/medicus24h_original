<?php

namespace App\Models;

use App\Models\AppModel;
use App\Models\FuncionarioModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AtendimentoModel extends AppModel
{

	use HasFactory;

	private $path = 'assets/clinica/img/departamentos/';

	protected $table = 'tb_atendimento_tipo';
	protected $order = [
		null,
		'tipo',
		'descricao',
		'created_at',
		'updated_at',
		'status',
	];

	public function __construct()
	{

		$this->funcionario_model = new FuncionarioModel();

	}

	public function getCategorias($data = null)
	{

		$idioma = !isset($_COOKIE['idioma']) ? get_config('language') : $_COOKIE['idioma'];

		$get = $this->select(
			'id',
			DB::raw('(SELECT titulo FROM tb_categoria_descricao WHERE id_categoria = id AND id_idioma =
				(SELECT id FROM tb_sys_idioma WHERE sigla ="' . $idioma . '")
			) AS titulo')
		)
			->from('tb_categoria')
			->get();

		return $get;
	}

	public function getTipos($data = null)
	{

		$get = $this->select(
			'id',
			'tipo AS titulo',
			'descricao',
			DB::raw('DATE_FORMAT(created_at, "%d/%m/%Y") AS data_cadastro'),
			DB::raw('DATE_FORMAT(updated_at, "%d/%m/%Y") AS data_atualizacao'),
			'status'
		);

		if (isset($data) && $search = $data['search']['value']) {
			$get->where(function ($query) use ($search) {
				$query
					->orWhere('id', 'like', $search . '%')
					->orWhere('tipo', 'like', $search . '%')
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

	public function getAtendimentos()
	{

		$get = $this->select(
			'id',
			'titulo',
			'descricao',
			'id_parent',
			DB::raw('(
		 		SELECT `id` FROM `tb_especialidade` AS `E` WHERE `E`.`id` = (
		 			SELECT `id_especialidade` FROM `tb_medico` AS `M` WHERE `M`.`id_especialidade` = `E`.`id` AND `M`.`id` = (
		 				SELECT `id_medico` FROM `tb_medico_clinica` AS `C` WHERE `C`.`id` = `A`.`id_medico`
		 			)
		 		)
		 	) AS `id_especialidade`'),
			DB::raw('(
		 		SELECT `especialidade` FROM `tb_especialidade` AS `E` WHERE `E`.`id` = (
		 			SELECT `id_especialidade` FROM `tb_medico` AS `M` WHERE `M`.`id_especialidade` = `E`.`id` AND `M`.`id` = (
		 				SELECT `id_medico` FROM `tb_medico_clinica` AS `C` WHERE `C`.`id` = `A`.`id_medico`
		 			)
		 		)
		 	) AS `especialidade`'),
			DB::raw('(
		 		SELECT `id` FROM `tb_empresa` AS `C` WHERE `C`.`id` = (
					SELECT `id_empresa` FROM `tb_medico_clinica` AS `M` WHERE `M`.`id_empresa` = `C`.`id` AND `M`.`id` = `A`.`id_medico`
				)
		 	) AS `id_clinica`'),
			DB::raw('(
		 		SELECT `titulo` FROM `tb_empresa` AS `C` WHERE `C`.`id` = (
					SELECT `id_empresa` FROM `tb_medico_clinica` AS `M` WHERE `M`.`id_empresa` = `C`.`id` AND `M`.`id` = `A`.`id_medico`
				)
		 	) AS `clinica`'),
			DB::raw('(
					SELECT `id` FROM `tb_medico` AS `M` WHERE `M`.`id` = (
						SELECT `id_medico` FROM `tb_medico_clinica` AS `C` WHERE `C`.`id_medico` = `M`.`id` AND `C`.`id` = `A`.`id_medico`
					)
		 	) AS `id_medico`'),
			DB::raw('(
		 		SELECT `nome` FROM `tb_funcionario` AS `F` WHERE `F`.`id` = (
					SELECT `id_funcionario` FROM `tb_medico` AS `M` WHERE `M`.`id_funcionario` = `F`.`id` AND `M`.`id` = (
						SELECT `id_medico` FROM `tb_medico_clinica` AS `C` WHERE `C`.`id_medico` = `M`.`id` AND `C`.`id` = `A`.`id_medico`
					)
				)
		 	) AS `medico`'),
			// DB::raw('(SELECT nome FROM tb_funcionario WHERE id = (SELECT id_funcionario FROM tb_medico WHERE id = id_medico)) AS medico'),
			'id_paciente',
			'id_tipo',
			DB::raw('(
				SELECT `tipo` FROM `tb_atendimento_tipo` WHERE `id`  = `A`.`id_tipo`
			) AS tipo_atendimento'),
			DB::raw('(SELECT nome FROM tb_paciente WHERE id = id_paciente) AS paciente'),
			'id_categoria',
			DB::raw('(SELECT titulo FROM tb_categoria_descricao WHERE id_categoria = A.id_categoria) AS categoria'),
			DB::raw('DATE_FORMAT(data, "%d/%m/%Y") AS data'),
			'hora_agendada',
			'hora_inicial',
			'hora_final',
			'recorrencia',
			'periodo_lembrete',
			'cor',
			'criador',
			'lembrete',
			'tempo_lembrete',
			'observacao',
			DB::raw('DATE_FORMAT(created_at, "%d/%m/%Y") AS data_cadastro'),
			DB::raw('DATE_FORMAT(updated_at, "%d/%m/%Y") AS data_atualizacao'),
			'status'
		)
			->from('tb_atendimento AS A');

		$get->where('data', date('Y-m-d'));

		$this->order = [
			'hora_agendada',
			DB::raw('(SELECT nome FROM tb_paciente WHERE id = id_paciente)'),
			DB::raw('(SELECT `nome` FROM `tb_funcionario` AS `F` WHERE `F`.`id` = (SELECT `id_funcionario` FROM `tb_medico` AS `M` WHERE `M`.`id_funcionario` = `F`.`id` AND `M`.`id` = (SELECT `id_medico` FROM `tb_medico_clinica` AS `C` WHERE `C`.`id_medico` = `M`.`id` AND `C`.`id` = `A`.`id_medico`)))'),
			DB::raw('(SELECT titulo FROM tb_categoria_descricao WHERE id_categoria = A.id_categoria)'),
			DB::raw('(SELECT `tipo` FROM `tb_atendimento_tipo` WHERE `id`  = `A`.`id_tipo`)'),
			'status',
		];

		// Order By
		if (isset($_GET['order']) && $_GET['order'][0]['column'] != 0) {
			$get->orderBy($this->order[$_GET['order'][0]['column']], $_GET['order'][0]['dir']);
		} else {
			$get->orderBy($this->order[1], 'asc');
		}

		return $get->paginate();

	}

	public function getAtendimentoById($id)
	{

		return $this->getAtendimentos()
			->where('id', $id)
			->first();

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
