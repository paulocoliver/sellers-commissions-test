<?php
if (!function_exists('processRequest')) {
    function processRequest(\Closure $function_ok, \Closure $function_error=null)
    {
        try {
            return $function_ok(request ());

        } catch (\Throwable $error) {
            if (!empty($function_error)) {
                return $function_error($error);
            } else {

                /** @var \Illuminate\Http\Response $responseError */
                if ($error instanceof \Illuminate\Validation\ValidationException) {
                    $responseError = responseValidationError($error);
                } elseif ($error instanceof Illuminate\Database\Eloquent\ModelNotFoundException) {
                    $responseError = responseNotFound();
                } else {
                    $responseError = responseServerError();
                }

                if (config('app.debug')) {
                    $content = $responseError->getOriginalContent();

                    if (!empty($content['error'])) {
                        $msg = $content['error'];
                    } elseif (!empty($content['message'])) {
                        $msg = $content['message'];
                    } else {
                        $msg = $error->getMessage();
                    }
                    $content['message'] = '<p style="font-size: 13px; line-height: 1.2;"><span style="color: #ff7a00; font-size: 11px; margin-bottom: 8px; display: inline-block;">DEBUG LARAVEL IS ON, MORE INFO CHECK CONSOLE.</span><br>'.$msg.'</p>';

                    $content['debug_is_on'] = true;
                    $content['debug'] = [
                        'error' => $error->getMessage(),
                        'file' => $error->getFile(),
                        'line' => $error->getLine(),
                        'trace' => $error->getTrace(),
                        'trace_as_string' => $error->getTraceAsString(),
                    ];

                    $responseError->setContent($content);
                }

                return $responseError;
            }
        }
    }
}

if (!function_exists('responseOk')) {
    function responseOk($data=[])
    {
        if (!$data instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $data = ['data' => $data];
        }
        return response($data, 200);
    }
}

if (!function_exists('responseCreated')) {
    function responseCreated($data=[])
    {
        return response(['data' => $data], 201);
    }
}

if (!function_exists('responseNoContent')) {
    function responseNoContent()
    {
        return response([], 204);
    }
}

if (!function_exists('responseError')) {
    function responseError($error=null, $code=500)
    {
        return response(['error' => $error], (int)$code);
    }
}

if (!function_exists('responseValidationError')) {
    function responseValidationError(\Illuminate\Validation\ValidationException $error)
    {
        return response([
            'error'    => trans('error.validation'),
            'messages' => $error->validator->errors()
        ], 422);
    }
}

if (!function_exists('responseBadRequest')) {
    function responseBadRequest($message=null)
    {
        if (empty($message))
            $message = trans('error.bad-request');

        return responseError($message, 400);
    }
}

if (!function_exists('responseNotAllowed')) {
    function responseNotAllowed($message=null)
    {
        if (empty($message))
            $message = trans('error.not-allowed');

        return responseError($message, 403);
    }
}

if (!function_exists('responseNotFound')) {
    function responseNotFound($message=null)
    {
        if (empty($message))
            $message = trans('error.not-found');

        return responseError($message, 404);
    }
}

if (!function_exists('responseServerError')) {
    function responseServerError($message = null)
    {
        if (empty($message))
            $message = trans('error.unknown');

        return responseError($message, 500);
    }
}

if (!function_exists('validatorUnique')) {
    /**
     * @param $table
     * @param string $column
     * @return \Illuminate\Validation\Rules\Unique
     */
    function validatorUnique($table, $column = 'NULL')
    {
        return \Illuminate\Validation\Rule::unique($table, $column);
    }
}

if (!function_exists('validatorExists')) {
    /**
     * @param $table
     * @param string $column
     * @return \Illuminate\Validation\Rules\Exists
     */
    function validatorExists($table, $column = 'NULL')
    {
        return \Illuminate\Validation\Rule::exists($table,$column);
    }
}