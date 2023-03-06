<?php
Route::prefix("/")->group(function () {

	Route::any("/", ["App\Http\Controllers\Main\HomeController", "index"])->name("main.home"); // http://localhost/transvida/public
	Route::get("/home", ["App\Http\Controllers\Main\HomeController", "index"])->name("main.home"); // http://localhost/transvida/public/home
	Route::any("/contact", ["App\Http\Controllers\Main\HomeController", "contato"])->name("main.contact"); // http://localhost/transvida/public/contact
	Route::post("/contact", ["App\Http\Controllers\Main\HomeController", "send_mail"])->name("main.contact"); // http://localhost/transvida/public/contact
	Route::prefix("/embaixada")->group(function ($router) use ($route) {
		Route::any("/", ["App\Http\Controllers\Main\GaleriaController", "index"])->name("main.page.embaixada"); // http://localhost/transvida/public
		Route::get("/{page?}", ["App\Http\Controllers\Main\GaleriaController", "show"])->name("main.page.embaixada.show_page"); // http://localhost/transvida/public/{page?}
	});
	Route::any("/galeria", ["App\Http\Controllers\Main\GaleriaController", "index"])->name("main.galeria"); // http://localhost/transvida/public/galeria
	Route::get("/api/token", ["App\Http\Controllers\Main\ApiController", "token"])->name("main.api.token"); // http://localhost/transvida/public/api/token
	Route::get("/api/translate/{lang}", ["App\Http\Controllers\Main\ApiController", "translate"])->name("main.api.translate"); // http://localhost/transvida/public/api/translate/{lang}
	Route::get("/api/cep/{cep}", ["App\Http\Controllers\Main\ApiController", "getCep"])->name("main.api.cep"); // http://localhost/transvida/public/api/cep/{cep}
	Route::get("/api/js", ["App\Http\Controllers\Main\ApiController", "include_js_app"])->name("main.api.include_js"); // http://localhost/transvida/public/api/js
	Route::get("/about-us", ["App\Http\Controllers\Main\AboutController", "index"])->name("main.about"); // http://localhost/transvida/public/about-us
	Route::any("/health", ["App\Http\Controllers\Main\AboutController", "health"])->name("main.health"); // http://localhost/transvida/public/health
	Route::prefix("/services")->group(function ($router) use ($route) {
		Route::any("/", ["App\Http\Controllers\Main\ServicesController", "index"])->name("main.services.index"); // http://localhost/transvida/public
		Route::any("/medicals", ["App\Http\Controllers\Main\ServicesController", "medicos"])->name("main.services.medicos"); // http://localhost/transvida/public/medicals
		Route::any("/commercial", ["App\Http\Controllers\Main\ServicesController", "comercial"])->name("main.services.comercial"); // http://localhost/transvida/public/commercial
		Route::any("/removal", ["App\Http\Controllers\Main\ServicesController", "remocao"])->name("main.services.remocao"); // http://localhost/transvida/public/removal
		Route::any("/protected-area", ["App\Http\Controllers\Main\ServicesController", "area_protegida"])->name("main.services.area_protegida"); // http://localhost/transvida/public/protected-area
	});

});

Route::prefix("/admin")->group(function () {

	Route::any("/", ["App\Http\Controllers\Admin\HomeController", "index"])->name("admin.index"); // http://localhost/transvida/public
	Route::any("/login", ["App\Http\Controllers\Admin\HomeController", "index"])->name("admin.login"); // http://localhost/transvida/public/login
	Route::any("/dashboard", ["App\Http\Controllers\Admin\HomeController", "index"])->name("admin.dashboard"); // http://localhost/transvida/public/dashboard
	Route::any("/database", ["App\Http\Controllers\Admin\HomeController", "index"])->name("admin.database"); // http://localhost/transvida/public/database
	Route::prefix("/menus")->group(function ($router) use ($route) {
		Route::any("/", ["App\Http\Controllers\Admin\MenusController", "index"])->name("admin.menus"); // http://localhost/transvida/public
		Route::get("/add", ["App\Http\Controllers\Admin\MenusController", "show_form"])->name("admin.menus.add"); // http://localhost/transvida/public/add
		Route::patch("/{id}", ["App\Http\Controllers\Admin\MenusController", "patch"])->name("admin.menus.patch"); // http://localhost/transvida/public/{id}
		Route::delete("/", ["App\Http\Controllers\Admin\MenusController", "delete"])->name("admin.menus.delete"); // http://localhost/transvida/public
		Route::get("/{id}", ["App\Http\Controllers\Admin\MenusController", "show_form"])->name("admin.menus.edit"); // http://localhost/transvida/public/{id}
		Route::put("/", ["App\Http\Controllers\Admin\MenusController", "edit"])->name("admin.menus.put"); // http://localhost/transvida/public
		Route::post("/", ["App\Http\Controllers\Admin\MenusController", "create"])->name("admin.menus.post"); // http://localhost/transvida/public
	});
	Route::get("/api/token", ["App\Http\Controllers\Admin\ApiController", "token"])->name("admin.api.token"); // http://localhost/transvida/public/api/token
	Route::get("/api/translate/{lang}", ["App\Http\Controllers\Admin\ApiController", "translate"])->name("admin.api.translate"); // http://localhost/transvida/public/api/translate/{lang}
	Route::patch("/config", ["App\Http\Controllers\Admin\ConfigController", "patch"])->name("admin.config.patch"); // http://localhost/transvida/public/config
	Route::any("/users", ["App\Http\Controllers\Admin\UserController", "index"])->name("admin.users"); // http://localhost/transvida/public/users

});

Route::prefix("/auth")->group(function () {

	Route::any("/login", ["App\Http\Controllers\AuthController", "index"])->name("account.auth.login"); // http://localhost/transvida/public/login
	Route::post("/login", ["App\Http\Controllers\AuthController", "login_validate"])->name("account.auth.login"); // http://localhost/transvida/public/login
	Route::any("/logout", ["App\Http\Controllers\AuthController", "logout"])->name("logout"); // http://localhost/transvida/public/logout

});

Route::prefix("/clinica")->group(function () {

	Route::any("/", ["App\Http\Controllers\Clinica\HomeController", "index"])->name("clinica.index"); // http://localhost/transvida/public
	Route::get("/api/token", ["App\Http\Controllers\Clinica\ApiController", "token"])->name("clinica.api.token"); // http://localhost/transvida/public/api/token
	Route::get("/api/js", ["App\Http\Controllers\Clinica\ApiController", "include_js_app"])->name("clinica.api.include_js"); // http://localhost/transvida/public/api/js
	Route::patch("/config", ["App\Http\Controllers\Clinica\ConfigController", "patch"])->name("clinica.config.patch"); // http://localhost/transvida/public/config
	Route::prefix("/pacientes")->group(function ($router) use ($route) {
		Route::any("/", ["App\Http\Controllers\Clinica\PacientesController", "index"])->name("clinica.pacientes.index"); // http://localhost/transvida/public
		Route::post("/", ["App\Http\Controllers\Clinica\PacientesController", "create"])->name("clinica.pacientes.post"); // http://localhost/transvida/public
		Route::get("/id/{id}", ["App\Http\Controllers\Clinica\PacientesController", "form"])->name("clinica.pacientes.edit"); // http://localhost/transvida/public/id/{id}
		Route::any("/cadastro", ["App\Http\Controllers\Clinica\PacientesController", "form"])->name("clinica.pacientes.add"); // http://localhost/transvida/public/cadastro
		Route::patch("/id/{id}", ["App\Http\Controllers\Clinica\PacientesController", "patch"])->name("clinica.pacientes.patch"); // http://localhost/transvida/public/id/{id}
		Route::delete("/", ["App\Http\Controllers\Clinica\PacientesController", "delete"])->name("clinica.pacientes.delete"); // http://localhost/transvida/public
		Route::put("/", ["App\Http\Controllers\Clinica\PacientesController", "edit"])->name("clinica.pacientes.put"); // http://localhost/transvida/public
		Route::any("/{id}/agendamento", ["App\Http\Controllers\Clinica\PacientesController", "agendar"])->name("clinica.pacientes.{id_paciente}.agendamento"); // http://localhost/transvida/public/{id}/agendamento
		Route::get("/json/autocomplete", ["App\Http\Controllers\Clinica\PacientesController", "autocomplete"])->name("clinica.pacientes.autocomplete"); // http://localhost/transvida/public/json/autocomplete
		Route::prefix("/{id_paciente}/prontuarios")->group(function ($router) use ($route) {
			Route::any("/", ["App\Http\Controllers\Clinica\ProntuariosController", "index"])->name("clinica.pacientes.{id_paciente}.prontuarios"); // http://localhost/transvida/public
			Route::post("/", ["App\Http\Controllers\Clinica\ProntuariosController", "create"])->name("clinica.pacientes.{id_paciente}.prontuarios.post"); // http://localhost/transvida/public
			Route::get("/{id_prontuario}", ["App\Http\Controllers\Clinica\ProntuariosController", "form"])->name("clinica.pacientes.{id_paciente}.prontuarios.{id_prontuario}"); // http://localhost/transvida/public/{id_prontuario}
			Route::any("/pacientes/cadastro", ["App\Http\Controllers\Clinica\ProntuariosController", "form"])->name("clinica.pacientes.{id_paciente}.prontuarios.add"); // http://localhost/transvida/public/pacientes/cadastro
			Route::patch("/", ["App\Http\Controllers\Clinica\ProntuariosController", "patch"])->name("clinica.pacientes.{id_paciente}.prontuarios.patch"); // http://localhost/transvida/public
			Route::delete("/", ["App\Http\Controllers\Clinica\ProntuariosController", "delete"])->name("clinica.pacientes.{id_paciente}.prontuarios.delete"); // http://localhost/transvida/public
			Route::put("/", ["App\Http\Controllers\Clinica\ProntuariosController", "edit"])->name("clinica.pacientes.{id_paciente}.prontuarios.put"); // http://localhost/transvida/public
			Route::any("/prontuarios", ["App\Http\Controllers\Clinica\ProntuariosController", "paciente"])->name("clinica.pacientes.{id_paciente}.prontuarios"); // http://localhost/transvida/public/prontuarios
		});
		Route::get("/{id}/dados", ["App\Http\Controllers\Clinica\UsuariosController", "get"])->name("clinica.pacientes.get"); // http://localhost/transvida/public/{id}/dados
	});
	Route::prefix("/medicos")->group(function ($router) use ($route) {
		Route::any("/", ["App\Http\Controllers\Clinica\MedicosController", "index"])->name("clinica.medicos.index"); // http://localhost/transvida/public
		Route::any("/cadastro", ["App\Http\Controllers\Clinica\MedicosController", "form"])->name("clinica.medicos.add"); // http://localhost/transvida/public/cadastro
		Route::post("/", ["App\Http\Controllers\Clinica\MedicosController", "create"])->name("clinica.medicos.post"); // http://localhost/transvida/public
		Route::get("/{id}", ["App\Http\Controllers\Clinica\MedicosController", "form"])->name("clinica.medicos.edit"); // http://localhost/transvida/public/{id}
		Route::patch("/{id}", ["App\Http\Controllers\Clinica\MedicosController", "patch"])->name("clinica.medicos.patch"); // http://localhost/transvida/public/{id}
		Route::delete("/", ["App\Http\Controllers\Clinica\MedicosController", "delete"])->name("clinica.medicos.delete"); // http://localhost/transvida/public
		Route::put("/", ["App\Http\Controllers\Clinica\MedicosController", "edit"])->name("clinica.medicos.put"); // http://localhost/transvida/public
		Route::get("/json/autocomplete", ["App\Http\Controllers\Clinica\MedicosController", "autocomplete"])->name("clinica.medicos.autocomplete"); // http://localhost/transvida/public/json/autocomplete
	});
	Route::prefix("/especialidades")->group(function ($router) use ($route) {
		Route::any("/", ["App\Http\Controllers\Clinica\EspecialidadesController", "index"])->name("clinica.especialidades.index"); // http://localhost/transvida/public
		Route::get("/cadastro", ["App\Http\Controllers\Clinica\EspecialidadesController", "form"])->name("clinica.especialidades.add"); // http://localhost/transvida/public/cadastro
		Route::post("/", ["App\Http\Controllers\Clinica\EspecialidadesController", "create"])->name("clinica.especialidades.post"); // http://localhost/transvida/public
		Route::get("/{id}", ["App\Http\Controllers\Clinica\EspecialidadesController", "form"])->name("clinica.especialidades.edit"); // http://localhost/transvida/public/{id}
		Route::patch("/{id}", ["App\Http\Controllers\Clinica\EspecialidadesController", "patch"])->name("clinica.especialidades.patch"); // http://localhost/transvida/public/{id}
		Route::delete("/", ["App\Http\Controllers\Clinica\EspecialidadesController", "delete"])->name("clinica.especialidades.delete"); // http://localhost/transvida/public
		Route::put("/", ["App\Http\Controllers\Clinica\EspecialidadesController", "edit"])->name("clinica.especialidades.put"); // http://localhost/transvida/public
		Route::get("/json/autocomplete", ["App\Http\Controllers\Clinica\EspecialidadesController", "autocomplete"])->name("clinica.especialidades.autocomplete"); // http://localhost/transvida/public/json/autocomplete
	});
	Route::prefix("/unidades")->group(function ($router) use ($route) {
		Route::any("/", ["App\Http\Controllers\Clinica\EmpresasController", "index"])->name("clinica.clinicas.index"); // http://localhost/transvida/public
		Route::post("/", ["App\Http\Controllers\Clinica\EmpresasController", "create"])->name("clinica.clinicas.post"); // http://localhost/transvida/public
		Route::get("/id/{id}", ["App\Http\Controllers\Clinica\EmpresasController", "form"])->name("clinica.clinicas.edit"); // http://localhost/transvida/public/id/{id}
		Route::any("/cadastro", ["App\Http\Controllers\Clinica\EmpresasController", "form"])->name("clinica.clinicas.add"); // http://localhost/transvida/public/cadastro
		Route::patch("/{id}", ["App\Http\Controllers\Clinica\EmpresasController", "patch"])->name("clinica.clinicas.patch"); // http://localhost/transvida/public/{id}
		Route::delete("/", ["App\Http\Controllers\Clinica\EmpresasController", "delete"])->name("clinica.clinicas.delete"); // http://localhost/transvida/public
		Route::put("/", ["App\Http\Controllers\Clinica\EmpresasController", "edit"])->name("clinica.clinicas.put"); // http://localhost/transvida/public
		Route::get("/departamentos", ["App\Http\Controllers\Clinica\EmpresasController", "getDepartamentos"])->name("clinica.clinicas.departamentos"); // http://localhost/transvida/public/departamentos
		Route::get("/json/autocomplete", ["App\Http\Controllers\Clinica\EmpresasController", "autocomplete"])->name("clinica.clinicas.autocomplete"); // http://localhost/transvida/public/json/autocomplete
	});
	Route::prefix("/departamentos")->group(function ($router) use ($route) {
		Route::any("/", ["App\Http\Controllers\Clinica\DepartamentosController", "index"])->name("clinica.departamentos.index"); // http://localhost/transvida/public
		Route::get("/cadastro", ["App\Http\Controllers\Clinica\DepartamentosController", "form"])->name("clinica.departamentos.add"); // http://localhost/transvida/public/cadastro
		Route::post("/", ["App\Http\Controllers\Clinica\DepartamentosController", "create"])->name("clinica.departamentos.post"); // http://localhost/transvida/public
		Route::get("/{id}", ["App\Http\Controllers\Clinica\DepartamentosController", "form"])->name("clinica.departamentos.edit"); // http://localhost/transvida/public/{id}
		Route::patch("/{id}", ["App\Http\Controllers\Clinica\DepartamentosController", "patch"])->name("clinica.departamentos.patch"); // http://localhost/transvida/public/{id}
		Route::delete("/", ["App\Http\Controllers\Clinica\DepartamentosController", "delete"])->name("clinica.departamentos.delete"); // http://localhost/transvida/public
		Route::put("/", ["App\Http\Controllers\Clinica\DepartamentosController", "edit"])->name("clinica.departamentos.put"); // http://localhost/transvida/public
	});
	Route::prefix("/funcionarios")->group(function ($router) use ($route) {
		Route::any("/", ["App\Http\Controllers\Clinica\FuncionariosController", "index"])->name("clinica.funcionarios.index"); // http://localhost/transvida/public
		Route::any("/cadastro", ["App\Http\Controllers\Clinica\FuncionariosController", "form"])->name("clinica.funcionarios.add"); // http://localhost/transvida/public/cadastro
		Route::post("/", ["App\Http\Controllers\Clinica\FuncionariosController", "create"])->name("clinica.funcionarios.post"); // http://localhost/transvida/public
		Route::get("/{id}", ["App\Http\Controllers\Clinica\FuncionariosController", "form"])->name("clinica.funcionarios.edit"); // http://localhost/transvida/public/{id}
		Route::patch("/{id}", ["App\Http\Controllers\Clinica\FuncionariosController", "patch"])->name("clinica.funcionarios.patch"); // http://localhost/transvida/public/{id}
		Route::delete("/", ["App\Http\Controllers\Clinica\FuncionariosController", "delete"])->name("clinica.funcionarios.delete"); // http://localhost/transvida/public
		Route::put("/", ["App\Http\Controllers\Clinica\FuncionariosController", "edit"])->name("clinica.funcionarios.put"); // http://localhost/transvida/public
	});
	Route::prefix("/agendamentos")->group(function ($router) use ($route) {
		Route::any("/", ["App\Http\Controllers\Clinica\AgendamentosController", "index"])->name("clinica.agendamentos.index"); // http://localhost/transvida/public
		Route::get("/new", ["App\Http\Controllers\Clinica\AgendamentosController", "form"])->name("clinica.agendamentos.add"); // http://localhost/transvida/public/new
		Route::post("/", ["App\Http\Controllers\Clinica\AgendamentosController", "create"])->name("clinica.agendamentos.post"); // http://localhost/transvida/public
		Route::get("/id/{id}", ["App\Http\Controllers\Clinica\AgendamentosController", "form"])->name("clinica.agendamentos.edit"); // http://localhost/transvida/public/id/{id}
		Route::patch("/{id}", ["App\Http\Controllers\Clinica\AgendamentosController", "patch"])->name("clinica.agendamentos.patch"); // http://localhost/transvida/public/{id}
		Route::delete("/", ["App\Http\Controllers\Clinica\AgendamentosController", "delete"])->name("clinica.agendamentos.delete"); // http://localhost/transvida/public
		Route::put("/", ["App\Http\Controllers\Clinica\AgendamentosController", "edit"])->name("clinica.agendamentos.put"); // http://localhost/transvida/public
		Route::get("/consultas", ["App\Http\Controllers\Clinica\AgendamentosController", "get_eventos"])->name("clinica.agendamentos.consultas"); // http://localhost/transvida/public/consultas
		Route::get("/eventos", ["App\Http\Controllers\Clinica\AgendamentosController", "get_eventos"])->name("clinica.agendamentos.get_eventos"); // http://localhost/transvida/public/eventos
	});
	Route::get("/atendimentos/{tipos}/json/autocomplete", ["App\Http\Controllers\Clinica\AtendimentosController", "autocomplete"])->name("clinica.atendimentos.autocomplete"); // http://localhost/transvida/public/atendimentos/{tipos}/json/autocomplete
	Route::get("/atendimentos/{tipo}/json/autocomplete", ["App\Http\Controllers\Clinica\AtendimentosController", "autocomplete"])->name("clinica.atendimentos.autocomplete"); // http://localhost/transvida/public/atendimentos/{tipo}/json/autocomplete
	Route::prefix("/grupos")->group(function ($router) use ($route) {
		Route::put("/", ["App\Http\Controllers\Clinica\GruposController", "edit"])->name("clinica.grupos.usuarios.put"); // http://localhost/transvida/public
		Route::post("/", ["App\Http\Controllers\Clinica\GruposController", "create"])->name("clinica.grupos.usuarios.post"); // http://localhost/transvida/public
		Route::patch("/{id}", ["App\Http\Controllers\Clinica\GruposController", "patch"])->name("clinica.grupos.usuarios.patch"); // http://localhost/transvida/public/{id}
		Route::any("/", ["App\Http\Controllers\Clinica\GruposController", "index"])->name("clinica.grupos.usuarios.index"); // http://localhost/transvida/public
		Route::get("/{id}/dados", ["App\Http\Controllers\Clinica\GruposController", "get"])->name("clinica.grupos.usuarios.get"); // http://localhost/transvida/public/{id}/dados
		Route::get("/id/{id}", ["App\Http\Controllers\Clinica\GruposController", "form"])->name("clinica.grupos.usuarios.edit"); // http://localhost/transvida/public/id/{id}
		Route::delete("/", ["App\Http\Controllers\Clinica\GruposController", "delete"])->name("clinica.grupos.usuarios.delete"); // http://localhost/transvida/public
		Route::get("/json/autocomplete", ["App\Http\Controllers\Clinica\GruposController", "autocomplete"])->name("clinica.grupos.usuarios.autocomplete"); // http://localhost/transvida/public/json/autocomplete
		Route::any("/cadastro", ["App\Http\Controllers\Clinica\GruposController", "form"])->name("clinica.grupos.usuarios.add"); // http://localhost/transvida/public/cadastro
	});
	Route::prefix("/usuarios")->group(function ($router) use ($route) {
		Route::any("/cadastro", ["App\Http\Controllers\Clinica\UsuariosController", "form"])->name("clinica.usuarios.add"); // http://localhost/transvida/public/cadastro
		Route::get("/json/autocomplete", ["App\Http\Controllers\Clinica\UsuariosController", "autocomplete"])->name("clinica.usuarios.autocomplete"); // http://localhost/transvida/public/json/autocomplete
		Route::delete("/", ["App\Http\Controllers\Clinica\UsuariosController", "delete"])->name("clinica.usuarios.delete"); // http://localhost/transvida/public
		Route::get("/id/{id}", ["App\Http\Controllers\Clinica\UsuariosController", "form"])->name("clinica.usuarios.edit"); // http://localhost/transvida/public/id/{id}
		Route::get("/{id}/dados", ["App\Http\Controllers\Clinica\UsuariosController", "get"])->name("clinica.usuarios.get"); // http://localhost/transvida/public/{id}/dados
		Route::any("/", ["App\Http\Controllers\Clinica\UsuariosController", "index"])->name("clinica.usuarios.index"); // http://localhost/transvida/public
		Route::patch("/{id}", ["App\Http\Controllers\Clinica\UsuariosController", "patch"])->name("clinica.usuarios.patch"); // http://localhost/transvida/public/{id}
		Route::post("/", ["App\Http\Controllers\Clinica\UsuariosController", "create"])->name("clinica.usuarios.post"); // http://localhost/transvida/public
		Route::put("/", ["App\Http\Controllers\Clinica\UsuariosController", "edit"])->name("clinica.usuarios.put"); // http://localhost/transvida/public
	});

});

Route::prefix("/teste")->group(function () {

	Route::any("/", ["App\Http\Controllers\Teste\HomeController", "index"])->name("teste.index"); // http://localhost/transvida/public

});
