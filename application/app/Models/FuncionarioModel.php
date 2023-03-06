<?php

namespace App\Models;

use App\Models\MedicoModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FuncionarioModel extends Model
{

	use HasFactory;

	protected $table = 'tb_funcionario';
	protected $order = [];

	private $path = 'assets/clinica/img/funcionarios/';

	public function __construct()
	{
		$this->medico_model = new MedicoModel();
	}

	public function getFuncionarios($data = null)
	{

		$get = $this->select(
			'id',
			'id_funcao',
			DB::raw('(SELECT id_empresa FROM tb_departamento_empresa WHERE
				tb_funcionario.id_empresa_departamento = tb_departamento_empresa.id) AS id_clinica'),
			DB::raw('(SELECT id_departamento FROM tb_departamento_empresa WHERE
				tb_funcionario.id_empresa_departamento = tb_departamento_empresa.id) AS id_departamento'),
			DB::raw('(SELECT funcao FROM tb_funcao WHERE id = id_funcao) AS funcao'),
			'nome',
			'cpf',
			'rg',
			DB::raw('(SELECT crm FROM tb_medico WHERE id_funcionario = tb_funcionario.id) AS crm'),
			DB::raw('(SELECT id_especialidade FROM tb_medico WHERE id_funcionario = tb_funcionario.id) AS especialidade'),
			DB::raw('DATE_FORMAT(created_at, "%d/%m/%Y") AS data_cadastro'),
			DB::raw('DATE_FORMAT(updated_at, "%d/%m/%Y") AS data_atualizacao'),
			'status',
		);

		if (isset($data) && $data['search'] && $search = $data['search']['value']) {
			$get->orWhere('id', 'like', $search . '%')
				->orWhere('nome', 'like', $search . '%')
				->orWhere(DB::raw('REGEXP_REPLACE(cpf, "[^\\x20-\\x7E]", "")'), 'like', limpa_string($search, '') . '%')
				->orWhere(DB::raw('REGEXP_REPLACE(rg, "[^\\x20-\\x7E]", "")'), 'like', limpa_string($search, '') . '%')
				->orWhere('id_funcao', function ($query) use ($search) {
					$query->select('id')
						->from('tb_funcao')
						->where('funcao', 'like', $search . '%')
						->whereColumn('id', 'id_funcao');
				})
				->orWhere('id', function ($query) use ($search) {
					$query->select('id_funcionario')
						->from('tb_medico')
						->whereColumn('tb_medico.id_funcionario', 'tb_funcionario.id')
						->where(DB::raw('REGEXP_REPLACE(crm, "[^\\x20-\\x7e]", "")'), 'like', limpa_string($search, '') . '%');
				})
				->orWhere('id', function ($query) use ($search) {
					$query->select('id_funcionario')
						->from('tb_medico')
						->whereColumn('tb_medico.id_funcionario', 'tb_funcionario.id')
						->where('id_especialidade', function ($query) use ($search) {
							$query->select('id')
								->from('tb_especialidade')
								->whereColumn('tb_especialidade.id', 'tb_medico.id_especialidade')
								->where('especialidade', 'like', $search . '%');
						});
				});
		}

		$this->order = [
			null,
			'nome',
			DB::raw('(SELECT funcao FROM tb_funcao WHERE id = id_funcao)'),
			'cpf',
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

	public function getFuncionarioById($id)
	{

		return $this->getFuncionarios()
			->where('id', $id)
			->first();

	}

	public function getFuncionariosDepartamento($id_departamento)
	{
		$funcionario = $this->select(
			'id_empresa_departamento',
			DB::raw('(SELECT titulo FROM tb_departamento WHERE tb_departamento.id = (
						SELECT id_departamento FROM tb_departamento_empresa
						WHERE tb_departamento.id = tb_departamento_empresa.id_departamento
						AND tb_funcionario.id_empresa_departamento = tb_departamento_empresa.id
						AND tb_departamento_empresa.id = ' . $id_departamento . ')) AS departamento'
			),
			DB::raw('(SELECT id_departamento FROM tb_departamento_empresa
						WHERE tb_departamento_empresa.id = tb_funcionario.id_empresa_departamento
						AND tb_departamento_empresa.id = ' . $id_departamento . ') AS id_departamento'
			),
			DB::raw('(SELECT nome_fantasia FROM tb_empresa WHERE tb_empresa.id = (
						SELECT id_empresa FROM tb_departamento_empresa
						WHERE tb_departamento_empresa.id_empresa = tb_empresa.id
						AND tb_departamento_empresa.id = ' . $id_departamento . ')) AS empresa')
		)
			->from('tb_funcionario')
			->distinct(true)
			->whereIn('tb_funcionario.id_empresa_departamento', function ($query) use ($id_departamento) {
				$query->select('tb_departamento_empresa.id')
					->from('tb_departamento_empresa')
					->whereColumn('tb_departamento_empresa.id', 'tb_funcionario.id_empresa_departamento')
					->where('tb_departamento_empresa.id', $id_departamento);

			})
			->get()
			->first();

		return $funcionario;

	}

	public function getEtnia()
	{
		return $this->select('id', 'descricao')
			->from('tb_etnia')
		// ->orderBy('descricao')
			->get();
	}

	public function getAcomodacao()
	{
		return $this->select('id', 'descricao')
			->from('tb_acomodacao')
			->orderBy('descricao')
			->get();
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

	public function cadastraFuncionario(Request $post)
	{

		$id_empresa              = $post->clinica;
		$id_departamento         = $post->departamento;
		$id_empresa_departamento = $this->select('id')->from('tb_departamento_empresa')->where('id_empresa', $id_empresa)->where('id_departamento', $id_departamento)->first()->id;
		$id_funcao               = $post->funcao;
		$nome                    = $post->nome;
		$imagem                  = $this->uploadImage($post);
		$cpf                     = $post->cpf;
		$rg                      = $post->rg;
		$status                  = $post->status ?? '0';
		// $data_nascimento      = $post->data_nascimento ? convert_to_date($post->data_nascimento, 'd/m/Y', 'Y-m-d') : null;
		// $crm = $post->crm;
		// $email                = $post->email;
		// $telefone             = $post->telefone;
		// $celular              = $post->celular;

		$data = [
			'id_empresa_departamento' => $id_empresa_departamento,
			'id_funcao'               => $id_funcao,
			'nome'                    => $nome,
			// 'imagem'               => $imagem,
			// 'sexo'                 => $sexo,
			// 'data_nascimento'      => $data_nascimento,
			'cpf'                     => $cpf,
			'rg'                      => $rg,
			// 'crm'       => $crm,
			// 'email'                => $email,
			// 'telefone'             => $telefone,
			// 'celular'              => $celular,
			'status'                  => $status,
		];

		$id = $this->from('tb_funcionario')
			->insertGetId($data);

		$this->medico_model->cadastraMedico($post, $id);

		return $id;

	}

	public function editaFuncionario(Request $post, $id_funcionario)
	{

		$id_empresa              = $post->clinica;
		$id_departamento         = $post->departamento;
		$id_empresa_departamento = $this->select('id')->from('tb_departamento_empresa')->where('id_empresa', $id_empresa)->where('id_departamento', $id_departamento)->first()->id;
		$id_funcao               = $post->funcao;
		$nome                    = $post->nome;
		$imagem                  = $this->uploadImage($post);
		$cpf                     = $post->cpf;
		$rg                      = $post->rg;
		$status                  = $post->status ?? '0';
		// $data_nascimento      = $post->data_nascimento ? convert_to_date($post->data_nascimento, 'd/m/Y', 'Y-m-d') : null;
		// $crm = $post->crm;
		// $email                = $post->email;
		// $telefone             = $post->telefone;
		// $celular              = $post->celular;

		$data = [
			'id_empresa_departamento' => $id_empresa_departamento,
			'id_funcao'               => $id_funcao,
			'nome'                    => $nome,
			// 'imagem'               => $imagem,
			// 'sexo'                 => $sexo,
			// 'data_nascimento'      => $data_nascimento,
			'cpf'                     => $cpf,
			'rg'                      => $rg,
			// 'crm'       => $crm,
			// 'email'                => $email,
			// 'telefone'             => $telefone,
			// 'celular'              => $celular,
			'status'                  => $status,
		];

		if (!is_null($imagem)) {
			$data['imagem'] = $imagem;
		}

		$update = $this->from('tb_funcionario')
			->where('id', $id_funcionario)
			->update($data);

		$this->medico_model->cadastraMedico($post, $id_funcionario);

		return $update;

	}

	public function updateColumn(Request $request)
	{
		$update_funcionario = $this->from('tb_funcionario')
			->whereIn('id', $request->id)
			->update([$request->field => $request->value]);

		if ($update_funcionario) {
			$this->from('tb_medico')
				->whereIn('id_funcionario', $request->id)
				->update([$request->field => $request->value]);
		}

		return $update_funcionario;

	}

}
