<?php

namespace Controllers;

use Framework\Http\Request\Request;
use Framework\Controller\Controller;

class CandidateSkillController extends Controller
{

    public function __construct()
    {
      $this->model = $this->loadModel('CandidateSkill');
    }

    public function saveCandidateSkill($candidateSkillInfo = false){
      
      if($candidateSkillInfo === false) return false;

      //pr($candidateSkillInfo->skills);

      foreach($candidateSkillInfo->skills as $candidate_skill){
          $skill_exist = $this->model->where('candidate_id', $candidateSkillInfo->candidate_id)->andWhere('skill_id', $candidate_skill)->get();
          $this->model->candidate_id = $candidateSkillInfo->candidate_id;
          //pr($skill_exist);
          $this->model->skill_id = $candidate_skill;
          $this->model->updated_at = DATETIME;
          if($skill_exist === false){
            $this->model->created_at = DATETIME;
            $candidateSkillID = $this->model->insert();
          } else {
            $this->model->where('id', $skill_exist->id)->update();
            $candidateSkillID = $skill_exist->id;
          }
          if($candidateSkillID === false) return false;
      }
      //exit;
      return true;
    }
}