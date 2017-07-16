<?php

namespace Http\Middleware;


class Auth {

    public function __invoke($request, $response, $next) {
        return true;
    }

}