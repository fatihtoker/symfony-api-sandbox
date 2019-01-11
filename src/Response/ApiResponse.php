<?php

namespace App\Response;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class ApiResponse
 * @package AppBundle\Response
 *
 * @Serializer\ExclusionPolicy("all")
 */
class ApiResponse
{
    const STATUS_SUCCESS = 'success';

    const STATUS_INFO = 'info';

    const STATUS_ERROR = 'error';

    /**
     * @var string
     *
     * @Serializer\Expose()
     */
    private $status;

    /**
     * @var int
     *
     * @Serializer\Expose()
     */
    private $statusCode;

    /**
     * @var string
     *
     * @Serializer\Expose()
     */
    private $message;

    /**
     * @var mixed
     *
     * @Serializer\Expose()
     */
    private $data;

    /**
     * @var array
     *
     * @Serializer\Expose()
     */
    private $errors;

    /**
     * @var mixed
     */
    private $pagination;

    public function __construct(
        $status = null,
        $statusCode = null,
        $message = null,
        $data = null,
        $errors = null,
        $pagination = null
    )
    {
        $this->status = $status;
        $this->statusCode = $statusCode;
        $this->message = $message;
        $this->data = $data;
        $this->errors = $errors;
        $this->pagination = $pagination;
    }

    public static function createSuccessResponse($data = null, $message = null, $pagination = null)
    {
        return new self(self::STATUS_SUCCESS, 200, $message, $data, null, $pagination);
    }

    public static function createInfoResponse($message)
    {
        return new self(self::STATUS_INFO, 200, $message);
    }

    public static function createErrorResponse($statusCode, $message, $errors)
    {
        return new self(self::STATUS_ERROR, $statusCode, $message, null, $errors );
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     * @return mixed
     */
    public function getPagination()
    {
        return $this->pagination;
    }

    /**
     * @param mixed $pagination
     */
    public function setPagination($pagination)
    {
        $this->pagination = $pagination;
    }

    public function toAssocArray()
    {
        $data = [];

        if (isset($this->status)) {
            $data['status'] = $this->status;
        }
        if (isset($this->statusCode)) {
            $data['statusCode'] = $this->statusCode;
        }
        if (isset($this->message)) {
            $data['message'] = $this->message;
        }
        if (isset($this->data)) {
            $data['data'] = $this->data;
        }
        if (isset($this->errors)) {
            $data['errors'] = $this->errors;
        }
        if (isset($this->pagination)) {
            $data['pagination'] = $this->pagination;
        }

        return $data;
    }
}