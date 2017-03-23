<?php

namespace App\Middleware;

use App\Middleware\Middleware;

class CsrfViewMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        // $csrfNameKey = $this->container->csrf->getTokenNameKey();
        // $csrfValueKey = $this->container->csrf->getTokenValueKey();
        // $csrfName = $this->container->csrf->getTokenName();
        // $csrfValue = $this->container->csrf->getTokenValue();
        // var_dump($csrfValue);
        // die();
        //
        // $this->container->view->getEnvironment()->addGlobal('csrf',[
        //     'keys' => [
        //             'name'  => $csrfNameKey,
        //             'value' => $csrfValueKey
        //         ],
        //         'name'  => $csrfName,
        //         'value' => $csrfValue
        // ]);
        $this->container->view->getEnvironment()->addGlobal('csrf',[
            'field' => '
            <input type="hidden" name="'. $this->container->csrf->getTokenNameKey() .'" value="'. $this->container->csrf->getTokenName() .'">
            <input type="hidden" name="'. $this->container->csrf->getTokenValueKey() .'" value="'. $this->container->csrf->getTokenValue() .'">
            '
        ]);

        $response = $next($request, $response);

        return $response;
    }
}
