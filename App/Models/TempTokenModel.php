<?php
namespace Models;

use Framework\Database\Stacky\Model;

class TemptokenModel extends Model
{
	/**
	 * @property int $id
	 * @property int $admin_id
	 * @property string $email
	 * @property string $token
	 * @property int $type
	 * @property string $expires
	 */
	protected $table = 'temptokens';
	protected $config = 'db.config.php';
	protected $columns = [
		'id' => 'int',
		'email' => 'string',
		'token' => 'string',
		'type' => 'int',
		'expires' => 'string'
	];
}
