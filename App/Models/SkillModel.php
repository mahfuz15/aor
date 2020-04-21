<?php
namespace Models;

use Framework\Database\Stacky\Model;

class SkillModel extends Model
{
	/**
	 * @property int $id
	 * @property string $name
	 * @property int $status
	 * @property string $created_at
	 * @property string $updated_at
	 */
	protected $table = 'skills';
	protected $config = 'db.config.php';
	protected $columns = [
		'id' => 'int',
		'name' => 'string',
		'status' => 'int',
		'created_at' => 'string',
		'updated_at' => 'string'
	];
}