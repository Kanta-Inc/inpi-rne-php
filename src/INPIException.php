<?php

namespace RNEClient;

class INPIException extends \Exception 
{
    const BAD_REQUEST_ERROR = 'The request is invalid.';
    const BAD_CREDENTIALS_ERROR = 'The user credentials are invalid.';
    const FORBIDDEN_ERROR = 'The user does not have the necessary authorizations to make the request.';
    const TOO_MANY_REQUESTS_ERROR = 'The user has exceeded the daily quotas.';
    const INTERNAL_SERVER_ERROR = 'The server encountered an unexpected error.';

    public function __construct($message, $code = 0, \Throwable $previous = null) 
    {
        parent::__construct($message, $code, $previous);
    }

}