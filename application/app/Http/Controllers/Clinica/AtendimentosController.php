<?php

namespace App\Http\Controllers\Clinica{

	use App\Models\AtendimentoModel;
	use App\Models\ConvenioModel;
	use App\Models\DepartamentoModel;
	use App\Models\EstadoCivilModel;
	use Illuminate\Http\Request;
	use Illuminate\Validation\Rule;

	class AtendimentosController extends Controller
	{

		public function __construct()
		{

			$this->convenio_model     = new ConvenioModel();
			$this->atendimento_model  = new AtendimentoModel();
			$this->departamento_model = new DepartamentoModel();
			$this->estadoCivil_model  = new EstadoCivilModel();

		}

		public function index(Request $request, $tipo = null)
		{

			// Pesquisar atendimentos
			if ($request->ajax()) {
				$dados['paginate'] = $this->atendimento_model->getAtendimentos($request);
				return response(view('clinica.atendimentos.list', $dados), 200);
			}

			return response(view('clinica.atendimentos.index'), 200);

		}

		/**
		 * Função para listar itens do Select
		 */
		public function autocomplete(Request $request, $tipo)
		{

			if (!$request->ajax()) {
				return redirect()->route('clinica.index');
			}

			switch ($tipo) {
				case 'categorias':
					$dados = $this->atendimento_model->getCategorias();
					break;
				case 'tipos':
					$dados = $this->atendimento_model->getTipos();
					break;
			}

			$tipos = [];

			foreach ($dados as $tipo) {
				$tipos['items'][] = [
					'id'   => $tipo->id,
					'text' => $tipo->titulo,
				];
			}

			return response()->json($tipos);

		}

		/**
		 * Função para listar itens do Select
		 */
		public function get_categoria_atendimento(Request $request)
		{

			$tipos = [];

			$dados = $this->atendimento_model->getCategorias();

			foreach ($dados as $tipo) {
				$tipos['items'][] = [
					'id'   => $tipo->id,
					'text' => $tipo->titulo,
				];
			}

			return response()->json($tipos);

		}

		public function datelhes_atendimento(Request $request, $id = null, $paciente = null)
		{

			$dados['row'] = $this->atendimento_model->getAtendimentoById($request->id);

			return response(view('clinica.atendimentos.datelhes_atendimento', $dados), 200);

		}

		public function form(Request $request, $id = null, $paciente = null)
		{

			$dados['row'] = $this->atendimento_model->getAtendimentoById($request->id);

			return response(view('clinica.atendimentos.form', $dados), 200);

		}

		public function get_eventos(Request $request, $tipo = null)
		{

			if (!$request->ajax) {
				return response(view('clinica.atendimentos.index'), 200);
			}

			$eventos = [];

			$dados = $this->atendimento_model->getEventos($request);

			if ($dados) {
				foreach ($dados as $row) {
					$eventos[] = [
						'title' => $row->paciente,
						'start' => $row->data . 'T' . $row->hora_agendada,
						'end'   => $row->data . 'T' . $row->hora_agendada,
						// 'backgroundColor' => '#ff0000',
						// 'color'           => '#00ff00',
					];
				}
			}

			return response()->json($eventos);

		}

		public function getDepartamentos(Request $request)
		{

			$dados['select'] = $this->atendimento_model->getDepartamentos($request->clinica);
			return view('clinica.atendimentos.select_departamentos', $dados);

		}

		public function validateForm(Request $request)
		{

			return $request->validate([
				'nome_fantasia'      => 'required',
				'razao_social'       => 'required',
				'cnpj'               => [
					'required',
					'regex:/[\d]{2}\.[\d]{3}\.[\d]{3}\/[\d]{4}\-[\d]{2}/i',
					Rule::unique('tb_atendimento', 'cnpj')->ignore($request->post('id'), 'id'),
				],
				'inscricao_estadual' => [
					'nullable',
					Rule::unique('tb_atendimento', 'inscricao_estadual')->ignore($request->post('id'), 'id'),
				],
				'email'              => [
					'nullable',
					'email',
					'required_if:receber_notificacoes,on',
				],
				'cep'                => [
					'required',
					'regex:/[\d]{5}\-[\d]{3}/i',
				],
				'logradouro'         => 'required',
				'bairro'             => 'required',
				'cidade'             => 'required',
				'uf'                 => [
					'required',
					'min:2',
					'max:2',
				],
			]);

		}

		public function create(Request $request)
		{

			// $this->validateForm($request);
			$id = $this->atendimento_model->cadastraAtendimento($request);

			$status  = 'success';
			$message = 'Atendimento cadastrada realizado com sucesso!';
			$close   = true;

			$data['status']      = $status;
			$data['type']        = 'null';
			$data['close_modal'] = $close;
			$data['url']         = url()->route('clinica.atendimentos.index');
			$data['message']     = $message;

			return response()->json($data);

		}

		public function edit(Request $request)
		{

			$this->validateForm($request);

			$id = $request->id;

			if ($this->atendimento_model->editaAtendimento($request, $id)) {
				$status  = 'success';
				$message = 'Cadastro alterado com sucesso!';
			} else {
				$status = 'error';
				// $message = 'Não foi possível atualizar os dados.';
				$message = $this->atendimento_model->getErros();
			}

			$data['status']      = $status;
			$data['type']        = 'null';
			$data['clean_form']  = false;
			$data['close_modal'] = false;
			$data['url']         = url()->route('clinica.clinicas.index');
			$data['message']     = $message;

			return response()->json($data);

		}

		public function patch(Request $request)
		{

			$status  = 'error';
			$message = 'Não foi possível atualizar a atendimento.';

			if ($this->atendimento_model->atualizaAtendimento($request->id, [$request->field => $request->value])) {

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

			if ($this->atendimento_model->removeAtendimento($request->id)) {
				$status  = 'success';
				$message = 'Clínia removida com sucesso!';
			} else {
				$status  = 'error';
				$message = $this->atendimento_model->getErros();
			}

			$data['status']      = $status;
			$data['message']     = $message;
			$data['type']        = 'refresh';
			$data['clean_form']  = true;
			$data['close_modal'] = true;
			$data['url']         = url()->route('clinica.clinicas.index');

			return response()->json($data);

		}

	}

}
