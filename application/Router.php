<?php

class Router
{
    public $urls;
    public $request_uri;

    function __construct($server, $urls)
    {
        $this->urls = $urls;
        $this->request_uri = $server['REDIRECT_URL'];
    }

    /**
     * @codeCoverageIgnore
     */
    function buildRequest() {
        return array('get'=>$_GET);
    }

    function dispatchController($controller) {
        return $controller->dispatch($this->buildRequest());
    }

    function run()
    {
        $controller = $this->fetchController();
        if (is_null($controller)) {
            http_response_code(404);
            return;
        }
        # TODO: Dispatch differently depending on the HTTP VERB (aka method)
        # TODO: Add relevant information to the dispatch as $_GET, $_POST, etc
        try {
            $response = $this->dispatchController($controller);
        } catch (Exception $e) {
            http_response_code(500);
            return;
        }
        header($response->getContentType());
        echo $response->getContent();

    }

    function fetchController()
    {
        foreach ($this->urls as $exp => $controller) {
            if (preg_match($exp, $this->request_uri, $matches)) {
                foreach($matches as $k => $v) { if(is_int($k)) { unset($matches[$k]); } }
                return new $controller($matches);
            }
        }
    }
}