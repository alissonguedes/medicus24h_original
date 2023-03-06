<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as ModelCore;

class Model extends ModelCore
{

	private $request;

	protected $fields  = [];
	protected $datamap = [];

	protected function map(string $key)
	{

		if (empty($this->datamap)) {
			return $key;
		}

		if (!empty($this->datamap[$key])) {
			return $this->datamap[$key];
		}

		return $key;

	}

	protected function fields($field)
	{

		$data = [];

		unset($field['id']);
		unset($field['_token']);
		unset($field['_method']);

		foreach ($field as $i => $v) {

			$k = $this->map($i);

			$data[$k] = $v;

		}

		// dd($data);

		return $data;

	}

}
