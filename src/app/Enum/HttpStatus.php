<?php

namespace App\Enum;

final class HttpStatus{
        // HTTP STATUS CODE
        const SUCCESS = 200;
        const ERROR = 500;
        const NOTFOUND = 404;//204; //partial content for 206
        const NOCONTENT = 204;//204; //partial content for 206
        const BADREQUEST =400;
        const VALIDATIONERROR =400; //VALIDATIONERROR =422;
        const UNAUTHORIZED = 401;
        const FORBIDDEN = 403;
}
