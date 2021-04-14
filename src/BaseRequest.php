<?php

declare(strict_types=1);

namespace aspirantzhang\thinkphp6UnitTest;

use think\App;
use app\Request;

trait UnitTestTrait
{
    protected $request;
    protected $app;
    protected $response;

    public function startRequest(string $method = "GET", array $data = [])
    {
        $method = strtoupper($method);
        switch ($method) {
            case 'GET':
                $this->request = new Request();
                $this->app = new App();
                $this->response = $this->app->http->run($this->request);
                break;
            case 'POST':
                $this->request = new Request();
                $this->request->withServer(['REQUEST_METHOD' => 'POST']);
                $this->request->setMethod('POST');
                $this->request->withPost($data);
                $this->app = new App();
                $this->response = $this->app->http->run($this->request);
                break;
            case 'PUT':
                $this->request = new Request();
                $this->request->withHeader(['Content-Type' => 'application/json']);
                $this->request->withServer(['REQUEST_METHOD' => 'PUT']);
                $this->request->setMethod('PUT');
                $this->request->withInput(json_encode($data));
                $this->app = new App();
                $this->response = $this->app->http->run($this->request);
                break;
            default:
                # code...
                break;
        }
    }

    public function endRequest()
    {
        $this->app->http->end($this->response);
    }
}
