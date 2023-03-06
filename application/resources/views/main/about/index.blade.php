@extends('main.body')

@section('page-title', 'Sobre nós')

@section('capa')
<div class="nav-background z-depth-1">
	<div class="capa animated fadeIn teal lighten-4" style="background-image: url('{{ asset('img/site/banner/' . rand(1, 2). '.png') }}');"></div>
	<div class="nav-header">
		<h1>@yield('page-title')</h1>
	</div>
</div>
@endsection

@section('main')

<div class="row">
	<div class="col s12">
		<div class="container mt-8 pt-6 pb-6">
			<p>
				A <a href="#" class="bold red-text darken-2">Médicus24h</a> possui uma frota completa
				de ambulâncias próprias equipeadas com UTI Móvel com assitência 24 horas.
			</p>
			<p>
				<a href="#" class="bold red-text darken-2">Médicus24h</a> é o programa de assistência domiciliar
				indicado para dar continuidade ao tratamento do paciente, iniciado no Hospital, diminuindo o tempo de permanência
				em ambiente hospitalar e, com isso, reduzindo os riscos de complicações causadas por uma internação prolongada,
				podendo o paciente concluir sua recuperação em seu domicílio.
			</p>

			<p>
				Contando com o atendimento de uma equipe multidisciplinar (Médicos, Enfermeiros, Fisioterapeutas, Fonoaudiólogos,
				Nutricionistas, entre outros), a <a href="#" class="bold red-text darken-2">Médicus24h</a> coloca à disposição de seus usuários.
			</p>
			<p>
				A <a href="#" class="bold red-text darken-2">Médicus24h</a> está disponível para toda Campina Grande
				e João Pessoa, além de diversas cidades do Estado da Paraíba.
			</p>

			<p>
				A assistência domiciliar foi criada como uma alternativa com uma
				forma de atendimento mais humanizado, uma vez que o paciente vai
				estar em seu domicílio, ao lado de seus familiares, recebendo carinho
				e o atendimento necessário ao seu tratamento e recuperação.
			</p>

			<h5 class="bold">Exemplos de Atendimento</h5>

			<p>Além de outros serviços, a <a href="#" class="bold red-text darken-2">Médicus24h</a> oferece, principalmente, os seguites serviços: </p>

			<p>
				<ul class="list-style-dotted">
					<li> Aplicação de antibióticos endovenosos;</li>
					<li> Pacientes que ficaram dependentes de aparelhos ou cuidados especializados;</li>
					<li> Impossibilidade de remoção em carro comum do paciente com necessidade de tratamento especializado;</li>
					<li> Curativos complexos (úlceras, feridas, escaras, etc.);</li>
					<li> Dieta enteral e parenteral orientação para o uso;</li>
					<li> Entre outros.</li>
				</ul>
			</p>

			<p>
				Esses atendimento são prestados através da solicitação do seu médico
				para o Plano de Saúde ou envio de relatório médico através do Hospital
				contendo todos os detalhes do quadro clínico do paciente.
			</p>
			<p>
				Estes pedidos, então, são analisados pelo o seu Plano de Saúde ou por empresas credenciadas
				para a assistência domiciliar e, portanto, caso se enquadre,
				a <a href="#" class="bold red-text darken-2">Médicus24h</a>
				providenciará o início do tratamento na residência da família ou local indicado pelo familiar.
			</p>

			<p>
				Para a implantação do SERVIÇO DE ASSISTÊNCIA DOMICILIAR (SAD), existe a necessidade
				de um cuidador, que é pessoa da família ou indicada por ela, que tenha um papel de grande
				importância no tratamento do paciente, pois ficará responsável pelos cuidados com o
				mesmo.
			</p>

			<p>
				Uma vez reabilitado ou recuperado do quadro agudo, o paciente recebe alta do programa.
				Os cuidados básicos passados para o cuidador ao longo do programa permitirão ao
				paciente uma melhor qualidade de vida.
			</p>
		</div>
	</div>
</div>

@endsection
