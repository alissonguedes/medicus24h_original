<?php

namespace App\Http\Controllers\Main{

	class ServicesController extends Controller
	{

		public function index()
		{

			return view('main.services.index');

		}

		public function remocao()
		{

			return view('main.services.remocao');

		}

		public function medicos()
		{

			return view('main.services.medicos');

		}

		public function comercial()
		{

			return view('main.services.comercial');

		}

		public function area_protegida()
		{

			return view('main.services.area_protegida');

		}

	}

}
