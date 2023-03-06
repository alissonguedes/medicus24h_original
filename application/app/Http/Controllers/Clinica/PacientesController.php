<?php

namespace App\Http\Controllers\Clinica{

	use App\Http\Requests\Clinica\PacienteRequest;
	use App\Http\Requests\Clinica\PlanoRequest;
	use App\Models\ConvenioModel;
	use App\Models\EstadoCivilModel;
	// use App\Models\EtniaModel;
	// use Faker\Factory as Faker;
	use App\Models\PacienteModel;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Session;

	class PacientesController extends Controller
	{

		private $paciente;
		private $request;

		public function __construct(
			ConvenioModel $convenio,
			PacienteModel $paciente,
			EstadoCivilModel $estado_civil,
			// EtniaModel $etnia,
			Request $request
		) {

			$this->request      = $request;
			$this->paciente     = $paciente;
			$this->convenio     = $convenio;
			$this->estado_civil = $estado_civil;
			// $this->etnia        = $etnia;

		}

		public function index()
		{

			// Remover a sessão de geração da matrícula do convênio para liberar
			Session::forget('matricula');

			$dados['pacientes'] = $this->paciente->getPacientes($this->request);

			if ($this->request->ajax()) {
				return response(view('clinica.pacientes.results', $dados), 200);
			}

			return response(view('clinica.pacientes.index', $dados), 200);

		}

		/**
		 * Form Method to form view
		 * @param $id <int: null>
		 */
		public function form($id = null)
		{

			$dados = [
				'convenios'          => $this->convenio->getConvenio(),
				'tipo'               => $this->convenio->getTipoConvenio(),
				'acomodacoes'        => $this->convenio->getAcomodacao(),
				'medicus_tipo'       => $this->convenio->getTipoConvenio(null, 3),
				'estado_civil'       => $this->estado_civil->getEstadoCivil(),
				'etnias'             => $this->paciente->getEtnia(),
				'paciente_convenios' => $this->paciente->getConvenios(null, $id),
			];

			if (!is_null($id)) {
				$dados['paciente'] = $this->paciente->getPacienteById($id);
			}

			if (!session()->exists('matricula')) {
				session()->put('matricula', gera_cartao(null, true));
				$dados['matricula'] = session()->get('matricula');
			} else {
				$dados['matricula'] = session()->get('matricula');
			}

			return response(view('clinica.pacientes.form', $dados), 200);

		}

		/**
		 * Form Method to form view
		 * @param $id <int: null>
		 */
		public function form_plano($id = null)
		{

			if (!is_null($id)) {
				$dados['plano'] = $this->paciente->getPacienteById($id);
			}

			$dados = [
				'convenios'   => $this->convenio->getConvenio(),
				'tipo'        => $this->convenio->getTipoConvenio(),
				'acomodacoes' => $this->convenio->getAcomodacao(),
			];

			return response(view('clinica.pacientes.modal_form_planos', $dados), 200);

		}

		/**
		 * AutoComplete Method to Select Form
		 */
		public function autocomplete()
		{

			$complete = [];

			$dados = $this->paciente->getPacientes($this->request);

			foreach ($dados as $row) {
				$complete['items'][] = [
					'id'   => $row->id,
					'text' => $row->nome,
				];
			}

			return response($complete, 200);

		}

		/**
		 * Get Method to get pacient data
		 * @param $id <int>
		 */
		public function get($id)
		{

			$result = $this->paciente->getPacienteById($id);

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

		public function create(PacienteRequest $paciente)
		{

			return $this->post($paciente);

		}

		public function post(PacienteRequest $paciente)
		{

			$id = $this->paciente->create($paciente->all());

			return response()->json([
				'status'      => 'success',
				'message'     => 'Paciente cadastrado com sucesso!',
				'clean_form'  => true,
				'close_modal' => false,
				'type'        => 'redirect',
				'url'         => url()->route('clinica.pacientes.edit', $id),
			]);

		}

		public function edit(PacienteRequest $paciente)
		{

			return $this->put($paciente);

		}

		public function put(PacienteRequest $paciente)
		{

			$id = $this->paciente->edit($paciente->all());

			return response()->json([
				'status'      => 'success',
				'message'     => 'Paciente editado com sucesso!',
				'clean_form'  => true,
				'close_modal' => false,
				// 'type'=>'redirect',
				'url'         => url()->route('clinica.pacientes.edit', $id),
			]);

		}

		public function patch()
		{

		}

		public function delete()
		{

		}

		public function add_plano(PlanoRequest $plano)
		{

			$dados['convenio']   = $this->convenio->getConvenio($plano->id_plano)->first();
			$dados['tipo']       = $this->convenio->getTipoConvenio($plano->id_tipo_plano, $plano->id_plano)->first();
			$dados['acomodacao'] = $this->convenio->getAcomodacao($plano->id_acomodacao)->first();
			$dados['matricula']  = $plano->matricula;
			$dados['validade']   = ['mes' => $plano->validade_mes, 'ano' => $plano->validade_ano];

			$data['data']        = view('clinica.pacientes.planos', $dados)->render();
			$data['close_modal'] = true;

			return response($data, 200);

		}

	}

}
