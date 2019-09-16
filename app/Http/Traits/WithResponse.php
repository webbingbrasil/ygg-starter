<?php


namespace App\Http\Traits;


use Illuminate\Http\JsonResponse;

trait WithResponse
{
    /**
     * @param int    $status
     * @param string $title
     * @param mixed $detail
     * @return JsonResponse
     */
    protected function respondWithError($status = 500, $title = 'Unkown Error', $detail = 'Internal server error.') : JsonResponse
    {
        return new JsonResponse([
            'errors' => compact('status', 'title', 'detail')
        ], 401);
    }
}
