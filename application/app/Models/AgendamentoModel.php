<?php

namespace App\Models;

use App\Models\FuncionarioModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AgendamentoModel extends AppModel
{

	use HasFactory;

	private $path = 'assets/clinica/img/agendamentos/';

	protected $table = 'tb_atendimento AS A';
	protected $order = [
		null,
		'titulo',
		'cnpj',
		'cidade',
		'uf',
		'created_at',
		'status',
	];

	public function __construct()
	{
		$this->funcionario_model = new FuncionarioModel();
	}

	public function getAgendamentos($data = null)
	{

		$get = $this->select(
			'id',
			'titulo',
			'descricao',
			'id_parent',
			'id_tipo',
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
		);

		// if (isset($data) && $search = $data['search']['value']) {
		// 	$get->where(function ($query) use ($search) {
		// 		$query
		// 			->orWhere(DB::raw('REGEXP_REPLACE(cnpj, "[^\\x20-\\x7E]", "")'), 'like', limpa_string($search, '') . '%')
		// 			->orWhere('nome_fantasia', 'like', $search . '%')
		// 			->orWhere('razao_social', 'like', $search . '%')
		// 			->orWhere('inscricao_estadual', 'like', $search . '%')
		// 			->orWhere('inscricao_municipal', 'like', $search . '%')
		// 			->orWhere('email', 'like', $search . '%')
		// 			->orWhere(DB::raw('REGEXP_REPLACE(telefone, "[^\\x20-\\x7E]", "")'), 'like', limpa_string($search, '') . '%')
		// 			->orWhere(DB::raw('REGEXP_REPLACE(celular, "[^\\x20-\\x7E]", "")'), 'like', limpa_string($search, '') . '%');
		// 	});
		// }

		// Order By
		if (isset($_GET['order']) && $_GET['order'][0]['column'] != 0) {
			$get->orderBy($this->order[$_GET['order'][0]['column']], $_GET['order'][0]['dir']);
		} else {
			$get->orderBy($this->order[1], 'asc');
		}

		return $get->paginate(isset($_GET['length']) ? $_GET['length'] : 50);

	}

	public function getAgendamentoById($id)
	{

		return $this->getAgendamentos()
			->where('id', $id)
			->first();

	}

	//$inicio, $fim, $tipo = null){
	public function getEventos(Request $request)
	{

		$inicio   = $request->get('start');
		$fim      = $request->get('end');
		$timezone = $request->get('timezone');
		$tipo     = $request->tipo ? $request->tipo : null;

		$periodo = [
			date('Y-m-d', strtotime($inicio)),
			date('Y-m-d', strtotime($fim)),
		];

		$get = $this->select(
			'id',
			'titulo',
			'descricao',
			'id_parent',
			'id_tipo',
			'id_medico',
			// DB::raw('(SELECT nome FROM tb_funcionario WHERE id = (SELECT id_funcionario FROM tb_medico WHERE id = id_medico)) AS medico'),
			DB::raw('(SELECT nome FROM tb_paciente WHERE id = id_paciente) AS paciente'),
			DB::raw('(
				SELECT `titulo` FROM `tb_empresa` AS `C` WHERE `C`.`id` = (
					SELECT `id_empresa` FROM `tb_medico_clinica` AS `M` WHERE `M`.`id_empresa` = `C`.`id` AND `M`.`id` = `A`.`id_medico`
				)
			) AS `clinica`'),
			'id_categoria',
			'observacao',
			'data',
			// DB::raw('DATE_FORMAT(data, "%d/%m/%Y") AS data'),
			'hora_agendada',
			'hora_inicial',
			'hora_final',
			'recorrencia',
			'periodo_lembrete',
			'cor',
			'criador',
			'lembrete',
			'tempo_lembrete',
			DB::raw('DATE_FORMAT(created_at, "%d/%m/%Y") AS data_cadastro'),
			DB::raw('DATE_FORMAT(updated_at, "%d/%m/%Y") AS data_atualizacao'),
			'A.status'
		)
			->whereBetween('data', $periodo);

		if ($tipo) {
			$get->where('id_categoria', $tipo);
		}

		$get->where(function ($query) {
			$query->where('A.status', '<>', 'C')
				->where('A.status', '<>', '0');
		});

		return $get->get();

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

	public function cadastraAgendamento($post)
	{

		$id         = $post->id;
		$titulo     = $post->titulo;
		$descricao  = $post->descricao;
		$observacao = $post->observacao;
		$id_parent  = $post->parent;
		$id_tipo    = $post->tipo;
		$id_medico  = $post->medico;
		$id_clinica = $post->clinica;

		$id_medico_clinica = $this->select('id')
			->from('tb_medico_clinica')
			->where('id_medico', $id_medico)
			->where('id_empresa', $id_clinica)
			->first();

		$id_medico = $id_medico_clinica->id;

		$id_paciente         = $post->paciente;
		$id_categoria        = $post->categoria;
		$data                = date('Y-m-d', strtotime(str_replace('/', '-', $post->data)));
		$hora_agendada       = $post->hora . ':00';
		$hora_inicial        = null; //$post->hora_inicial;
		$hora_final          = null; //$post->hora_final;
		$recorrencia         = $post->recorrencia ?? 'off';
		$recorrencia_periodo = $post->periodo ?? 0;
		$recorrencia_limite  = null; //$post->periodo;
		$cor                 = $post->cor;
		//// !!! MODIFICAR AQUI !!! ////
		$criador = $post->criador ?? Session::get('userdata')[Session::get('app_session')]['id'];

		$lembrete       = $post->lembrete ?? 'off';
		$tempo_lembrete = $post->tempo_lembrete ?? '0';
		$status         = $post->status ?? '1';

		$data = [
			'titulo'              => $titulo,
			'descricao'           => $descricao,
			'id_parent'           => $id_parent,
			'id_tipo'             => $id_tipo,
			'id_medico'           => $id_medico,
			'id_paciente'         => $id_paciente,
			'id_categoria'        => $id_categoria,
			'observacao'          => $observacao,
			'descricao'           => $descricao,
			'data'                => $data,
			'hora_agendada'       => $hora_agendada,
			'hora_inicial'        => $hora_inicial,
			'hora_final'          => $hora_final,
			'recorrencia'         => $recorrencia,
			'recorrencia_periodo' => $recorrencia_periodo,
			'recorrencia_limite'  => $recorrencia_limite,
			'cor'                 => $cor,
			'criador'             => $criador,
			'lembrete'            => $lembrete,
			'tempo_lembrete'      => $tempo_lembrete,
			'status'              => $status,
		];

		$id_agendamento = $this->from('tb_atendimento')
			->insertGetId($data);

		// if ($id_agendamento) {

		// 	$data = [];

		// 	if (isset($post->departamento) && !empty($post->departamento)) {

		// 		$departamento_model = new DepartamentoModel();

		// 		foreach ($post->departamento as $departamento) {

		// 			$dep = $departamento_model->getDepartamentoAgendamento($id_agendamento, $departamento);

		// 			if (!isset($dep)) {
		// 				$data[] = ['id_departamento' => $departamento, 'id_agendamento' => $id_agendamento];
		// 			}

		// 		}

		// 		return $this->cadastraDepartamento($data);

		// 	}

		// }

		return $id;

	}

	public function editaAgendamento(Request $post, $id_agendamento)
	{

		// $id             = $post->id;
		// $titulo         = $post->titulo;
		// $descricao      = $post->descricao;
		// $id_parent      = $post->parent;
		// $id_tipo        = $post->tipo;
		// $id_medico      = $post->medico;
		// $id_paciente    = $post->paciente;
		// $id_categoria   = $post->categoria;
		// $data           = $post->data;
		// $hora_agendada  = $post->hora_agendada;
		// $hora_inicial   = $post->hora_inicial;
		// $hora_final     = $post->hora_final;
		// $recorrencia    = $post->recorrencia;
		// $periodo        = $post->periodo;
		// $cor            = $post->cor;
		// $criador        = $post->criador;
		// $lembrete       = $post->lembrete ?? 'off';
		// $tempo_lembrete = $post->tempo_lembrete;
		// $status         = $post->status ?? '0';

		// $data = [
		// 	'titulo'         => $titulo,
		// 	'descricao'      => $descricao,
		// 	'id_parent'      => $id_parent,
		// 	'id_tipo'        => $id_tipo,
		// 	'id_medico'      => $id_medico,
		// 	'id_paciente'    => $id_paciente,
		// 	'id_categoria'   => $id_categoria,
		// 	'data'           => $data,
		// 	'hora_agendada'  => $hora_agendada,
		// 	'hora_inicial'   => $hora_inicial,
		// 	'hora_final'     => $hora_final,
		// 	'recorrencia'    => $recorrencia,
		// 	'periodo'        => $periodo,
		// 	'cor'            => $cor,
		// 	'criador'        => $criador,
		// 	'lembrete'       => $lembrete,
		// 	'tempo_lembrete' => $tempo_lembrete,
		// 	'status'         => $status,
		// ];

		$id         = $post->id;
		$titulo     = $post->titulo;
		$descricao  = $post->descricao;
		$observacao = $post->observacao;
		$id_parent  = $post->parent;
		$id_tipo    = $post->tipo;
		$id_medico  = $post->medico;
		$id_clinica = $post->clinica;

		$id_medico_clinica = $this->select('id')
			->from('tb_medico_clinica')
			->where('id_medico', $id_medico)
			->where('id_empresa', $id_clinica)
			->first();

		$id_medico = $id_medico_clinica->id;

		$id_paciente         = $post->paciente;
		$id_categoria        = $post->categoria;
		$data                = date('Y-m-d', strtotime(str_replace('/', '-', $post->data)));
		$hora_agendada       = $post->hora . ':00';
		$hora_inicial        = null; //$post->hora_inicial;
		$hora_final          = null; //$post->hora_final;
		$recorrencia         = $post->recorrencia ?? 'off';
		$recorrencia_periodo = $post->periodo ?? 0;
		$recorrencia_limite  = null; //$post->periodo;
		$cor                 = $post->cor;
		//// !!! MODIFICAR AQUI !!! ////
		$criador        = $post->criador ?? Session::get('userdata')[Session::get('app_session')]['id'];
		$lembrete       = $post->lembrete ?? 'off';
		$tempo_lembrete = $post->tempo_lembrete ?? 0;
		$old_data       = $this->select('data')->from('tb_atendimento')->where('id', $id)->first();
		$status         = $old_data != $data ? 'R' : $post->status;

		$data = [
			'titulo'              => $titulo,
			'descricao'           => $descricao,
			'id_parent'           => $id_parent,
			'id_tipo'             => $id_tipo,
			'id_medico'           => $id_medico,
			'id_paciente'         => $id_paciente,
			'id_categoria'        => $id_categoria,
			'observacao'          => $observacao,
			'descricao'           => $descricao,
			'data'                => $data,
			'hora_agendada'       => $hora_agendada,
			'hora_inicial'        => $hora_inicial,
			'hora_final'          => $hora_final,
			'recorrencia'         => $recorrencia,
			'recorrencia_periodo' => $recorrencia_periodo,
			'recorrencia_limite'  => $recorrencia_limite,
			'cor'                 => $cor,
			'criador'             => $criador,
			'lembrete'            => $lembrete,
			'tempo_lembrete'      => $tempo_lembrete,
			'status'              => $status,
		];

		$isUpdated = $this->from('tb_atendimento')
			->where('id', $id)
			->update($data);

		// if ($isUpdated) {

		// 	$param                     = [];
		// 	$remove_deptos             = 0;
		// 	$departamentos_cadastrados = 0;
		// 	$dpto                      = new DepartamentoModel();

		// 	$p['id_agendamento'] = $id_agendamento;

		// 	if (!empty($post->departamento)) {

		// 		foreach ($post->departamento as $id_departamento) {

		// 			$issetDepartamento = $dpto->getDepartamentoAgendamento($id_agendamento, $id_departamento);

		// 			// Adicionar o departamento à tabela `tb_departamento_agendamento`;
		// 			if (!isset($issetDepartamento)) {

		// 				$param = ['id_agendamento' => $id_agendamento, 'id_departamento' => $id_departamento];
		// 				if ($this->cadastraDepartamento($param)) {
		// 					$departamentos_cadastrados++;
		// 				}

		// 			}

		// 			$p['id_departamento'][] = $id_departamento;

		// 		}

		// 		if (!$this->removeDepartamento($p)) {
		// 			return false;
		// 		}

		// 		if ($departamentos_cadastrados > 0) {
		// 			return true;
		// 		}

		// 	} else {

		// 		return $this->removeDepartamento($p);

		// 	}

		// }

		return $id_agendamento;

	}

	public function cadastraDepartamento($dados = [])
	{

		return $this->from('tb_departamento_agendamento')
			->insert($dados);

	}

	public function removeDepartamento($dados = [])
	{

		if (!empty($dados)) {

			$departamento_removido     = 0;
			$departamento_nao_removido = 0;
			$departamentos             = [];

			$id_agendamento  = isset($dados['id_agendamento']) ? $dados['id_agendamento'] : false;
			$id_departamento = isset($dados['id_departamento']) ? $dados['id_departamento'] : false;

			$get = $this->select('id', 'id_departamento', 'id_agendamento')
				->from('tb_departamento_agendamento')
				->where('id_agendamento', $id_agendamento);

			if ($id_departamento) {
				$get->whereNotIn('id_departamento', $id_departamento);
			}

			$issetDepartamentos = $get->get();

			if ($issetDepartamentos->count() > 0) {

				foreach ($issetDepartamentos as $depto) {

					$funcionario = $this->funcionario_model->getFuncionariosDepartamento($depto->id);

					if ($funcionario) {

						$departamentos[] = $funcionario->departamento;
						$departamento_nao_removido++;

					} else {

						$deleted = $this->from('tb_departamento_agendamento')
							->where('id', $depto->id)
							->delete();

						$departamento_removido++;

					}

				}

			}

			if ($departamento_nao_removido > 0) {
				$message       = 'Você não pode remover os departamentos "' . implode('", "', $departamentos) . '" desta agendamento enquanto houver funcionário nele';
				$this->error[] = $message;
			}

			if ($departamento_removido > 0) {
				$message       = $departamento_removido . ' departamento' . ($departamento_removido > 1 ? 's' : null) . ' removido' . ($departamento_removido > 1 ? 's' : null);
				$this->error[] = $message;
			}

			if ($this->error) {
				return false;
			}

			return true;

		}

	}

	public function atualizaAgendamento($id, $campos = [])
	{

		return $this->from('tb_atendimento')
			->whereIn('id', $id)
			->update($campos);

	}

	public function removeAgendamento($id_agendamento)
	{

		if (!empty($id_agendamento)) {

			$data = ['status' => 'C'];

			return $this->from('tb_atendimento')
				->where('id', $id_agendamento)
				->update($data);

		}

		return false;

	}
}
