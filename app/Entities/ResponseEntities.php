<?php

namespace App\Entities;

use Illuminate\Contracts\Support\Responsable;

/**
 * Class GenericResponseEntity
 * @package App\Entities
 */
class ResponseEntities implements Responsable
{

    /**
     * @var bool
     */
    public $success = false;
    /**
     * @var string|null
     */
    public $message = null;
    /**
     * @var object|null
     */
    public $data = null;
    /**
     * @var array|null
     */
    public $errors = null;

    public $httpStatusCode = null;

    public $processTime = null;

    private $timeStart = null;

    public function __construct()
    {
        $this->timeStart = microtime(true);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        $httpCode = $this->success ? 200 : ($this->httpStatusCode ?? 400);

        $timeEnd = microtime(true);
        $calculatedProcessTime = round($this->processTime ?? ($timeEnd - $this->timeStart) , 6) . ' second(s)';

        return response()->json([
                'success' => $this->success ,
                'process_time' => $calculatedProcessTime ,
                'message' => $this->message ,
                'data' => $this->data]
            , $httpCode);
    }

    public static function toJson($data = null , $success = true , $message = 'ok' , $httpCode = 200)
    {

        return response()->json([
                'success' => $success ,
                'message' => $message ,
                'data' => $data]
            , $httpCode);
    }
}
