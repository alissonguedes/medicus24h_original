<?php

namespace App\Http\Controllers\Clinica{

	use App\Models\ConvenioModel;
	use App\Models\EstadoCivilModel;
	use App\Models\PacienteModel;
	use Faker\Factory as Faker;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Session;
	use Illuminate\Validation\Rule;

	class PacientesController extends Controller
	{

		public function __construct()
		{

			$this->convenio_model    = new ConvenioModel();
			$this->paciente_model    = new PacienteModel();
			$this->estadoCivil_model = new EstadoCivilModel();
			$this->faker             = new Faker();

		}

		public function index(Request $request)
		{

			// Remover a sessão de geração da matrícula do convênio para liberar
			Session::forget('matricula');

			// Pesquisar pacientes
			if ($request->ajax()) {
				$dados['pacientes'] = $this->paciente_model->getPacientes($request);
				return response(view('clinica.pacientes.results', $dados), 200);
			}

			$dados['faker']     = $this->faker::create('pt_BR');
			$dados['pacientes'] = $this->paciente_model->getPacientes($request);

			return response(view('clinica.pacientes.index', $dados), 200);

		}

		public function form(Request $request, $id = null)
		{

			// Remover a sessão de geração da matrícula do convênio para liberar
			// Session::forget('matricula');

			if (!session()->exists('matricula')) {
				session()->put('matricula', gera_cartao(null, true));
				$dados['matricula'] = session()->get('matricula');
			} else {
				$dados['matricula'] = session()->get('matricula');
			}

			$dados['row']                    = $this->paciente_model->getPacienteById($request->id);
			$dados['convenios_medicus_tipo'] = $this->convenio_model->getTipoConvenio(3);
			$dados['acomodacoes']            = $this->paciente_model->getAcomodacao();
			$dados['convenios']              = $this->convenio_model->getConvenio();
			$dados['convenio_medicus']       = $this->paciente_model->getConvenioMedicus($id);
			$dados['etnias']                 = $this->paciente_model->getEtnia();
			$dados['estado_civil']           = $this->estadoCivil_model->getEstadoCivil();

			$dados['paciente_convenios'] = $this->paciente_model->getConvenios();

			return view('clinica.pacientes.form', $dados);

		}

		public function get(Request $request, $id)
		{

			$result = $this->paciente_model->getPacienteById($id);

			$paciente['mae']             = $result->mae;
			$paciente['pai']             = $result->pai;
			$paciente['data_nascimento'] = $result->data_nascimento;
			$paciente['cpf']             = $result->cpf;
			$paciente['telefone']        = $result->telefone;
			$paciente['convenio']        = $result->convenio;
			$paciente['matricula']       = $result->matricula_convenio;
			$paciente['validade']        = $result->validade_convenio;
			$paciente['observacao']      = $result->notas;
			$paciente['enviar_email']    = $result->enviar_email;

			return $paciente;

		}

		public function autocomplete(Request $request)
		{

			$clinicas = [];

			$dados = $this->paciente_model->getPacientes($request);

			foreach ($dados as $clinica) {
				$clinicas['items'][] = [
					'id'   => $clinica->id,
					'text' => $clinica->nome,
				];
			}

			return response($clinicas, 200);

		}

		public function agendar(Request $request, $id = null)
		{

			if ($this->paciente_model->isBlocked($request->id)) {

				$status  = 'warn';
				$title   = 'Paciente inativo!';
				$message = 'Não é possível realizar o agendamento.';

				return response()->json(['status' => $status, 'title' => $title, 'message' => $message]);

			}

			$dados['row']          = null;
			$dados['paciente']     = $this->paciente_model->getPacienteById($request->id);
			$dados['acomodacoes']  = $this->paciente_model->getAcomodacao();
			$dados['etnias']       = $this->paciente_model->getEtnia();
			$dados['convenios']    = $this->convenio_model->getConvenio();
			$dados['estado_civil'] = $this->estadoCivil_model->getEstadoCivil();
			return view('clinica.agendamentos.form', $dados);

		}

		public function create(Request $request)
		{

			$request->validate([
				'nome'       => 'required',
				'telefone'   => 'required_if:celular,null',
				'celular'    => 'required_if:telefone,null',
				'email'      => 'email|required_if:receber_notificacoes,on',
				'data_obito' => 'required_if:obito,true',
				'hora_obito' => Rule::requiredIf($request->obito == 1 || $request->data_obito),
			]);

			$id = $this->paciente_model->cadastraPaciente($request);

			$status = 'success';
			$url    = url()->route('clinica.pacientes.edit', $id);
			$type   = 'redirect';

			// Remover a sessão de geração da matrícula do convênio para liberar
			Session::forget('matricula_convenio');

			return response()->json([
				'status'      => $status,
				'message'     => 'Paciente cadastrado com sucesso!',
				'clean_form'  => true,
				'close_modal' => false,
				'type'        => $type,
				'url'         => $url,
			]);
		}

		public function edit(Request $request)
		{

			// $request->validate([
			// 	'nome'       => 'required',
			// 	'email'      => 'email|required|required_if:receber_notificacoes,on',
			// 	'cpf'        => 'required',
			// 	'telefone'   => 'required_if:celular,null',
			// 	'celular'    => 'required_if:telefone,null',
			// 	'data_obito' => 'required_if:obito,1',
			// 	'hora_obito' => Rule::requiredIf($request->obito == 1 || $request->data_obito),
			// ]);

			$id = $request->id;

			$updated = $this->paciente_model->editaPaciente($request, $id);

			$status = $updated ? 'success' : 'error';
			$url    = url()->route('clinica.pacientes.index');
			$type   = null;

			// Remover a sessão de geração da matrícula do convênio para liberar
			Session::forget('matricula_convenio');

			if (request()->ajax()) {

				return response()->json([
					'status'      => $status,
					'message'     => 'Dados atualizados com sucesso!',
					'clean_form'  => true,
					'close_modal' => false,
					'type'        => $type,
					'url'         => $url,
				]);

			} else {

				return redirect($url)
					->with([
						'status'  => 'success',
						'message' => 'Dados atualizados com sucesso',
					]);

			}

		}

		public function patch(Request $request)
		{

			$this->paciente_model->from('tb_paciente')
				->whereIn('id', $request->id)
				->update([$request->field => $request->value]);

			return response()->json([
				'message' => 'Paciente atualizado com sucesso!',
			]);

		}

		public function delete(Request $request)
		{

			$this->paciente_model->from('tb_paciente')->whereIn('id', $request->id)->delete();

			$status  = 'success';
			$message = 'Paciente removido com sucesso!';
			$url     = url()->route('clinica.pacientes.index');
			$type    = 'send';

			return json_encode(['status' => $status, 'message' => $message, 'type' => $type, 'url' => $url], 200);

		}

		/** Formulário Modal para Adicionar Planos de Saúde à  lista de planos do paciente */
		public function form_plano(Request $request, $id = null)
		{

			$data = [
				'convenios'   => $this->convenio_model->getConvenio(),
				'acomodacoes' => $this->convenio_model->getAcomodacao(),
			];

			return view('clinica.pacientes.modal_form_planos', $data);

		}

		public function add_plano(Request $request)
		{

			dd($request);

		}

	}

}
