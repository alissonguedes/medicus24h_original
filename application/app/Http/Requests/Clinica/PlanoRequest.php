<?php

namespace App\Http\Requests\Clinica;

use Illuminate\Foundation\Http\FormRequest;

class PlanoRequest extends FormRequest
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
			'id_plano'      => 'required',
			'id_tipo_plano' => 'required',
			'id_acomodacao' => 'required',
			'matricula'     => 'required',
			'validade_mes'  => 'required',
			'validade_ano'  => 'required',
		];

		return $rules;

	}

}
