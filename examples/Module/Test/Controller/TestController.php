<?php

namespace App\Module\Test\Controller;

use App\Module\Test\Repository\TestRepository;
use App\Module\Test\Service\TestService;
use Structure\Base\Controller\Controller;

/**
 * Class TestController
 * @package App\Module\Test\Controller
 */
class TestController extends Controller
{
    /** @var TestService */
    protected $testService;
    /** @var TestRepository */
    protected $testRepository;

    /**
     * TestController constructor.
     * @param TestService $testService
     * @param TestRepository $testRepository
     */
    public function __construct(TestService $testService, TestRepository $testRepository)
    {
        $this->testService = $testService;
        $this->testRepository = $testRepository;
    }


    public function testAction()
    {
        trans("test.test");
        return $this->testRepository->test();
    }
}
