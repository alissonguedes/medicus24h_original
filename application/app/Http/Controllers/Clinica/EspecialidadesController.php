<?php

namespace App\Http\Controllers\Clinica{

	use App\Models\ConvenioModel;
	use App\Models\EspecialidadeModel;
	use App\Models\EstadoCivilModel;
	use Illuminate\Http\Request;
	use Illuminate\Validation\Rule;

	class EspecialidadesController extends Controller
	{

		public function __construct()
		{

			$this->convenio_model      = new ConvenioModel();
			$this->especialidade_model = new EspecialidadeModel();
			$this->estadoCivil_model   = new EstadoCivilModel();

		}

		public function index(Request $request)
		{

			if ($request->ajax()) {
				$dados['paginate'] = $this->especialidade_model->getEspecialidades($request);
				return response(view('clinica.especialidades.list', $dados), 200);
			}

			$dados['especialidades'] = $this->especialidade_model->getEspecialidades();
			return view('clinica.especialidades.index', $dados);

		}

		/**
		 * Função para listar itens do Select
		 */
		public function autocomplete(Request $request)
		{

			$especialidades = [];
			$dados          = $this->especialidade_model->searchEspecialidades($request);

			if (!empty($dados)) {
				foreach ($dados as $especialidade) {
					$especialidades['items'][] = [
						'id'   => $especialidade->id,
						'text' => $especialidade->especialidade,
					];
				}
			}

			return response()->json($especialidades);

		}

		public function form(Request $request, $id = null)
		{

			$dados['row']          = $this->especialidade_model->getEspecialidadeById($id);
			$dados['acomodacoes']  = $this->especialidade_model->getAcomodacao();
			$dados['etnias']       = $this->especialidade_model->getEtnia();
			$dados['convenios']    = $this->convenio_model->getConvenio();
			$dados['estado_civil'] = $this->estadoCivil_model->getEstadoCivil();
			return view('clinica.especialidades.form', $dados);

		}

		public function create(Request $request)
		{

			$request->validate([
				'especialidade' => [
					'required',
					Rule::unique('tb_especialidade', 'especialidade')->ignore($request->post('id'), 'id'),
				],
				'descricao'     => 'nullable',
			]);

			$id = $this->especialidade_model->cadastraEspecialidade($request);

			$data['status']      = 'success';
			$data['type']        = 'refresh';
			$data['clean_form']  = true;
			$data['close_modal'] = true;
			$data['url']         = url()->route('clinica.especialidades.index');
			$data['message']     = 'Especialidade cadastrada com sucesso!';

			return response()->json($data);

		}

		public function edit(Request $request)
		{

			$request->validate([
				'especialidade' => [
					'required',
					Rule::unique('tb_especialidade', 'especialidade')->ignore($request->post('id'), 'id'),
				],
				'descricao'     => 'nullable',
			]);

			$id = $request->id;
			$this->especialidade_model->editaEspecialidade($request, $id);

			$data['status']      = 'success';
			$data['url']         = url()->route('clinica.especialidades.index');
			$data['type']        = 'refresh';
			$data['clean_form']  = true;
			$data['close_modal'] = true;
			$data['message']     = 'Dados atualizados com sucesso!';

			return response()->json($data);

		}

		public function patch(Request $request)
		{

			$this->especialidade_model->from('tb_especialidade')
				->whereIn('id', $request->id)
				->update([$request->field => $request->value]);

			return response()->json([
				'message' => 'Médico atualizado com sucesso!',
			]);

		}

		public function delete(Request $request)
		{

			$this->especialidade_model->from('tb_especialidade')->whereIn('id', $request->id)->delete();

			$status  = 'success';
			$message = 'Especialidade removido com sucesso!';
			$url     = url()->route('clinica.especialidades.index');
			$type    = 'send';

			return json_encode(['status' => $status, 'message' => $message, 'type' => $type, 'url' => $url], 200);

		}

	}

}
