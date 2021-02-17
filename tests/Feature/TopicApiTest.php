<?php

namespace Tests\Feature;

use Tests\Traits\ActingJWTUser;
use Tests\TestCase;
use App\Models\User;
use App\Models\Topic;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TopicApiTest extends TestCase
{
    use ActingJWTUser;
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function testStoreTopic()
    {
        $data = ['category_id' => 1, 'body' => 'test body', 'title' => 'test title'];

        $token = auth('api')->fromUser($this->user);
        $response = $this->JWTActingAs($this->user)
            ->json('POST', '/api/v1/topics', $data);

        $assertData = [
            'category_id' => 1,
            'user_id' => $this->user->id,
            'title' => 'test title',
            'body' => clean('test body', 'user_topic_body'),
        ];

        $response->assertStatus(201)
            ->assertJsonFragment($assertData);
    }

    public function testUpdateTopic()
    {
        $topic = $this->makeTopic();

        $editData = ['category_id' => 2, 'body' => 'edit body', 'title' => 'edit title'];

        $response = $this->JWTActingAs($this->user)
            ->json('PATCH', '/api/v1/topics/'.$topic->id, $editData);

        $assertData= [
            'category_id' => 2,
            'user_id' => $this->user->id,
            'title' => 'edit title',
            'body' => clean('edit body', 'user_topic_body'),
        ];

        $response->assertStatus(200)
            ->assertJsonFragment($assertData);
    }

    public function testShowTopic()
    {
        $topic = $this->makeTopic();
        $response = $this->json('GET', '/api/v1/topics/'.$topic->id);

        $assertData= [
            'category_id' => $topic->category_id,
            'user_id' => $topic->user_id,
            'title' => $topic->title,
            'body' => $topic->body,
        ];

        $response->assertStatus(200)
            ->assertJsonFragment($assertData);
    }

    public function testIndexTopic()
    {
        $response = $this->json('GET', '/api/v1/topics');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'meta']);
    }

    protected function makeTopic()
    {
        return Topic::factory()->create([
            'user_id' => $this->user->id,
            'category_id' => 1,
        ]);
    }
}
