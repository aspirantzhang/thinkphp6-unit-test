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
    protected $mock;

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
            case 'PATCH':
                $this->request->withHeader(['Content-Type' => 'application/json']);
                $this->request->withServer(['REQUEST_METHOD' => $method]);
                $this->request->setMethod($method);
                $this->request->withInput(json_encode($data));
                break;
            default:
                break;
        }

        $this->app = new App();
        $this->response = $this->app->http->run($this->request);
    }

    public function mockLang($lang)
    {
        $this->mock = m::mock('overload:think\facade\Lang');
        $this->mock->shouldReceive('getLangSet')->andReturn($lang);
        $this->mock->shouldReceive('load')->andReturnNull();
        $this->mock->shouldReceive('get')->andReturnNull();
    }

    public function endRequest()
    {
        $this->app->http->end($this->response);
    }
    
    public function endMockLang()
    {
        m::close();
        unset($this->mock);
    }
}
