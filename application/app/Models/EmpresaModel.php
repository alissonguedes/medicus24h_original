<?php

namespace App\Models;

use App\Models\FuncionarioModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpresaModel extends AppModel
{

	use HasFactory;

	private $path = 'assets/clinica/img/empresas/';

	protected $table = 'tb_empresa';
	protected $order = [
		null,
		'razao_social',
		'titulo',
		'cnpj',
		'cidade',
		'uf',
		'created_at',
		'status',
		null,
	];

	public function __construct()
	{
		$this->funcionario_model = new FuncionarioModel();
	}

	public function getEmpresas($data = null)
	{

		$get = $this->select(
			'id',
			'titulo',
			'nome_fantasia',
			'razao_social',
			'cnpj',
			'inscricao_estadual',
			'inscricao_municipal',
			'cep',
			'logradouro',
			'numero',
			'bairro',
			'complemento',
			'cidade',
			'uf',
			'pais',
			'quem_somos',
			'quem_somos_imagem',
			'distribuidor_imagem',
			'contato_imagem',
			'telefone',
			'celular',
			'email',
			'facebook',
			'instagram',
			'youtube',
			'linkedin',
			'github',
			'gmaps',
			'aliquota_imposto',
			'tributacao',
			'certificado',
			'senha_certificado',
			'ambiente',
			'sequence_nfe',
			'serie_nfe',
			'sequence_nfce',
			'tokencsc',
			'csc',
			'matriz',
			DB::raw('DATE_FORMAT(created_at, "%d/%m/%Y") AS data_cadastro'),
			DB::raw('DATE_FORMAT(updated_at, "%d/%m/%Y") AS data_atualizacao'),
			'status'
		);

		if (isset($data) && isset($data['search']) && $search = $data['search']['value']) {
			$get->where(function ($query) use ($search) {
				$query
					->orWhere(DB::raw('REGEXP_REPLACE(cnpj, "[^\\x20-\\x7E]", "")'), 'like', limpa_string($search, '') . '%')
					->orWhere('nome_fantasia', 'like', $search . '%')
					->orWhere('razao_social', 'like', $search . '%')
					->orWhere('titulo', 'like', $search . '%')
					->orWhere('inscricao_estadual', 'like', $search . '%')
					->orWhere('inscricao_municipal', 'like', $search . '%')
					->orWhere('email', 'like', $search . '%')
					->orWhere(DB::raw('REGEXP_REPLACE(telefone, "[^\\x20-\\x7E]", "")'), 'like', limpa_string($search, '') . '%')
					->orWhere(DB::raw('REGEXP_REPLACE(celular, "[^\\x20-\\x7E]", "")'), 'like', limpa_string($search, '') . '%');
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

	public function getClinicas($request = null)
	{

		$empresa       = $request->get('query');
		$especialidade = $request->get('especialidade');
		$get           = $this->select('E.id', 'E.titulo', 'E.cnpj')
			->from('tb_empresa', 'E');

		$get->join('tb_departamento_empresa AS DE', 'DE.id_empresa', 'E.id');
		$get->join('tb_medico_clinica AS MC', 'MC.id_empresa', 'DE.id_empresa');
		$get->join('tb_medico AS M', 'M.id', 'MC.id_medico');

		if ($especialidade) {
			$get->where('M.id_especialidade', $especialidade);
			// $get->where('E.titulo', 'like', $empresa . '%');
			// if ($empresa) {
			// 	$get->where(function ($get) use ($especialidade, $empresa) {
			// 		$get->orWhere('M.id_especialidade', function ($query) use ($empresa) {
			// 			$query->select('id')
			// 				->from('tb_especialidade')
			// 				->where('especialidade', 'like', $empresa . '%')
			// 				->whereColumn('id', 'M.id_especialidade');
			// 		});
			// 	});
			// }

		}

		if ($empresa) {
			$get->where('E.titulo', 'like', '%' . $empresa . '%');
		}

		$get->where('E.status', '1');

		$get->groupBy('E.id');
		$get = $get->limit($request->limit ?? 10)
			->get();

		return $get;

	}

	public function getEmpresaById($id)
	{

		return $this->getEmpresas()
			->where('id', $id)
			->first();

	}

	public function getEmpresasByDepartamentos($id_departamento)
	{

		return $this->select('E.id', 'E.titulo', 'E.cnpj', 'E.status', 'DE.id AS id_empresa_departamento', 'DE.id_departamento', 'DE.id_empresa')
			->from('tb_empresa AS E')
			->join('tb_departamento_empresa AS DE', 'DE.id_empresa', 'E.id', 'left')
			->where('DE.id_departamento', $id_departamento)
			->get();

	}

	public function getEmpresasComDepartamento()
	{

		return $this->select('tb_empresa.id', 'tb_empresa.nome_fantasia', 'tb_empresa.titulo')
			->distinct(true)
			->from('tb_empresa')
			->join('tb_departamento_empresa', 'tb_departamento_empresa.id_empresa', 'tb_empresa.id', 'right')
			->get();

	}

	public function getDepartamentos($id_empresa)
	{

		return $this->select('tb_departamento.id', 'tb_departamento.titulo', 'tb_departamento.descricao', 'tb_departamento.status')
			->from('tb_departamento')
			->join('tb_departamento_empresa', 'tb_departamento_empresa.id_departamento', 'tb_departamento.id', 'right')
			->where('tb_departamento_empresa.id_empresa', $id_empresa)
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

	public function cadastraEmpresa($post)
	{

		$id = $post->id;
		// $nome_fantasia       = $post->nome_fantasia;
		$titulo              = $post->titulo;
		$razao_social        = $post->razao_social;
		$cnpj                = $post->cnpj;
		$inscricao_estadual  = $post->inscricao_estadual;
		$inscricao_municipal = $post->inscricao_municipal;
		$cep                 = $post->cep;
		$logradouro          = $post->logradouro;
		$numero              = $post->numero;
		$bairro              = $post->bairro;
		$complemento         = $post->complemento;
		$cidade              = $post->cidade;
		$uf                  = $post->uf;
		$pais                = $post->pais;
		$quem_somos          = $post->quem_somos ?? null;
		$quem_somos_imagem   = $this->uploadImage($post);
		$distribuidor_imagem = $this->uploadImage($post);
		$contato_imagem      = $this->uploadImage($post);
		$telefone            = $post->telefone ?? null;
		$celular             = $post->celular ?? null;
		$email               = $post->email ?? null;
		$facebook            = $post->facebook ?? null;
		$instagram           = $post->instagram ?? null;
		$youtube             = $post->youtube ?? null;
		$linkedin            = $post->linkedin ?? null;
		$github              = $post->github ?? null;
		$gmaps               = $post->gmaps ?? null;
		$aliquota_imposto    = $post->aliquota_imposto ?? 0.00;
		$tributacao          = $post->tributacao ?? 'simples nacional';
		$certificado         = $post->certificado ?? null;
		$senha_certificado   = $post->senha_certificado ?? null;
		$ambiente            = $post->ambiente ?? '0';
		$sequence_nfe        = $post->sequence_nfe ?? 0;
		$serie_nfe           = $post->serie_nfe ?? 0;
		$sequence_nfce       = $post->sequence_nfce ?? 0;
		$tokencsc            = $post->tokencsc ?? null;
		$csc                 = $post->csc ?? null;
		$matriz              = $post->matriz ?? '0';
		$status              = $post->status ?? '0';

		$data = [
			'titulo'              => $titulo,
			// 'nome_fantasia'       => $nome_fantasia,
			'razao_social'        => $razao_social,
			'cnpj'                => $cnpj,
			'inscricao_estadual'  => $inscricao_estadual,
			'inscricao_municipal' => $inscricao_municipal,
			'cep'                 => $cep,
			'logradouro'          => $logradouro,
			'numero'              => $numero,
			'bairro'              => $bairro,
			'complemento'         => $complemento,
			'cidade'              => $cidade,
			'uf'                  => $uf,
			'pais'                => $pais,
			'quem_somos'          => $quem_somos,
			'quem_somos_imagem'   => $quem_somos_imagem,
			'distribuidor_imagem' => $distribuidor_imagem,
			'contato_imagem'      => $contato_imagem,
			'telefone'            => $telefone,
			'celular'             => $celular,
			'email'               => $email,
			'facebook'            => $facebook,
			'instagram'           => $instagram,
			'youtube'             => $youtube,
			'linkedin'            => $linkedin,
			'github'              => $github,
			'gmaps'               => $gmaps,
			'aliquota_imposto'    => $aliquota_imposto,
			'tributacao'          => $tributacao,
			'certificado'         => $certificado,
			'senha_certificado'   => $senha_certificado,
			'ambiente'            => $ambiente,
			'sequence_nfe'        => $sequence_nfe,
			'serie_nfe'           => $serie_nfe,
			'sequence_nfce'       => $sequence_nfce,
			'tokencsc'            => $tokencsc,
			'csc'                 => $csc,
			'matriz'              => $matriz,
			'status'              => $status,
		];

		$id_empresa = $this->from('tb_empresa')
			->insertGetId($data);

		if ($id_empresa) {

			$data = [];

			if (isset($post->departamento) && !empty($post->departamento)) {

				$departamento_model = new DepartamentoModel();

				foreach ($post->departamento as $departamento) {

					$dep = $departamento_model->getDepartamentoEmpresa($id_empresa, $departamento);

					if (!isset($dep)) {
						$data[] = ['id_departamento' => $departamento, 'id_empresa' => $id_empresa];
					}

				}

				// $this->removeDepartamento($data);

				return $this->cadastraDepartamento($data);

			}

		}

		return $id;

	}

	public function editaEmpresa(Request $post, $id_empresa)
	{

		$id_empresa = $post->id;
		// 'nome_fantasia'       => $nome_fantasia,
		$titulo              = $post->titulo;
		$razao_social        = $post->razao_social;
		$cnpj                = $post->cnpj;
		$inscricao_estadual  = $post->inscricao_estadual;
		$inscricao_municipal = $post->inscricao_municipal;
		$cep                 = $post->cep;
		$logradouro          = $post->logradouro;
		$numero              = $post->numero;
		$bairro              = $post->bairro;
		$complemento         = $post->complemento;
		$cidade              = $post->cidade;
		$uf                  = $post->uf;
		$pais                = $post->pais;
		$quem_somos          = $post->quem_somos ?? null;
		$quem_somos_imagem   = $this->uploadImage($post);
		$distribuidor_imagem = $this->uploadImage($post);
		$contato_imagem      = $this->uploadImage($post);
		$telefone            = $post->telefone ?? null;
		$celular             = $post->celular ?? null;
		$email               = $post->email ?? null;
		$facebook            = $post->facebook ?? null;
		$instagram           = $post->instagram ?? null;
		$youtube             = $post->youtube ?? null;
		$linkedin            = $post->linkedin ?? null;
		$github              = $post->github ?? null;
		$gmaps               = $post->gmaps ?? null;
		$aliquota_imposto    = $post->aliquota_imposto ?? 0.00;
		$tributacao          = $post->tributacao ?? 'simples nacional';
		$certificado         = $post->certificado ?? null;
		$senha_certificado   = $post->senha_certificado ?? null;
		$ambiente            = $post->ambiente ?? '0';
		$sequence_nfe        = $post->sequence_nfe ?? 0;
		$serie_nfe           = $post->serie_nfe ?? 0;
		$sequence_nfce       = $post->sequence_nfce ?? 0;
		$tokencsc            = $post->tokencsc ?? null;
		$csc                 = $post->csc ?? null;
		$matriz              = $post->matriz ?? '0';
		$status              = $post->status ?? '0';

		$data = [
			'titulo'              => $titulo,
			// 'nome_fantasia'       => $nome_fantasia,
			'razao_social'        => $razao_social,
			'cnpj'                => $cnpj,
			'inscricao_estadual'  => $inscricao_estadual,
			'inscricao_municipal' => $inscricao_municipal,
			'cep'                 => $cep,
			'logradouro'          => $logradouro,
			'numero'              => $numero,
			'bairro'              => $bairro,
			'complemento'         => $complemento,
			'cidade'              => $cidade,
			'uf'                  => $uf,
			'pais'                => $pais,
			'quem_somos'          => $quem_somos,
			'telefone'            => $telefone,
			'celular'             => $celular,
			'email'               => $email,
			'facebook'            => $facebook,
			'instagram'           => $instagram,
			'youtube'             => $youtube,
			'linkedin'            => $linkedin,
			'github'              => $github,
			'gmaps'               => $gmaps,
			'aliquota_imposto'    => $aliquota_imposto,
			'tributacao'          => $tributacao,
			'certificado'         => $certificado,
			'senha_certificado'   => $senha_certificado,
			'ambiente'            => $ambiente,
			'sequence_nfe'        => $sequence_nfe,
			'serie_nfe'           => $serie_nfe,
			'sequence_nfce'       => $sequence_nfce,
			'tokencsc'            => $tokencsc,
			'csc'                 => $csc,
			'matriz'              => $matriz,
			'status'              => $status,
		];

		if (!is_null($quem_somos_imagem)) {
			$data['quem_somos_imagem'] = $quem_somos_imagem;
		}

		if (!is_null($distribuidor_imagem)) {
			$data['distribuidor_imagem'] = $distribuidor_imagem;
		}

		if (!is_null($contato_imagem)) {
			$data['contato_imagem'] = $contato_imagem;
		}

		$isUpdated = $this->from('tb_empresa')
			->where('id', $id_empresa)
			->update($data);

		if ($isUpdated) {

			$param                     = [];
			$remove_deptos             = 0;
			$departamentos_cadastrados = 0;
			$dpto                      = new DepartamentoModel();

			$p['id_empresa'] = $id_empresa;

			if (!empty($post->departamento)) {

				foreach ($post->departamento as $id_departamento) {

					$issetDepartamento = $dpto->getDepartamentoEmpresa($id_empresa, $id_departamento);

					// Adicionar o departamento à tabela `tb_departamento_empresa`;
					if (!isset($issetDepartamento)) {

						$param = ['id_empresa' => $id_empresa, 'id_departamento' => $id_departamento];
						if ($this->cadastraDepartamento($param)) {
							$departamentos_cadastrados++;
						}

					}

					$p['id_departamento'][] = $id_departamento;

				}

				if (!$this->removeDepartamento($p)) {
					return false;
				}

				if ($departamentos_cadastrados > 0) {
					return true;
				}

			} else {

				return $this->removeDepartamento($p);

			}

		}

		return $id_empresa;

	}

	public function cadastraDepartamento($dados = [])
	{

		return $this->from('tb_departamento_empresa')
			->insert($dados);

	}

	public function removeDepartamento($dados = [])
	{

		if (!empty($dados)) {

			$departamento_removido     = 0;
			$departamento_nao_removido = 0;
			$departamentos             = [];

			$id_empresa      = isset($dados['id_empresa']) ? $dados['id_empresa'] : false;
			$id_departamento = isset($dados['id_departamento']) ? $dados['id_departamento'] : false;

			$get = $this->select('id', 'id_departamento', 'id_empresa')
				->from('tb_departamento_empresa')
				->where('id_empresa', $id_empresa);

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

						$deleted = $this->from('tb_departamento_empresa')
							->where('id', $depto->id)
							->delete();

						$departamento_removido++;

					}

				}

			}

			if ($departamento_nao_removido > 0) {
				$message       = 'Você não pode remover os departamentos "' . implode('", "', $departamentos) . '" desta empresa enquanto houver funcionário nele';
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

	public function atualizaEmpresa($id, $campos = [])
	{

		return $this->from('tb_empresa')
			->whereIn('id', $id)
			->update($campos);

	}

	public function removeEmpresa($id_empresa)
	{

		$empresas_removidas     = [];
		$empresas_nao_removidas = [];

		foreach ($id_empresa as $ind => $id) {

			$departamentos = $this->select('id')
				->from('tb_departamento_empresa')
				->where('id_empresa', $id)
				->get();

			if ($departamentos->count() > 0) {

				foreach ($departamentos as $departamento) {

					$issetFuncionarios = $this->funcionario_model->getFuncionariosDepartamento($departamento->id);

					if ($issetFuncionarios) {

						$empresas_nao_removidas[] = $issetFuncionarios->empresa;
						array_splice($id_empresa, $ind, 1);

					} else {

						$empresas_removidas[] = $id;

					}

				}

			} else {

				$empresas_removidas['sem_departamentos'][] = $id;

			}

		}

		if (!empty($id_empresa)) {

			$removidas = $this->from('tb_empresa')
				->whereIn('id', $id_empresa)
				->delete();

			if ($removidas) {

				$s             = count($id_empresa) > 1 ? 's' : null;
				$this->error[] = 'A' . $s . ' empresa' . $s . ' ' . (implode(', ', $id_empresa)) . ' ' . (count($id_empresa) > 1 ? ' foram ' : ' foi ') . ' removida' . $s;

			} else {

				$this->error[] = 'Não foi possível remover as empresas ' . (implode(', ', $id_empresa));

			}
		}

		if (!empty($empresas_nao_removidas)) {
			$s             = count($empresas_nao_removidas) > 1 ? 's' : null;
			$this->error[] = 'A' . $s . ' empresa' . $s . ' <b>' . (implode(', ', $empresas_nao_removidas)) . '</b> não ' . (count($empresas_nao_removidas) > 1 ? ' podem ' : ' pode ') . ' ser removida enquanto existirem funcionários cadastrados nela.' . $s;
		}

		if (!empty($this->error)) {
			return false;
		}

		return true;

	}
}
