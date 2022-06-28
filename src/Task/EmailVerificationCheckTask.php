<?php

namespace App\Task;

use App\Repository\UserRepository;
use Rewieer\TaskSchedulerBundle\Task\AbstractScheduledTask;
use Rewieer\TaskSchedulerBundle\Task\Schedule;

class EmailVerificationCheckTask extends AbstractScheduledTask
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        parent::__construct();
    }

    protected function initialize(Schedule $schedule) {
        $schedule
            ->everyMinutes(1); // Perform the task every 5 minutes
    }

    public function run(): void {
        // Do stuff
//        var_dump($this->userRepository->getUnverifiedUsers());die();
        $this->userRepository->deleteUnverifiedUsers();
    }
}