<?php

namespace App\Http\Controllers\Clinica{

	use App\Models\ConvenioModel;
	use App\Models\EstadoCivilModel;
	use App\Models\PacienteModel;
	use App\Models\ProntuarioModel;
	use Illuminate\Http\Request;

	class ProntuariosController extends Controller
	{

		public function __construct()
		{

			$this->convenio_model    = new ConvenioModel();
			$this->prontuario_model  = new ProntuarioModel();
			$this->paciente_model    = new PacienteModel();
			$this->estadoCivil_model = new EstadoCivilModel();

		}

		public function index(Request $request, $id_paciente)
		{

			$dados['paciente'] = $this->paciente_model->getPacienteById($id_paciente);

			return view('clinica.prontuarios.index', $dados);

		}

		public function paciente(Request $request)
		{

			return view('clinica.prontuarios.index');

		}

		public function form(Request $request, $id = null)
		{

			$dados['row']          = $this->prontuario_model->getProntuarioById($id);
			$dados['convenios']    = $this->convenio_model->getConvenio();
			$dados['estado_civil'] = $this->estadoCivil_model->getEstadoCivil();
			return view('clinica.prontuarios.form', $dados);

		}

		public function create(Request $request)
		{

			$id = $this->prontuario_model->cadastraProntuario($request);

			$status = 'success';
			$url    = url()->route('clinica.prontuarios.index');
			$type   = 'send';

			return response()->json([
				'status'  => $status,
				'message' => 'Prontuario cadastrado realizado com sucesso!',
				'type'    => $type,
				'url'     => $url,
			]);
		}

		public function edit(Request $request)
		{

			$id = $request->id;
			$this->prontuario_model->editaProntuario($request, $id);

			return response()->json(['message' => 'Dados atualizados com sucesso!']);

		}

		public function patch(Request $request)
		{

			$this->prontuario_model->from('tb_prontuario')
				->whereIn('id', $request->id)
				->update([$request->field => $request->value]);

			return response()->json([
				'message' => 'Prontuario atualizado com sucesso!',
			]);

		}

		public function delete(Request $request)
		{

			$this->prontuario_model->from('tb_prontuario')->whereIn('id', $request->id)->delete();

			$status  = 'success';
			$message = 'Prontuario removido com sucesso!';
			$url     = url()->route('clinica.prontuarios.index');
			$type    = 'send';

			return json_encode(['status' => $status, 'message' => $message, 'type' => $type, 'url' => $url], 200);

		}

	}

}
