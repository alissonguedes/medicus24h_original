<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EspecialidadeModel extends Model
{

	use HasFactory;

	protected $table = 'tb_especialidade';
	protected $order = [
		null,
		'especialidade',
		'descricao',
		'created_at',
		'updated_at',
	];

	private $path = 'assets/clinica/img/especialidades/';

	public function getEspecialidades($data = null)
	{

		$get = $this->select(
			'id',
			'especialidade',
			'descricao',
			DB::raw('DATE_FORMAT(created_at, "%d/%m/%Y") AS data_cadastro'),
			DB::raw('DATE_FORMAT(updated_at, "%d/%m/%Y") AS data_atualizacao'),
			'status'
		);

		if (isset($data) && $search = $data['search']['value']) {
			$get->where(function ($query) use ($search) {
				$query
					->orWhere('id', 'like', $search . '%')
					->orWhere('especialidade', 'like', $search . '%')
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

	public function getEspecialidadeById($id)
	{

		return $this->getEspecialidades()
			->where('id', $id)
			->first();

	}

	public function searchEspecialidades(Request $request)
	{

		$id    = $request->get('id');
		$query = $request->get('query');

		$get = $this->select('id', 'especialidade');

		if (!empty($query)) {
			$get->where('especialidade', 'like', $query . '%');
		}

		if ($id) {
			$get->orWhere('id', 'like', $id . '%');
		}

		$get->orderBy('especialidade', 'asc')
			->limit($request->length ?? 10);

		return $get->get();

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

	public function cadastraEspecialidade($post)
	{

		$especialidade = $post->especialidade;
		// $imagem               = $this->uploadImage($post);
		$descricao = $post->descricao;
		$status    = $post->status ?? '0';

		$data = [
			'especialidade' => $especialidade,
			// 'imagem'               => $imagem,
			'descricao'     => $descricao,
			// 'status'               => $status,
		];

		$id = $this->from('tb_especialidade')
			->insertGetId($data);

		return $id;

	}

	public function editaEspecialidade(Request $post, $id)
	{

		$especialidade = $post->especialidade;
		// $imagem               = $this->uploadImage($post);
		$descricao = $post->descricao;
		$status    = $post->status ?? '0';

		$data = [
			'especialidade' => $especialidade,
			// 'imagem'               => $imagem,
			'descricao'     => $descricao,
			// 'status'               => $status,
		];

		if (isset($imagem) && !empty($imagem)) {
			$data['imagem'] = $imagem;
		}

		$id = $this->from('tb_especialidade')
			->where('id', $id)
			->update($data);

		return $id;

	}

}
