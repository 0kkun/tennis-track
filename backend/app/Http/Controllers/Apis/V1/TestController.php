<?php

namespace App\Http\Controllers\Apis\V1;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\TestRepositoryInterface;
use App\Services\Interfaces\TestServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    public function __construct(
        private TestServiceInterface $testService,
        private TestRepositoryInterface $testRepository,
    )
    {
        $this->testService = $testService;
        $this->testRepository = $testRepository;
    }

    public function index()
    {
        $service = $this->testService->test();
        $repository = $this->testRepository->test();
        Log::info('TestService:' . $service);
        Log::info('TestRepository:' . $repository);
        return view('test');
    }
}
