<?php

namespace Modules\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiFormRequest extends FormRequest
{

    /**
     * Get the failed validation response for the request.
     *
     * @param array $errors
     * @return JsonResponse
     */
    public function response(array $errors)
    {
        $transformed = [];

        foreach ($errors as $field => $message) {
            $transformed[] = [
                'field' => $field,
                'message' => $message[0]
            ];
        }

        return response()->json([
            'result'         => 0,
            'current_time' => time(),
            'message'      => json_encode($transformed),
            'data'         => new \stdClass(),
            'error'        => [
                'code' => 99,
                'message' => json_encode($transformed)
            ]
        ]);
    }
}
