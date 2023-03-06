@php
	$dptos = [];
@endphp

@if(isset($select))

	@foreach($select as $s)

		@php
			$dptos[] = ['id' => $s->id, 'titulo' => $s->titulo ];
		@endphp

	@endforeach

@else

	@php
		$dptos = 'Não existem departamentos nesta empresa.';
	@endphp

@endif

@php
	echo json_encode($dptos);
@endphp
