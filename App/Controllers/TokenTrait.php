<?php
namespace Controllers;

trait TokenTrait
{

    public function registerToken(string $email, int $type = 0, string $expireDeadLine = '+ 3 hours')
    {
        $tempModel = $this->loadModel('TempToken');
        $datetime = new \DateTime();
        $datetime->modify($expireDeadLine);

        $token = bin2hex(random_bytes(32));
        $previousToken = $tempModel->where('email', $email)->orderBy('id')->limit(1)->get();

        $tempModel->token = $token;
        $tempModel->expires = $datetime->format(DATETIME_FORMAT);

        if ($previousToken === false) {
            $tempModel->email = $email;
            $tempModel->type = $type;

            if ($tempModel->insert() !== false) {
                return $token;
            }
        } else {
            if ($tempModel->where('id', $previousToken->id)->update() !== false) {
                return $token;
            }
        }

        return false;
    }

    public function validateToken(string $token)
    {
        $tokenModel = $this->loadModel('TempToken');

        $tokenInfo = $tokenModel->where('token', $token)
            ->orderBy('id', 'DESC')->limit(1)
            ->get();

        if (!empty($tokenInfo)) {
            if ($tokenInfo->expires > DATETIME) {
                return true;
            } else {
                $this->terminateToken($tokenModel, 'id', $tokenInfo->id);
            }
        }

        return false;
    }

    public function returnTokenObj(string $token)
    {
        $tokenModel = $this->loadModel('TempToken');

        $tokenInfo = $tokenModel->where('token', $token)
            ->orderBy('id', 'DESC')->limit(1)
            ->get();

        if (!empty($tokenInfo)) {
            if ($tokenInfo->expires > DATETIME) {
                return $tokenInfo;
            } else {
                $this->terminateToken($tokenModel, 'id', $tokenInfo->id);
            }
        }

        return false;
    }

    public function terminateToken($model = false, string $field, $value)
    {
        if ($model === false) {
            $model = $this->loadModel('TempToken');
        }
        return $model->where($field, $value)->delete();
    }
}
