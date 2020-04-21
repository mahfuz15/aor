<?php
namespace Models;

use Framework\Database\Stacky\Model;

class CandidateSkillModel extends Model
{
	/**
	 * @property int $id
	 * @property int $candidate_id
	 * @property int $skill_id
	 * @property string $created_at
	 * @property string $updated_at
	 */
	protected $table = 'candidate_skills';
	protected $config = 'db.config.php';
	protected $columns = [
		'id' => 'int',
		'candidate_id' => 'int',
		'skill_id' => 'int',
		'created_at' => 'string',
		'updated_at' => 'string'
	];

	// public function candidate()
    // {
    //     return $this->belongsTo('CandidateModel');
    // }
}