<?php
namespace Models;

use Framework\Database\Stacky\Model;

class RetailerModel extends Model
{
	/**
	 * @property int $id
	 * @property string $name
	 * @property string $shop_name
	 * @property string $address
	 * @property string $email
	 * @property string $phone
	 * @property int $pin
	 * @property string $nid
	 * @property string $trade_license_no
	 * @property string $registration_date
	 * @property string $approve_date
	 * @property int $approve_by
	 * @property int $verified
	 * @property int $status
	 * @property int $temptoken
	 */
	protected $table = 'retailers';
	protected $config = 'db.config.php';
	protected $columns = [
		'id' => 'int',
		'name' => 'string',
		'shop_name' => 'string',
		'address' => 'string',
		'email' => 'string',
		'phone' => 'string',
		'pin' => 'int',
		'nid' => 'string',
		'trade_license_no' => 'string',
		'registration_date' => 'string',
		'approve_date' => 'string',
		'approve_by' => 'int',
		'verified' => 'int',
		'status' => 'int',
		'temptoken' => 'int'
	];
}