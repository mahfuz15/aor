<?php
namespace Models;

use Framework\Database\Stacky\Model;

class AgentModel extends Model
{
	/**
	 * @property int $id
	 * @property string $username
	 * @property string $email
	 * @property string $password
	 * @property int $role_id
	 * @property int $status
	 * @property int $created_by
	 * @property string $created_at
	 * @property string $updated_at
	 * @property string $last_log
	 * @property string $session_id
	 */
	protected $table = 'agents';
	protected $config = 'db.config.php';
	protected $columns = [
		'id' => 'int',
		'username' => 'string',
		'email' => 'string',
		'password' => 'string',
		'role_id' => 'int',
		'status' => 'int',
		'created_by' => 'int',
		'created_at' => 'string',
		'updated_at' => 'string',
		'last_log' => 'string',
		'session_id' => 'string'
	];
}