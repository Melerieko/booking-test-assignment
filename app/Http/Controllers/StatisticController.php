<?php

namespace App\Http\Controllers;

use App\Services\Tasks\Task1Service;
use App\Services\Tasks\Task2Service;
use App\Services\Tasks\Task3Service;

class StatisticController extends Controller
{
    public function __construct(
        private readonly Task1Service $task1Service,
        private readonly Task2Service $task2Service,
        private readonly Task3Service $task3Service,
    ){}

    public function index()
    {
        $task1 = $this->task1Service->calculate();
        $task2 = $this->task2Service->calculate();
        $task3 = $this->task3Service->calculate();
        return view('statistic', compact(['task1', 'task2', 'task3']));
    }
}
