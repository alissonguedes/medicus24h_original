<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanoModel extends Model
{

	use HasFactory;

	protected $table = 'tb_paciente_convenio';
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

	private $path = 'assets/clinica/img/planos/';

	public function getPlanos($data = null)
	{

		$get = $this->select(
			'id',
			'nome',
			'codigo',
			'imagem',
			'id_convenio',
			'id_acomodacao',
			'matricula_convenio',
			DB::raw('DATE_FORMAT(validade_convenio, "%d/%m/%Y") AS validade_convenio'),
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
			DB::raw('(SELECT descricao FROM tb_convenio WHERE id = id_convenio) AS convenio'),
			DB::raw('(SELECT descricao FROM tb_etnia WHERE id = id_etnia) AS etnia'),
			DB::raw('DATE_FORMAT(data_nascimento, "%d/%m/%Y") AS data_nascimento'),
		);

		if (isset($data) && $search = $data['query']) {
			$get->where(function ($query) use ($search) {
				$query
					->orWhere('codigo', 'like', $search . '%')
					->orWhere('nome', 'like', $search . '%')
					->orWhere('matricula_convenio', 'like', $search . '%')
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

	public function getPlanoById($id)
	{

		return $this->getPlanos()
			->where('id', $id)
			->first();

	}

	public function isBlocked($id)
	{
		return $this->getPlanos()
			->where('id', $id)
			->where('status', '0')
			->first() ? true : false;
	}

	// public function searchPlanos(Request $request)
	// {
	//
	// $query = $request->get('query');
	//
	// return $this->getPlanos()
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

	public function cadastraPlano($post)
	{

		$id_convenio          = $post->convenio ?? 1;
		$matricula_convenio   = $post->matricula ?? null;
		$validade_convenio    = $post->validade_convenio ? convert_to_date($post->validade_convenio, 'Y-m-d') : null;
		$id_acomodacao        = $post->acomodacao ?? 1;
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
			'id_convenio'          => $id_convenio,
			'matricula_convenio'   => $matricula_convenio,
			'validade_convenio'    => $validade_convenio,
			'id_acomodacao'        => $id_acomodacao,
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

		$id = $this->from('tb_plano')
			->insertGetId($data);

		return $id;

	}

	public function editaPlano(Request $post, $id)
	{

		$id_convenio          = $post->convenio ?? 1;
		$matricula_convenio   = $post->matricula ?? null;
		$validade_convenio    = $post->validade_convenio ? convert_to_date($post->validade_convenio, 'Y-m-d') : null;
		$id_acomodacao        = $post->acomodacao ?? 1;
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
			'id_convenio'          => $id_convenio,
			'matricula_convenio'   => $matricula_convenio,
			'validade_convenio'    => $validade_convenio,
			'id_acomodacao'        => $id_acomodacao,
			'id_estado_civil'      => $id_estado_civil,
			'id_etnia'             => $id_etnia,
			'nome'                 => $nome,
			// 'codigo'               => $codigo,
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

		$id = $this->from('tb_plano')
			->where('id', $id)
			->update($data);

		return $id;

	}

}
