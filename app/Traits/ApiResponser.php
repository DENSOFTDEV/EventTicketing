<?php


namespace App\Traits;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait ApiResponser
{

    private function successResponse($data, $code = 200)
    {
        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code = 409)
    {
        return response()->json([
            'error' => $message,
            'code' => $code
        ], $code);
    }


    protected function showall(Collection $collection, $code = 200)
    {

        return $this->successResponse($collection, $code);

    }

    protected function showone(Model $model, $code = 200)
    {
        return $this->successResponse($model, $code);

    }

}
