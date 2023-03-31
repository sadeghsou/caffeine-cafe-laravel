<?php

namespace App\Traits\Utils;

trait Responser
{

  private function makeResponse($data, $status, $message)
  {
    return response()->json([
      'data' => $data,
      'meta' => [
        'status' => $status,
        'messages' => @unserialize($message) === false ? $message : unserialize($message)
      ]
    ], 200);
  }

  public function successful($data, $message = "Successful", $status = 200)
  {
    return $this->makeResponse($data, $status, $message);
  }

  public function clientError($message = "Client Error", $status = 400)
  {
    return $this->makeResponse(null, $status, $message);
  }

  public function serverError($message = "Server Error", $status = 500)
  {
    return $this->makeResponse(null, $status, $message);
  }
}
