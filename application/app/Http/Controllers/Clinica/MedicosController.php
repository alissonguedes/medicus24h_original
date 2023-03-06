<?php

namespace App\Http\Controllers\Clinica{

	use App\Models\ConvenioModel;
	use App\Models\DepartamentoModel;
	use App\Models\EmpresaModel;
	use App\Models\EspecialidadeModel;
	use App\Models\EstadoCivilModel;
	use App\Models\MedicoModel;
	use Illuminate\Http\Request;
	use Illuminate\Validation\Rule;

	class MedicosController extends Controller
	{

		public function __construct()
		{

			$this->convenio_model      = new ConvenioModel();
			$this->especialidade_model = new EspecialidadeModel();
			$this->medico_model        = new MedicoModel();
			$this->estadoCivil_model   = new EstadoCivilModel();
			$this->departamento_model  = new DepartamentoModel();
			$this->empresa_model       = new EmpresaModel();

		}

		public function index(Request $request)
		{

			if ($request->ajax()) {
				$dados['paginate'] = $this->medico_model->getMedicos($request);
				return response(view('clinica.medicos.list', $dados), 200);
			}

			return view('clinica.medicos.index');

		}

		public function form(Request $request, $id = null)
		{

			$medico                      = $this->medico_model->getMedicoById($id);
			$dados['row']                = $medico;
			$dados['issetMedicoClinica'] = $this->medico_model;
			$dados['convenios']          = $this->convenio_model->getConvenio();
			$dados['estado_civil']       = $this->estadoCivil_model->getEstadoCivil();
			$dados['especialidades']     = $this->especialidade_model->getEspecialidades();
			$dados['departamentos']      = $this->departamento_model->getDepartamentos();
			$dados['empresas']           = $this->empresa_model->getEmpresasByDepartamentos($medico->id_departamento);

			return view('clinica.medicos.form', $dados);

		}

		/**
		 * Função para listar itens do Select
		 */
		public function autocomplete(Request $request)
		{

			$medicos = [];

			$dados = $this->medico_model->getMedicosEmpresa($request);

			foreach ($dados as $medico) {
				$medicos['items'][] = [
					'id'   => $medico->id,
					'text' => $medico->nome,
				];
			}

			return response()->json($medicos);

		}

		public function formValidate(Request $request)
		{
			return $request->validate([
				// 'nome'          => 'required',
				// 'email'         => [
				// 	'nullable|email|required_if:receber_notificacoes,on',
				// 	Rule::unique('tb_medico', 'email')->ignore($request->post('id'), 'id'),
				// ],
				// 'cpf'           => [
				// 	'required',
				// 	Rule::unique('tb_medico', 'cpf')->ignore($request->post('id'), 'id'),
				// ],
				// 'rg'            => [
				// 	'required',
				// 	Rule::unique('tb_medico', 'rg')->ignore($request->post('id'), 'id'),
				// ],
				'crm'           => [
					'required',
					Rule::unique('tb_medico', 'crm')->ignore($request->post('id'), 'id'),
				],
				'especialidade' => 'required',

			]);
		}

		public function create(Request $request)
		{

			$this->formValidate($request);

			$id = $this->medico_model->cadastraMedico($request);

			$status = 'success';
			$url    = url()->route('clinica.medicos.index');

			$data['status']      = 'success';
			$data['type']        = 'refresh';
			$data['clean_form']  = true;
			$data['close_modal'] = true;
			$data['url']         = url()->route('clinica.medicos.index');
			$data['message']     = 'Registro inserido com sucesso!';

			return response()->json($data);

		}

		public function edit(Request $request)
		{

			$this->formValidate($request);

			$id = $request->id;

			$this->medico_model->editaMedico($request, $id);

			$data['status']      = 'success';
			$data['type']        = 'refresh';
			$data['clean_form']  = true;
			$data['close_modal'] = true;
			$data['url']         = url()->route('clinica.medicos.index');
			$data['message']     = 'Registro atualizado com sucesso!';

			return response()->json($data);

		}

		public function patch(Request $request)
		{

			$this->medico_model->from('tb_medico')
				->whereIn('id', $request->id)
				->update([$request->field => $request->value]);

			return response()->json([
				'message' => 'Médico atualizado com sucesso!',
			]);

		}

		public function delete(Request $request)
		{

			$this->medico_model->from('tb_medico')->whereIn('id', $request->id)->delete();

			$status  = 'success';
			$message = 'Medico removido com sucesso!';
			$url     = url()->route('clinica.medicos.index');
			$type    = 'send';

			return json_encode(['status' => $status, 'message' => $message, 'type' => $type, 'url' => $url], 200);

		}

	}

}
