<?php
namespace Models;

use Framework\Database\Stacky\Model;

class RolePermissionModel extends Model
{
	/**
	 * @property int $id
	 * @property int $role_id
	 * @property int $module_id
	 * @property int $permission
	 * @property string $created_at
	 * @property int $created_by
	 * @property string $updated_at
	 * @property int $updated_by
	 */
	protected $table = 'role_permissions';
	protected $config = 'db.config.php';
	protected $columns = [
		'id' => 'int',
		'role_id' => 'int',
		'module_id' => 'int',
		'permission' => 'int',
		'created_at' => 'string',
		'created_by' => 'int',
		'updated_at' => 'string',
		'updated_by' => 'int'
	];
}