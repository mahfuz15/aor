<?php
namespace Models;

use Framework\Database\Stacky\Model;

class ModuleModel extends Model
{
	/**
	 * @property int $id
	 * @property string $title
	 * @property string $route
	 * @property string $icon
	 * @property int $status
	 * @property string $alias
	 * @property string $created_at
	 * @property int $created_by
	 * @property string $updated_at
	 * @property int $updated_by
	 */
	protected $table = 'modules';
	protected $config = 'db.config.php';
	protected $columns = [
		'id' => 'int',
		'title' => 'string',
		'route' => 'string',
		'icon' => 'string',
		'status' => 'int',
		'alias' => 'string',
		'created_at' => 'string',
		'created_by' => 'int',
		'updated_at' => 'string',
		'updated_by' => 'int'
	];
}