<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="color-scheme" content="light">
	<meta name="supported-color-schemes" content="light">
	<style>
		/*
@mediaonlyscreenand(max-width: 600px) {
			.inner-body {
				width: 100% !important;
			}
			.footer {
				width: 100% !important;
			}
		}

@mediaonlyscreenand(max-width: 500px) {
			.button {
				width: 100% !important;
			}
		}
		*/
	</style>
</head>

<body>

	<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
		<tr>
			<td align="center">
				<table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
					<!-- Email Body -->
					<tr>
						<td class="body" width="100%" cellpadding="0" cellspacing="0" bgcolor="#00897b" style="border-radius: 24px;">
							<table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
								<!-- Body content -->
								<tr>
									<td class="content-cell" align="center" style="padding: 20px;">
										<a href="{{ url('https://www.medicus24h.com.br') }}">
											<img src="{{ url('https://transvida.alissonguedes.dev.br/img/site/logo/logo-white.png') }}" alt="" width="200px" style="margin: 30px;">
										</a>
									</td>
								</tr>
								<tr>
									<td style="padding: 0 0 50px;">
										<table align="center" bgcolor="#fff" style="border-radius: 24px;">
											<tr>
												<td style="padding: 5px 20px;">
													<h2 style="">Contato do site <a href="{{ url('https://www.medicus24h.com.br') }}">Medicus24h</a></h2>
												</td>
											</tr>
											<tr>
												<td style="padding: 5px 20px;">
													O cliente <strong style="">{{ $request->nome }}</strong> enviou um e-mail de contato.
												</td>
											</tr>
											<tr>
												<td style="padding: 20px 5px;">
													<ul style="list-style: none; padding: 0; margin: 0;">
														<li>Nome: <strong> {{ $request->nome }} </strong> </li>
														<li>Email: <strong> {{ $request->email }} </strong> </li>
														<li>Telefone: <strong> {{ $request->telefone }} </strong> </li>
														<li>Assunto: <strong> {{ $request->assunto }} </strong> </li>
														<li>Mensagem: <strong> {{ $request->mensagem }} </strong> </li>
													</ul>

												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>

					{{ $footer ?? '' }}
				</table>
			</td>
		</tr>
	</table>
</body>

</html>
