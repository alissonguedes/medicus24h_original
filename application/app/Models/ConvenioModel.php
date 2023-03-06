<?php

namespace App\Models{

	use Illuminate\Foundation\Auth\User as Authenticatable;

	class ConvenioModel extends Authenticatable
	{

		// use HasApiTokens, HasFactory, Notifiable;

		protected $table = 'tb_convenio';

		/**
		 * The attributes that are mass assignable.
		 *
		 * @var array<int, string>
		 */
		protected $fillable = [
			'name',
			'email',
			'password',
		];

		/**
		 * The attributes that should be hidden for serialization.
		 *
		 * @var array<int, string>
		 */
		protected $hidden = [
			'password',
			'remember_token',
		];

		/**
		 * The attributes that should be cast.
		 *
		 * @var array<string, string>
		 */
		protected $casts = [
			'email_verified_at' => 'datetime',
		];

		public $timestamps = false;

		public function getConvenio($id = null)
		{

			$get = $this->select('*');

			if (!is_null($id)) {
				$get = $get->where('id', $id);
			}

			$get = $get->whereNull('id_parent');

			return $get->get();

		}

		public function getTipoConvenio($id_tipo = null, $id_parent = null)
		{
			$get = $this->select('*');

			if (!is_null($id_parent)) {
				$get = $get->where('id_parent', $id_parent);
			} else {
				$get = $get->whereNotNull('id_parent');
			}

			if (!is_null($id_tipo)) {
				$get = $get->where('id', $id_tipo);
			}

			return $get->get();
		}

		public function getAcomodacao($id = null)
		{

			$get = $this->select('*')
				->from('tb_acomodacao');

			if (!is_null($id)) {
				$get = $get->where('id', $id);
			}

			return $get->get();

		}

	}

}
