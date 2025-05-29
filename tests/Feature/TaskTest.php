<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Task;


class TaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function Task_Can_Be_Listed()
    {
        Task::factory()->count(5)->create();
        
        $response = $this->get('/api/tasks');

        $response->assertStatus(200)
                 ->assertJsonCount(5);
    }

    /** @test */
    public function Task_Can_Be_Shown()
    {
         $task = Task::factory()->create([
            'title' => 'Nova tarefa'
        ]);
        
        $response = $this->get('/api/tasks/' . $task->id);

        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => 'Nova tarefa']);
        $this->assertDatabaseHas('tasks', ['title' => 'Nova tarefa']);
    }

    /** @test */
    public function Task_Can_Be_Created()
    {
        $data = [
            'title' => 'Criar tarefa',
            'description' => 'Descrição da tarefa'
        ];
        $response = $this->post('/api/store', $data);
        $response->assertStatus(201)
                 ->assertJsonFragment(['title' => 'Criar tarefa']);
        $this->assertDatabaseHas('tasks', ['title' => 'Criar tarefa']);
    }

    /** @test */
    public function Task_Can_Be_Updated()
    {
        $task = Task::factory()->create();
        $data = [
            'title' => 'Tarefa atualizada',
            'description' => 'Descrição atualizada'
        ];
        $response = $this->put('/api/tasks/' . $task->id, $data);
        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => 'Tarefa atualizada']);
        $this->assertDatabaseHas('tasks', ['title' => 'Tarefa atualizada']);
    }

    /** @test */
    public function Task_Can_Be_Deleted()
    {
        $task = Task::factory()->create();
        $response = $this->delete('/api/tasks/' . $task->id);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    /** @test */
    public function Task_Can_Be_Completed()
    {
        $task = Task::factory()->create(['completed' => false]);
        $response = $this->put('/api/tasks/completed/' . $task->id);
        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'completed' => true]);
    }
}
