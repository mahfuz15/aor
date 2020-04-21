<?php
namespace App\Services;

use Models\CompanyEmailModel;
use Framework\FileSystem\FileManager;

class EmailService
{

    /**
     *
     * @var Models\CompanyEmailModel
     */
    protected $model;

    public function __construct()
    {
        $this->model = new CompanyEmailModel();
    }

    public function getByID(int $id)
    {
        return $this->model->where('id', $id)->first()->get();
    }

    public function getByEmail(string $email)
    {
        return $this->model->where('email', $email)->first()->get();
    }

    public function createNew(int $companyID, int $domainID, string $email, $name = '', $status = 1)
    {
        $this->model->company_id = $companyID;
        $this->model->domain_id = $domainID;
        $this->model->from_name = $name;
        $this->model->email = $email;
        $this->model->status = $status;

        return $this->model->insert();
    }

    public function attachNameToEmail(int $emailID, $name)
    {
        $this->model->from_name = $name;
        $this->model->where('id', $emailID)->update();
    }

    public function activateEmailsByDomainID(int $domainID)
    {
        $this->model->status = 1;
        $this->model->where('domain_id', $domainID)->update();
    }

    public function deactivateEmailsByDomainID(int $domainID)
    {
        $this->model->status = 0;
        $this->model->where('domain_id', $domainID)->update();
    }

    public function activateEmailsByDomain(string $domain)
    {
        $emails = $this->model->where('email', 'LIKE', '%' . $domain)->orderBy('id')->getAll();

        if (!empty($emails)) {
            foreach ($emails as $email) {
                $this->model->status = 1;
                $this->model->where('id', $email->id)->update();
            }
        }

        return;
    }

    public function getByDomain(string $domain)
    {
        return $this->model->where('email', 'LIKE', '%' . $domain)->first()->get();
    }
}
