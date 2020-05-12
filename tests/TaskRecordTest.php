<?php

namespace Chriscreates\Projects\Tests;

use Chriscreates\Projects\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskRecordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_task_can_record_time()
    {
        $task = factory(Task::class)->create();

        $this->assertCount(0, $task->records);

        $task->recordTime(now()->subHour(), now());

        $this->assertCount(1, $task->records);
    }

    /** @test */
    public function a_task_can_record_hours()
    {
        $task = factory(Task::class)->create();

        $this->assertCount(0, $task->records);

        $task->addHours(3.5);

        $this->assertCount(1, $task->records);
    }

    /** @test */
    public function a_task_can_remove_a_record()
    {
        $task = factory(Task::class)->create();

        $task->recordTime(now()->subHour(), now());

        $this->assertCount(1, $task->records);

        $task->removeRecord($task->records->first());

        $this->assertCount(0, $task->records);
    }

    /** @test */
    public function a_task_can_deduct_time_from_the_total()
    {
        $task = factory(Task::class)->create();

        $task->deductHours(5.1524242);

        $this->assertCount(1, $task->records);

        $this->assertEquals(5.15, $task->records->first()->deduct_hours);
    }

    /** @test */
    public function a_task_can_have_a_sum_of_recordable_hours()
    {
        $task = factory(Task::class)->create();

        $this->assertEquals(0, $task->records->sumHours());

        $task->addHours(1);

        $task->recordTime(now()->subHours(10), now());

        $task->deductHours(3.5);

        $this->assertEquals(7.5, $task->records->sumHours());
    }
}
