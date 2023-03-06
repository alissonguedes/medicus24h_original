<?php

namespace App\Http\Controllers\Main{

	use App\Mail\ContactMail;
	use App\Models\ContatoModel;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Mail;

	class HomeController extends Controller
	{

		public function index()
		{

			return view('main.home.index');

		}

		public function contato()
		{

			return view('main.home.contato');
			// return view('main.mails.contact_mail');

		}

		public function validateForm(Request $request)
		{

			return $request->validate([
				'nome'     => 'required',
				'email'    => 'required',
				'telefone' => [
					'required',
					'regex:/\([\d]{2}\)\s([\d]{1}\s)?[\d]{4}\.[\d]{4}/i',
				],
				'assunto'  => 'required',
				'mensagem' => 'required',
			]);

		}

		public function send_mail(Request $request)
		{

			$this->validateForm($request);

			$this->contato_model = new ContatoModel();
			Mail::to('atendimento@medicus24h.com.br')->send(new ContactMail($request));

			return response()->json([
				'status'     => 'success',
				'type'       => 'send',
				'url'        => route('main.contact'),
				'message'    => 'Contato enviado com sucesso',
				'clean_form' => true,
				'reset_form' => true,
			]);

		}

	}

}
