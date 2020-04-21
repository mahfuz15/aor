<?php
namespace Models;

use Framework\Database\Stacky\Model;

class CandidateModel extends Model
{
	/**
	 * @property int $id
	 * @property string $title
	 * @property string $description
	 * @property string $resume_link
	 * @property string $location
	 * @property string $state
	 * @property string $city
	 * @property string $candidate_email
	 * @property int $status
	 * @property int $joined_by
	 * @property string $joined_at
	 * @property string $updated_at
	 */
	protected $table = 'candidates';
	protected $config = 'db.config.php';
	protected $columns = [
		'id' => 'int',
		'title' => 'string',
		'description' => 'string',
		'resume_link' => 'string',
		'location' => 'string',
		'state' => 'string',
		'city' => 'string',
		'candidate_email' => 'string',
		'status' => 'int',
		'joined_by' => 'int',
		'joined_at' => 'string',
		'updated_at' => 'string'
	];

	// public function skills(){
	// 	return $this->hasMany("CandidateSkillModel", "candidate_id");
    // }
}