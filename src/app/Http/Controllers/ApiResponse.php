<?php
namespace App\Http\Controllers;

use App\Enum\HttpStatus;

trait ApiResponse{


    protected function showSuccessResponse($data){

        return [
            "ok"=> true,
            "data"=>$data,
        ];

    }

    protected function showFailResponse(FailMessage $error)
    {

        return [
            "ok"=> false,
            "err"=> $error->error,
            "msg"=> $error->errorMessage
        ];

    }

    public function showResponseOnJSONFormat(bool $isSuccessResponse,$data,int $httpStatusCode=HttpStatus::SUCCESS){
        $response=null;

        if($isSuccessResponse){
            $response=$this->showSuccessResponse($data);
        }else{
            $response=$this->showFailResponse($data);
        }

        return response()->json($response,$httpStatusCode);
    }


}
