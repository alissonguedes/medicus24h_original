<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicoModel extends Model
{

	use HasFactory;

	protected $table = 'tb_medico';
	protected $order = [];

	private $path = 'assets/clinica/img/medicos/';

	public function getMedicosEmpresa(Request $request)
	{

		$medico        = $request->get('query');
		$clinica       = $request->get('clinica');
		$especialidade = $request->get('especialidade');

		$get = $this->select(
			'M.id',
			DB::raw('(SELECT nome FROM tb_funcionario WHERE id = M.id_funcionario) AS nome'),
		);

		$get->from('tb_medico AS M');

		$get->join('tb_medico_clinica AS MC', 'MC.id_medico', 'M.id');

		if ($especialidade) {
			$get->where('M.id_especialidade', $especialidade);
		}

		if ($clinica) {
			$get->where('MC.id_empresa', $clinica);
		}

		if ($medico) {
			$get->where('E.titulo', 'like', '%' . $medico . '%');
		}

		$get->groupBy('M.id');

		return $get->get();

	}

	public function getMedicos($data = null)
	{

		$get = $this->select(
			'id',
			DB::raw('(
				SELECT id_departamento FROM tb_departamento_empresa AS DE WHERE DE.id = (
					SELECT id_empresa_departamento FROM tb_funcionario AS F WHERE F.id = tb_medico.id_funcionario
				)
			) AS id_departamento'),
			DB::raw('(
				SELECT id_empresa FROM tb_departamento_empresa AS DE WHERE DE.id = (
					SELECT id_empresa_departamento FROM tb_funcionario AS F WHERE F.id = tb_medico.id_funcionario
				)
			) AS id_empresa'),
			'id_especialidade',
			'crm',
			'status',
			DB::raw('(SELECT especialidade FROM tb_especialidade WHERE id = id_especialidade) AS especialidade'),
			DB::raw('(SELECT nome FROM tb_funcionario WHERE id = id_funcionario) AS nome'),
			DB::raw('(SELECT cpf FROM tb_funcionario WHERE id = id_funcionario) AS cpf'),
			DB::raw('(SELECT rg FROM tb_funcionario WHERE id = id_funcionario) AS rg'),
			DB::raw('DATE_FORMAT(created_at, "%d/%m/%Y") AS data_cadastro'),
			DB::raw('DATE_FORMAT(updated_at, "%d/%m/%Y") AS data_atualizacao')
		);

		if (isset($data) && $search = $data['search']['value']) {
			$get->where(function ($query) use ($search) {
				$query
					->orWhere('id', 'like', $search . '%')
					->orWhere(DB::raw('REGEXP_REPLACE(crm, "[^\\x20-\\x7E]", "")'), 'like', limpa_string($search, '') . '%')
					->orWhere('id_funcionario', function ($query) use ($search) {
						$query->select('id')
							->from('tb_funcionario')
							->where(function ($query) use ($search) {
								$query->where('nome', 'like', $search . '%')
									->orWhere(DB::raw('REGEXP_REPLACE(cpf, "[^\\x20-\\x7E]", "")'), 'like', limpa_string($search, '') . '%')
									->orWhere(DB::raw('REGEXP_REPLACE(rg, "[^\\x20-\\x7E]", "")'), 'like', limpa_string($search, '') . '%');
							})
							->whereColumn('id', 'id_funcionario');
					})
					->orWhere('id_especialidade', function ($query) use ($search) {
						$query->select('id')
							->from('tb_especialidade')
							->where('especialidade', 'like', $search . '%')
							->whereColumn('id', 'id_especialidade');
					});
			});
		}

		$this->order = [
			null,
			DB::raw('(SELECT nome FROM tb_funcionario WHERE id = id_funcionario)'),
			DB::raw('(SELECT especialidade FROM tb_especialidade WHERE id = id_especialidade)'),
			'crm',
			'created_at',
			'status',
		];

		// Order By
		if (isset($_GET['order']) && $_GET['order'][0]['column'] != 0) {
			$get->orderBy($this->order[$_GET['order'][0]['column']], $_GET['order'][0]['dir']);
		} else {
			$get->orderBy($this->order[1], 'asc');
		}

		return $get->paginate(isset($_GET['length']) ? $_GET['length'] : 50);

	}

	public function getMedicoById($id)
	{

		return $medico = $this->getMedicos()
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

	public function cadastraMedico($post, $id_funcionario = null)
	{

		$id_funcao     = $post->funcao;
		$especialidade = $post->especialidade;
		$crm           = $post->crm;
		$status        = $post->status ?? '0';

		// Se a função for = 'Médico', inserir funcionário na tabela de médicos (tb_medico)
		$funcao = $this->select('codigo')
			->from('tb_funcao')
			->where('id', $id_funcao)
			->first();

		if ($funcao->codigo === 2) {
			$medico = $this->select('id', 'id_funcionario', 'id_especialidade', 'crm')
				->from('tb_medico')
				->where('id_funcionario', $id_funcionario)
				->first();
			if (!isset($medico)) {
				// Cadastrar o médico
				$this->from('tb_medico')
					->insert([
						'id_funcionario'   => $id_funcionario,
						'id_especialidade' => $especialidade,
						'crm'              => $crm,
						'status'           => $status,
					]);
			} else {
				// editar o médico
				$this->from('tb_medico')
					->where('id', $medico->id)
					->where('id_funcionario', $id_funcionario)
					->update([
						'id_especialidade' => $post->especialidade,
						'crm'              => $post->crm,
						'status'           => $status,
					]);
			}
		} else {

			/**
			 * Se a função for alterada para outro que não seja médico,
			 * remover o médico da tabela `tb_medico`
			 */
			$medico = $this->select('id', 'id_funcionario')
				->from('tb_medico')
				->where('id_funcionario', $id_funcionario)
				->first();
			if (isset($medico)) {
				$this->where('id', $medico->id)
					->delete();
			}

		}

	}

	public function editaMedico(Request $post, $id)
	{

		$id_especialidade = $post->especialidade;
		$nome             = $post->nome;
		$imagem           = $this->uploadImage($post);
		// $data_nascimento      = $post->data_nascimento ? convert_to_date($post->data_nascimento, 'd/m/Y', 'Y-m-d') : null;
		$cpf = $post->cpf;
		$rg  = $post->rg;
		$crm = $post->crm;
		// $email                = $post->email;
		// $telefone             = $post->telefone;
		// $celular              = $post->celular;
		$status = $post->status ?? '0';

		$data = [
			'id_especialidade' => $id_especialidade,
			// 'nome'             => $nome,
			// 'imagem'               => $imagem,
			// 'sexo'                 => $sexo,
			// 'data_nascimento'      => $data_nascimento,
			// 'cpf'              => $cpf,
			// 'rg'               => $rg,
			'crm'              => $crm,
			// 'email'                => $email,
			// 'telefone'             => $telefone,
			// 'celular'              => $celular,
			'status'           => $status,
		];

		if (!is_null($imagem)) {
			$data['imagem'] = $imagem;
		}

		$id = $this->from('tb_medico')
			->where('id', $id)
			->update($data);

		if ($id) {

			$this->cadastraMedicoClinica($post->id, $post->empresa);

		}

		return $id;

	}

	public function cadastraMedicoClinica($id_medico, $id_empresa)
	{

		if (isset($id_empresa)) {

			foreach ($id_empresa as $empresa) {

				$issetMedico = $this->getMedicoClinica($id_medico, $empresa);

				if (!isset($issetMedico)) {
					$this->from('tb_medico_clinica')
						->insert([
							'id_medico'  => $id_medico,
							'id_empresa' => $empresa,
						]);
				}

			}

			$this->from('tb_medico_clinica')
				->whereNotIn('id_empresa', $id_empresa)
				->where('id_medico', $id_medico)
				->delete();

		} else {

			$this->from('tb_medico_clinica')
				->where('id_medico', $id_medico)
				->delete();

		}

	}

	public function getMedicoClinica($id_medico, $id_empresa)
	{

		return $this->select('id', 'id_medico', 'id_empresa')
			->from('tb_medico_clinica')
			->where('id_medico', $id_medico)
			->where('id_empresa', $id_empresa)
			->first();

	}

}
