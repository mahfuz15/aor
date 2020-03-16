<?php
namespace Models;

use Framework\Database\Stacky\Model;

class AdminModel extends Model
{
	/**
	 * @property int $id
	 * @property string $name
	 * @property string $username
	 * @property string $email
	 * @property string $password
	 * @property int $role_id
	 * @property string $avatar
	 * @property int $status
	 * @property string $created_at
	 * @property int $created_by
	 * @property string $updated_at
	 * @property int $updated_by
	 * @property string $last_log
	 * @property string $session_id
	 */
	protected $table = 'admins';
	protected $config = 'db.config.php';
	protected $columns = [
		'id' => 'int',
		'name' => 'string',
		'username' => 'string',
		'email' => 'string',
		'password' => 'string',
		'role_id' => 'int',
		'avatar' => 'string',
		'status' => 'int',
		'created_at' => 'string',
		'created_by' => 'int',
		'updated_at' => 'string',
		'updated_by' => 'int',
		'last_log' => 'string',
		'session_id' => 'string'
	];
}