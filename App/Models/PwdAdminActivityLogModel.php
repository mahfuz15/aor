<?php
namespace Models;

use Framework\Database\Stacky\Model;

class PwdAdminActivityLogModel extends Model
{
	/**
	 * @property int $id
	 * @property string $date
	 * @property string $time
	 * @property int $week_of_year
	 * @property int $admin_id
	 * @property string $ip
	 * @property string $path
	 * @property string $search
	 * @property string $uagt
	 * @property string $ref
	 * @property int $language_id
	 * @property int $product_id
	 * @property string $file
	 * @property string $os
	 * @property string $browser
	 */
	protected $table = 'pwd_admin_activity_log';
	protected $config = 'db.config.php';
	protected $columns = [
		'id' => 'int',
		'date' => 'string',
		'time' => 'string',
		'week_of_year' => 'int',
		'admin_id' => 'int',
		'ip' => 'string',
		'path' => 'string',
		'search' => 'string',
		'uagt' => 'string',
		'ref' => 'string',
		'language_id' => 'int',
		'product_id' => 'int',
		'file' => 'string',
		'os' => 'string',
		'browser' => 'string'
	];
}