<?php

declare(strict_types=1);

namespace aspirantzhang\thinkphp6UnitTest;

use think\App;
use app\Request;
use Mockery as m;

trait UnitTestTrait
{
    protected $request;
    protected $app;
    protected $response;

    public function startApp()
    {
        (new App())->http->run();
    }

    public function startRequest(string $method = "GET", array $data = [])
    {
        $this->request = new Request();

        $method = strtoupper($method);
        switch ($method) {
            case 'GET':
                $this->request->withGet($data);
                break;
            case 'POST':
                $this->request->withServer(['REQUEST_METHOD' => 'POST']);
                $this->request->setMethod('POST');
                $this->request->withPost($data);
                break;
            case 'PUT':
                $this->request->withHeader(['Content-Type' => 'application/json']);
                $this->request->withServer(['REQUEST_METHOD' => 'PUT']);
                $this->request->setMethod('PUT');
                $this->request->withInput(json_encode($data));
                break;
            default:
                break;
        }

        $this->app = new App();
        $this->response = $this->app->http->run($this->request);
    }

    public function setLang($lang)
    {
        $mock = m::mock('alias:think\facade\Lang');
        $mock->shouldReceive('getLangSet')->andReturn($lang);
        $mock->shouldReceive('load')->andReturnNull();
    }

    public function endRequest()
    {
        $this->app->http->end($this->response);
    }
}
