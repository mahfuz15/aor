<?php
namespace Models;

use Framework\Database\Stacky\Model;

class RoleModel extends Model
{
	/**
	 * @property int $id
	 * @property string $title
	 * @property string $description
	 * @property int $status
	 * @property string $created_at
	 * @property int $created_by
	 * @property string $updated_at
	 * @property int $updated_by
	 */
	protected $table = 'roles';
	protected $config = 'db.config.php';
	protected $columns = [
		'id' => 'int',
		'title' => 'string',
		'description' => 'string',
		'status' => 'int',
		'created_at' => 'string',
		'created_by' => 'int',
		'updated_at' => 'string',
		'updated_by' => 'int'
	];
}