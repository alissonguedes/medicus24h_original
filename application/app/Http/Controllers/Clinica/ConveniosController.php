<?php

namespace App\Http\Controllers\Clinica{

	use App\Models\ConvenioModel;
	use App\Models\EstadoCivilModel;
	use App\Models\PlanoModel;
	use Faker\Factory as Faker;
	use Illuminate\Http\Request;
	use Illuminate\Validation\Rule;

	class ConveniosController extends Controller
	{

		public function __construct()
		{

			$this->convenio_model    = new ConvenioModel();
			$this->plano_model       = new PlanoModel();
			$this->estadoCivil_model = new EstadoCivilModel();
			$this->faker             = new Faker();

		}

		public function index(Request $request)
		{

			// Pesquisar planosdesaude
			if ($request->ajax()) {
				$dados['planosdesaude'] = $this->plano_model->getPlanos($request);
				return response(view('clinica.planosdesaude.results', $dados), 200);
			}
			$dados['faker']         = $this->faker::create('pt_BR');
			$dados['planosdesaude'] = $this->plano_model->getPlanos($request);
			return response(view('clinica.planosdesaude.index', $dados), 200);

		}

		public function form(Request $request, $id = null)
		{

			$dados['row']          = $this->plano_model->getPlanoById($request->id);
			$dados['acomodacoes']  = $this->plano_model->getAcomodacao();
			$dados['etnias']       = $this->plano_model->getEtnia();
			$dados['convenios']    = $this->convenio_model->getConvenio();
			$dados['estado_civil'] = $this->estadoCivil_model->getEstadoCivil();
			return view('clinica.planosdesaude.form', $dados);

		}

		public function get(Request $request, $id)
		{

			$result = $this->plano_model->getPlanoById($id);

			$plano['mae']             = $result->mae;
			$plano['pai']             = $result->pai;
			$plano['data_nascimento'] = $result->data_nascimento;
			$plano['cpf']             = $result->cpf;
			$plano['telefone']        = $result->telefone;
			$plano['convenio']        = $result->convenio;
			$plano['matricula']       = $result->matricula_convenio;
			$plano['validade']        = $result->validade_convenio;
			$plano['observacao']      = $result->notas;
			$plano['enviar_email']    = $result->enviar_email;

			return $plano;

		}

		public function autocomplete(Request $request)
		{

			$clinicas = [];

			$dados = $this->convenio_model->getTipoConvenio(null, $request->id_plano);

			foreach ($dados as $clinica) {
				$clinicas['items'][] = [
					'id'   => $clinica->id,
					'text' => $clinica->descricao,
				];
			}

			return response($clinicas, 200);

		}

		public function agendar(Request $request, $id = null)
		{

			if ($this->plano_model->isBlocked($request->id)) {

				$status  = 'warn';
				$title   = 'Plano inativo!';
				$message = 'Não é possível realizar o agendamento.';

				return response()->json(['status' => $status, 'title' => $title, 'message' => $message]);

			}

			$dados['row']          = null;
			$dados['plano']        = $this->plano_model->getPlanoById($request->id);
			$dados['acomodacoes']  = $this->plano_model->getAcomodacao();
			$dados['etnias']       = $this->plano_model->getEtnia();
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

			$id = $this->plano_model->cadastraPlano($request);

			$status = 'success';
			$url    = url()->route('clinica.planosdesaude.edit', $id);
			$type   = 'redirect';

			return response()->json([
				'status'      => $status,
				'message'     => 'Plano cadastrado com sucesso!',
				'clean_form'  => true,
				'close_modal' => false,
				'type'        => $type,
				'url'         => $url,
			]);
		}

		public function edit(Request $request)
		{

			$request->validate([
				'nome'       => 'required',
				'email'      => 'nullable|email|required_if:receber_notificacoes,on',
				'data_obito' => 'required_if:obito,1',
				'hora_obito' => Rule::requiredIf($request->obito == 1 || $request->data_obito),
			]);

			$id = $request->id;
			$this->plano_model->editaPlano($request, $id);

			$status = 'success';
			$url    = url()->route('clinica.planosdesaude.index');
			$type   = 'redirect';

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

			$this->plano_model->from('tb_plano')
				->whereIn('id', $request->id)
				->update([$request->field => $request->value]);

			return response()->json([
				'message' => 'Plano atualizado com sucesso!',
			]);

		}

		public function delete(Request $request)
		{

			$this->plano_model->from('tb_plano')->whereIn('id', $request->id)->delete();

			$status  = 'success';
			$message = 'Plano removido com sucesso!';
			$url     = url()->route('clinica.planosdesaude.index');
			$type    = 'send';

			return json_encode(['status' => $status, 'message' => $message, 'type' => $type, 'url' => $url], 200);

		}

	}

}
