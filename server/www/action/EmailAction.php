<?php
Namespace Action;

class EmailAction extends Action
{
    private $data;

    public function __construct($data)
    {
        parent::__construct();
        $this->data = $data;
    }

    public function process()
    {
        if (!isset($this->data)) {
            \Functions::writeLog("invalid request with email");
            return;
        }

        switch ($this->data->action) {
            case 'add':
                $email = $this->data->email;
                if ($this->db->emailExists($email)) {
                    $this->db->enableEmail($email);
                } else {
                    $this->db->addEmail($email);
                }
                break;
            case 'update' :
                $this->db->updateEmail($this->data->email, $this->data->oldEmail);
                break;
            case 'delete':
                $this->db->disableEmail($this->data->email);
                break;
            default:
                \Functions::writeLog("invalid action with email");
        }
    }
}