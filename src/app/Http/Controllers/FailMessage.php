<?php
namespace App\Http\Controllers;

class FailMessage{
    public $error;
    public $errorCode;
    public $errorMessage;

    public function __construct($error,$errorMessage,$errorCode=null)
    {
        $this->error=$error;
        $this->errorCode=$errorCode;
        $this->errorMessage=$errorMessage;

    }
}
