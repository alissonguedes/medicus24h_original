<?php

namespace App\Http\Requests\Clinica;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PacienteRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules()
	{

		$rules = [
			'nome'         => 'required',
			'estado_civil' => 'required',
			'etnia'        => 'required',
			'telefone'     => 'required_if:celular,null',
			'celular'      => 'required_if:telefone,null',
			'email'        => 'email|required_if:receber_notificacoes,on',
			'data_obito'   => 'required_if:obito,true',
			'hora_obito'   => Rule::requiredIf($this->obito == 1 || $this->data_obito),
		];

		if ($this->associado === 'yes') {
			$rules['matricula']        = 'required';
			$rules['id_acomodacao']    = 'required';
			$rules['validade_mes']     = 'required';
			$rules['validade_ano']     = 'required';
			$rules['id_tipo_convenio'] = 'required';
		}

		return $rules;
	}
}
