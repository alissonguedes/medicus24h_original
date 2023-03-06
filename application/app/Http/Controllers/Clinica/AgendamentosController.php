<?php

namespace App\Http\Controllers\Clinica{

	use App\Models\AgendamentoModel;
	use App\Models\ConvenioModel;
	use App\Models\DepartamentoModel;
	use App\Models\EstadoCivilModel;
	use Illuminate\Http\Request;
	use \App\Models\PacienteModel;

	// use Illuminate\Validation\Rule;

	class AgendamentosController extends Controller
	{

		public function __construct()
		{

			$this->convenio_model     = new ConvenioModel();
			$this->agendamento_model  = new AgendamentoModel();
			$this->departamento_model = new DepartamentoModel();
			$this->estadoCivil_model  = new EstadoCivilModel();
			$this->paciente_model     = new PacienteModel();

		}

		public function index(Request $request, $tipo = null)
		{

			// Pesquisar agendamentos
			if ($request->ajax()) {
				$dados['paginate'] = $this->agendamento_model->getAgendamentos($request);
				return response(view('clinica.agendamentos.list', $dados), 200);
			}

			return response(view('clinica.agendamentos.index'), 200);

		}

		public function form(Request $request, $agendamento, $paciente = null)
		{

			$dados['paciente_model'] = $this->paciente_model;
			$dados['departamentos']  = $this->departamento_model->getDepartamentos();

			if (!is_null($paciente) && $agendamento == 'add') {

				if ($this->paciente_model->isBlocked($paciente)) {

					$status  = 'warn';
					$title   = 'Paciente inativo!';
					$message = 'Não é possível realizar o agendamento.';

					return response()->json(['status' => $status, 'title' => $title, 'message' => $message]);

				}

				$dados['paciente'] = $this->paciente_model->getPacienteById($paciente);

			} else {

				$dados['row'] = $this->agendamento_model->getAgendamentoById($agendamento);

			}

			return response(view('clinica.agendamentos.form', $dados), 200);

		}

		public function get_eventos(Request $request, $tipo = null)
		{

			if (!$request->ajax) {
				return response(view('clinica.agendamentos.index'), 200);
			}

			$eventos = [];

			$dados = $this->agendamento_model->getEventos($request);

			if ($dados) {
				foreach ($dados as $row) {
					$medico = $this->agendamento_model->select('nome')
						->from('tb_funcionario AS F')
						->where('id', function ($query) use ($row) {
							$query->select('id_funcionario')
								->from('tb_medico AS M')
								->whereColumn('M.id_funcionario', 'F.id')
								->where('M.id', function ($query) use ($row) {
									$query->select('id_medico')
										->from('tb_medico_clinica')
										->where('id', $row->id_medico);
								});
						})
						->first();

					$evento = '<b style="margin-right: 5px;"> ' . date('H:i', strtotime($row->hora_agendada)) . '</b>';
					$evento .= 'Paciente: ' . $row->paciente . '<br>';
					$evento .= 'Médico: ' . $medico->nome . '<br>';
					$evento .= 'Especialidade: ' . $medico->nome . '<br>';
					$evento .= 'Clinica: ' . $row->clinica . '<br>';

					$eventos[] = [
						'title' => $evento,
						'id'    => $row->id,
						'start' => $row->data . 'T' . $row->hora_agendada,
						'end'   => $row->data . 'T' . $row->hora_agendada,
						'url'   => route('clinica.agendamentos.edit', $row->id),
						// 'backgroundColor' => '#ff0000',
						// 'color'           => '#00ff00',
					];
				}
			}

			return response()->json($eventos);

		}

		public function getDepartamentos(Request $request)
		{

			$dados['select'] = $this->agendamento_model->getDepartamentos($request->clinica);
			return view('clinica.agendamentos.select_departamentos', $dados);

		}

		public function validateForm(Request $request)
		{

			return $request->validate([
				'especialidade' => 'required',
				'clinica'       => 'required',
				'medico'        => [
					'required',
					// 'regex:/[\d]{2}\.[\d]{3}\.[\d]{3}\/[\d]{4}\-[\d]{2}/i',
					// Rule::unique('tb_agendamento', 'cnpj')->ignore($request->post('id'), 'id'),
				],
				'tipo'          => [
					'required',
					// Rule::unique('tb_agendamento', 'inscricao_estadual')->ignore($request->post('id'), 'id'),
				],
				'categoria'     => [
					'required',
					'required_if:receber_notificacoes,on',
				],
				'data'          => [
					'required',
					'regex:/(([0-2][0-9])|([3][0-1]))\/(([0][0-9])|([1][0-2]))\/([20][0-9]{2})/i',
				],
				'hora'          => [
					'required',
					'regex:/(([0-1][0-9])|[2][0-3])\:([0-5][0-9])/i',
				],
				'nome_paciente' => 'required',
			]);

		}

		public function create(Request $request)
		{

			$this->validateForm($request);
			$id = $this->agendamento_model->cadastraAgendamento($request);

			$status  = 'success';
			$message = 'Agendamento realizado com sucesso!';
			$close   = true;

			$data['status']      = $status;
			$data['type']        = 'refresh';
			$data['close_modal'] = $close;
			$data['url']         = url()->route('clinica.agendamentos.index');
			$data['message']     = $message;

			return response()->json($data);

		}

		public function edit(Request $request)
		{

			$this->validateForm($request);

			$id = $request->id;

			if ($this->agendamento_model->editaAgendamento($request, $id)) {
				$status  = 'success';
				$message = 'Cadastro alterado com sucesso!';
			} else {
				$status = 'error';
				// $message = 'Não foi possível atualizar os dados.';
				$message = $this->agendamento_model->getErros();
			}

			$status  = 'success';
			$message = 'Agendamento atualizado com sucesso!';
			$close   = true;

			$data['status']      = $status;
			$data['type']        = 'refresh';
			$data['close_modal'] = $close;
			$data['url']         = url()->route('clinica.agendamentos.index');
			$data['message']     = $message;

			return response()->json($data);

		}

		public function patch(Request $request)
		{

			$status  = 'error';
			$message = 'Não foi possível atualizar a agendamento.';

			if ($this->agendamento_model->atualizaAgendamento($request->id, [$request->field => $request->value])) {

				$status  = 'success';
				$message = 'Clínica atualizada com sucesso!';

			}

			$data['status']      = $status;
			$data['type']        = 'refresh';
			$data['clean_form']  = true;
			$data['close_modal'] = true;
			$data['url']         = url()->route('clinica.clinicas.index');
			$data['message']     = $message;

			return response()->json($data);

		}

		public function delete(Request $request)
		{

			if ($this->agendamento_model->removeAgendamento($request->id)) {
				$status  = 'success';
				$message = 'Agendamento cancelado com sucesso!';
			} else {
				$status  = 'error';
				$message = $this->agendamento_model->getErros();
			}

			$close = true;

			$data['status']      = $status;
			$data['type']        = 'redirect';
			$data['close_modal'] = $close;
			$data['url']         = url()->route('clinica.agendamentos.index');
			$data['message']     = $message;

			return response()->json($data);

		}

	}

}
