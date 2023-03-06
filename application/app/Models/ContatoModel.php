<?php

namespace App\Models;

use Illuminate\Contracts\Mail\Attachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Mail\Attachment;
use Illuminate\Notifications\Notifiable;

class ContatoModel extends Model implements Attachable
{

	use HasFactory, Notifiable;

	protected $table = 'tb_sys_config';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [];

	/**
	 *
	 */
	private $order = [];

	public function sendMail($request)
	{

		// return Attachment::fromPath('/');

	}

	public function toMailAttachment()
	{
		// return Attachment::fromPath('/path/to/file');
	}

}
