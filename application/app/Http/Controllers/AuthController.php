<?php

namespace App\Http\Controllers{

	// use App\Models\BannerModel;
	// use App\Models\LinkModel;
	// use App\Models\NewsModel;
	// use App\Models\PageModel;

	use App\Models\UserModel;
	use Illuminate\Http\Request;
	use Illuminate\Routing\Redirector;
	use Illuminate\Support\Facades\Session;

	class AuthController extends Controller
	{

		public function __construct(Request $request, Redirector $redirector)
		{

			$this->redirector = $redirector;

			$this->middleware(function ($request, $next) {

				if (Session::exists('userdata') && basename($request->url()) != 'logout') {

					if ($request->header('Request-Type') && $request->header('Request-Type') === 'xmlhttprequest') {
						return abort(401);
					} else {
						return redirect(Session::get('userdata')[Session::get('app_session')]['modulo']);
					}

				} else {

					// if (!$request->ajax() && !Session::exists('url') || !Session::exists('curl')) {
					// 	return redirect()->route('main.home');
					// }

				}

				return $next($request);

			});

			$this->user_model = new UserModel();

		}

		public function index(Request $request)
		{

			return view('authentication.login');

		}

		public function login_validate(Request $request)
		{

			if (isset($_POST['login'])) {

				$request->validate([
					'login' => 'required',
				]);

			}

			if (isset($_POST['senha'])) {

				$request->validate([
					'senha' => 'required',
				]);

			}

			return $this->user_model->auth($request);

		}

		public function new_account(Request $request)
		{

			echo 'new account';

		}

		public function reset(Request $request)
		{

			echo 'recuperar';

		}

		public function logout(Request $request)
		{

			if (Session::has('userdata')) {

				$this->user_model->from('tb_acl_usuario_session')
					->where('token', Session::get('app_session'))
					->update(['expired_at' => date('Y-m-d H:i:s'), 'token' => null]);

				Session::forget(['userdata', 'senha', 'id', 'id_grupo', 'permissao', 'app_session']);

			}

			$current_url = url()->previous();
			Session::put('curl', $current_url);

			return redirect()->route('account.auth.login')->with('url', $current_url);

		}

	}

}
