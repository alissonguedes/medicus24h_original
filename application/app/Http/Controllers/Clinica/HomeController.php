<?php

namespace App\Http\Controllers\Clinica{

	use App\Models\PacienteModel;

	class HomeController extends Controller
	{

		public function __construct()
		{

			$this->paciente = new PacienteModel();

		}

		public function index()
		{

			$dados['total']['pacientes']['ativos'] = $this->paciente->getPacientes()
				->where('status', '1')
				->where('obito', '0')
				->count();

			$dados['total']['pacientes']['inativos'] = $this->paciente->getPacientes()
				->where('status', '0')
				->where('obito', '0')
				->count();

			$dados['total']['pacientes']['vivos'] = $this->paciente->getPacientes()
				->where('obito', '0')
				->count();

			$dados['total']['pacientes']['falecidos'] = $this->paciente->getPacientes()
				->where('obito', '1')
				->count();

			return view('clinica.dashboard', $dados);

		}

	}

}
