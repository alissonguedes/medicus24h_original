<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PacienteModel extends Model
{

	use HasFactory;

	protected $table = 'tb_paciente';
	protected $order = [
		null,
		'nome',
		'telefone',
		'codigo',
		'data_nascimento',
		'convenio',
		'status',
		'status',
	];

	private $path = 'assets/clinica/img/pacientes/';

	public function getPacientes($data = null)
	{

		$get = $this->select(
			'id',
			'nome',
			'codigo',
			'imagem',
			'associado',
			'id_estado_civil',
			'id_etnia',
			'sexo',
			'data_nascimento',
			'cpf',
			'rg',
			'cns',
			'mae',
			'pai',
			'notas_gerais',
			'notas_alergias',
			'notas_clinicas',
			'logradouro',
			'numero',
			'complemento',
			'cidade',
			'bairro',
			'cep',
			'uf',
			'pais',
			'email',
			'telefone',
			'celular',
			'receber_notificacoes',
			'receber_email',
			'receber_sms',
			'obito',
			DB::raw('DATE_FORMAT(datahora_obito, "%d/%m/%Y") AS data_obito'),
			DB::raw('DATE_FORMAT(datahora_obito, "%H:%i") AS hora_obito'),
			'status',
			DB::raw('(SELECT descricao FROM tb_etnia WHERE id = id_etnia) AS etnia'),
			DB::raw('DATE_FORMAT(data_nascimento, "%d/%m/%Y") AS data_nascimento'),
		);

		if (isset($data) && $search = $data['query']) {
			$get->where(function ($query) use ($search) {
				$query
					->orWhere('codigo', 'like', $search . '%')
					->orWhere('nome', 'like', $search . '%')
					->orWhere('matricula', 'like', $search . '%')
					->orWhere('rg', 'like', $search . '%')
					->orWhere('email', 'like', $search . '%')
					->orWhere('cpf', 'like', $search . '%')
					->orWhere('cns', 'like', $search . '%')
					->orWhere('telefone', 'like', $search . '%')
					->orWhere('celular', 'like', $search . '%');
			});
		}

		if (isset($data['status'])) {
			$get->where('status', $data['status']);
		}

		if (isset($data['obito'])) {
			$get->where('obito', $data['obito']);
		}

		// if (isset($data['filter']) && isset($data['value'])) {

		// 	$get->where($data['filter'], $data['value']);

		// }

		// Order By
		if (isset($_GET['order']) && $_GET['order'][0]['column'] != 0) {
			$get->orderBy($this->order[$_GET['order'][0]['column']], $_GET['order'][0]['dir']);
		} else {
			$get->orderBy($this->order[1], 'asc');
		}

		return $get->paginate(isset($_GET['length']) ? $_GET['length'] : 50);

	}

	public function getPacienteById($id)
	{

		return $this->getPacientes()
			->where('id', $id)
			->first();

	}

	public function isBlocked($id)
	{
		return $this->getPacientes()
			->where('id', $id)
			->where('status', '0')
			->first() ? true : false;
	}

	// public function searchPacientes(Request $request)
	// {
	//
	// $query = $request->get('query');
	//
	// return $this->getPacientes()
	// 	->where('nome', 'like', '%' . $query . '%')
	// 	->paginate(isset($_GET['length']) ? $_GET['length'] : 50);
	//
	// }

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

	public function getConvenios($id = null)
	{

		$get = $this->select(
			'id',
			'id_convenio', 'id_tipo', 'id_acomodacao',
			DB::raw('(SELECT nome FROM tb_paciente WHERE id = id_paciente) AS paciente'),
			DB::raw('(SELECT descricao FROM tb_convenio WHERE id = id_convenio) AS convenio'),
			DB::raw('(SELECT descricao FROM tb_convenio WHERE id = id_tipo) AS tipo'),
			DB::raw('(SELECT descricao FROM tb_acomodacao WHERE id = id_acomodacao) AS acomodacao'),
			'matricula',
			'validade_mes',
			'validade_ano'
		)->from('tb_paciente_convenio');

		$get = $get //->where('id_convenio', '<>', '3')
			->where('status', '1');

		if (!is_null($id)) {
			return $get->where('id_paciente', $id)
				->get()
				->first();
		}

		return $get->get();

	}

	/**
	 * Obter os dados do convênio Médicus24 que estiver ativo
	 */
	public function getConvenioMedicus($id = null)
	{

		$get = $this->select(
			'id',
			'id_convenio', 'id_tipo', 'id_acomodacao',
			DB::raw('(SELECT nome FROM tb_paciente WHERE id = id_paciente) AS paciente'),
			DB::raw('(SELECT descricao FROM tb_convenio WHERE id = id_convenio) AS convenio'),
			DB::raw('(SELECT descricao FROM tb_convenio WHERE id = id_tipo) AS tipo'),
			DB::raw('(SELECT descricao FROM tb_acomodacao WHERE id = id_acomodacao) AS acomodacao'),
			'matricula',
			'validade_mes',
			'validade_ano'
		)->from('tb_paciente_convenio');

		$get = $get->where('id_convenio', '3')
			->where('status', '1');

		if (!is_null($id)) {
			return $get->where('id_paciente', $id)
				->get()
				->first();
		}

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

	public function cadastraPaciente($post)
	{

		$associado            = $post->associado === '1' ? 'yes' : 'no';
		$matricula            = $post->matricula_medicus;
		$validade             = $post->validade_medicus ?? null;
		$id_estado_civil      = $post->estado_civil;
		$id_etnia             = $post->etnia ?? 1;
		$nome                 = $post->nome;
		$imagem               = $this->uploadImage($post);
		$codigo               = 'P-' . rand(111111, 999999);
		$sexo                 = $post->sexo;
		$data_nascimento      = $post->data_nascimento ? convert_to_date($post->data_nascimento, 'Y-m-d') : null;
		$cpf                  = $post->cpf;
		$rg                   = $post->rg;
		$cns                  = $post->cns;
		$mae                  = $post->mae;
		$pai                  = $post->pai;
		$notas_clinicas       = $post->notas_clinicas;
		$notas_gerais         = $post->notas_gerais;
		$notas_alergias       = $post->notas_alergias;
		$logradouro           = $post->logradouro;
		$complemento          = $post->complemento;
		$numero               = $post->numero;
		$cidade               = $post->cidade;
		$bairro               = $post->bairro;
		$cep                  = $post->cep;
		$uf                   = $post->uf;
		$pais                 = $post->pais;
		$email                = $post->email;
		$telefone             = $post->telefone;
		$celular              = $post->celular;
		$receber_notificacoes = $post->receber_notificacoes ?? 'off';
		$receber_email        = $post->receber_email ?? 'off';
		$receber_sms          = $post->receber_sms ?? 'off';
		$datahora_obito       = $post->data_obito && $post->hora_obito ? convert_to_date($post->data_obito . ' ' . $post->hora_obito, 'Y-m-d H:i') : null;
		$obito                = ($datahora_obito || $post->obito) ? '1' : '0';
		$status               = ($obito == '0' && $post->status) ? '1' : '0';

		$data = [
			'associado'            => $associado,
			'matricula'            => $matricula,
			'validade'             => $validade,
			'id_estado_civil'      => $id_estado_civil,
			'id_etnia'             => $id_etnia,
			'codigo'               => $codigo,
			'nome'                 => $nome,
			'imagem'               => $imagem,
			'sexo'                 => $sexo,
			'data_nascimento'      => $data_nascimento,
			'cpf'                  => $cpf,
			'rg'                   => $rg,
			'cns'                  => $cns,
			'mae'                  => $mae,
			'pai'                  => $pai,
			'notas_clinicas'       => $notas_clinicas,
			'notas_gerais'         => $notas_gerais,
			'notas_alergias'       => $notas_alergias,
			'logradouro'           => $logradouro,
			'numero'               => $numero,
			'complemento'          => $complemento,
			'cidade'               => $cidade,
			'bairro'               => $bairro,
			'cep'                  => $cep,
			'uf'                   => $uf,
			'pais'                 => $pais,
			'email'                => $email,
			'telefone'             => $telefone,
			'celular'              => $celular,
			'receber_notificacoes' => $receber_notificacoes,
			'receber_email'        => $receber_email,
			'receber_sms'          => $receber_sms,
			'obito'                => $obito,
			'datahora_obito'       => $datahora_obito,
			'status'               => $status,
		];

		$id = $this->from('tb_paciente')
			->insertGetId($data);

		return $id;

	}

	public function editaPaciente(Request $post, $id)
	{

		$associado = $post->associado ?? 'no';
		// $matricula            = $post->matricula_medicus;
		// $validade             = $post->validade_medicus ?? null;
		$id_estado_civil      = $post->estado_civil;
		$id_etnia             = $post->etnia ?? 1;
		$nome                 = $post->nome;
		$imagem               = $this->uploadImage($post);
		$sexo                 = $post->sexo;
		$data_nascimento      = $post->data_nascimento ? convert_to_date($post->data_nascimento, 'Y-m-d') : null;
		$cpf                  = $post->cpf;
		$rg                   = $post->rg;
		$cns                  = $post->cns;
		$mae                  = $post->mae;
		$pai                  = $post->pai;
		$notas_clinicas       = $post->notas_clinicas;
		$notas_gerais         = $post->notas_gerais;
		$notas_alergias       = $post->notas_alergias;
		$logradouro           = $post->logradouro;
		$complemento          = $post->complemento;
		$numero               = $post->numero;
		$cidade               = $post->cidade;
		$bairro               = $post->bairro;
		$cep                  = $post->cep;
		$uf                   = $post->uf;
		$pais                 = $post->pais;
		$email                = $post->email;
		$telefone             = $post->telefone;
		$celular              = $post->celular;
		$receber_notificacoes = $post->receber_notificacoes ?? 'off';
		$receber_email        = $post->receber_email ?? 'off';
		$receber_sms          = $post->receber_sms ?? 'off';
		$datahora_obito       = $post->data_obito && $post->hora_obito ? convert_to_date($post->data_obito . ' ' . $post->hora_obito, 'Y-m-d H:i') : null;
		$obito                = ($datahora_obito || $post->obito) ? '1' : '0';
		$status               = ($obito == '0' && $post->status) ? '1' : '0';

		$data = [
			'associado'            => $associado,
			// 'matricula'            => $matricula,
			// 'validade'             => $validade,
			'id_estado_civil'      => $id_estado_civil,
			'id_etnia'             => $id_etnia,
			'nome'                 => $nome,
			'sexo'                 => $sexo,
			'data_nascimento'      => $data_nascimento,
			'cpf'                  => $cpf,
			'rg'                   => $rg,
			'cns'                  => $cns,
			'mae'                  => $mae,
			'pai'                  => $pai,
			'notas_clinicas'       => $notas_clinicas,
			'notas_gerais'         => $notas_gerais,
			'notas_alergias'       => $notas_alergias,
			'logradouro'           => $logradouro,
			'numero'               => $numero,
			'complemento'          => $complemento,
			'cidade'               => $cidade,
			'bairro'               => $bairro,
			'cep'                  => $cep,
			'uf'                   => $uf,
			'pais'                 => $pais,
			'email'                => $email,
			'telefone'             => $telefone,
			'celular'              => $celular,
			'receber_notificacoes' => $receber_notificacoes,
			'receber_email'        => $receber_email,
			'receber_sms'          => $receber_sms,
			'obito'                => $obito,
			'datahora_obito'       => $datahora_obito,
			'status'               => $status,
		];

		if (!is_null($imagem)) {
			$data['imagem'] = $imagem;
		}

		$updated = $this->from('tb_paciente')
			->where('id', $id)
			->update($data);

		$this->addPlano($post, $id);

		return $updated;

	}

	public function addPlano($request, $id_paciente)
	{

		// Se o paciente for um associado da Medicus24h...
		if ($request->associado === 'yes') {

			$data = [
				'id_paciente'   => $id_paciente,
				'id_convenio'   => $request->convenio,
				'id_tipo'       => $request->id_tipo,
				'id_acomodacao' => $request->id_acomodacao,
				'matricula'     => $request->matricula,
				'validade_ano'  => $request->validade_ano,
				'validade_mes'  => $request->validade_mes,
				'status'        => '1',
			];

			$issetPlano = $this->select('id', 'validade_ano', 'validade_mes')
				->from('tb_paciente_convenio')
				->where('id_paciente', $id_paciente)
				->where('id_convenio', $request->convenio)
				->where('id_tipo', $request->id_tipo)
				->where('matricula', $request->matricula)
				->get()
				->first();

			// Se já existir um plano médicus24h, então, verificar se a data de validade é diferente
			if (isset($issetPlano)) {

				// Atualizar para status = 0 caso o plano tenha alteração nas datas de validades
				if ($issetPlano->validade_ano != $request->validade_ano or $issetPlano->validade_mes != $request->validade_mes) {

					$this->from('tb_paciente_convenio')
						->where('id', $issetPlano->id)
						->update(['status' => '0']);

					$this->from('tb_paciente_convenio')
						->insert($data);

				}

			} else {

				$this->from('tb_paciente_convenio')
					->insert($data);

			}

			dump($request);

		}

	}

	// public function addPlano($request)
	// {

	// 	if ($request->outros_convenios) {

	// 		$updated = false;
	// 		$planos  = array('id_paciente' => $request->id, 'status' => '1');

	// 		foreach ($request->outros_convenios as $v) {

	// 			$planos = array_merge($planos, json_decode($v, true));

	// 			$issetPlano = $this->select('id', 'id_paciente', 'validade_ano', 'validade_mes')
	// 				->from('tb_paciente_convenio')
	// 				->where('id_paciente', $planos['id_paciente'])
	// 				->where('id_convenio', $planos['id_convenio'])
	// 				->where('id_tipo', $planos['id_tipo'])
	// 				->where('id_acomodacao', $planos['id_acomodacao'])
	// 				->get()
	// 				->first();

	// 			if (isset($issetPlano)) {

	// 				// verifica se o ano e o mes de validade são iguais
	// 				if ($issetPlano->validade_ano != $planos['validade_ano'] || $issetPlano->validade_mes != $planos['validade_mes']) {

	// 					// Inativa o plano anterior (status = 0) e adiciona o novo
	// 					$updated = $this->from('tb_paciente_convenio')
	// 						->where('id', $issetPlano->id)
	// 						->update(['status' => '0']);

	// 				} else {

	// 					$this->from('tb_paciente_convenio')
	// 						->where('id', $issetPlano->id)
	// 						->update($planos);

	// 				}

	// 			}

	// 			if (!isset($issetPlano) || $updated) {

	// 				$this->from('tb_paciente_convenio')
	// 					->insert($planos);

	// 			}

	// 		}

	// 	}

	// }

	// public function getConvenioNextIdValue()
	// {

	// 	return $this->select(DB::raw('MAX(id) AS id'))
	// 		->from('tb_paciente_convenio')
	// 		->get()
	// 		->first() ?? DB::select('SHOW TABLE STATUS LIKE "tb_paciente_convenio"')[0]
	// 		->Auto_increment;

	// }

}
