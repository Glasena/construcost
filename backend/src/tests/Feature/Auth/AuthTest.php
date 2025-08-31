<?php

use App\Modules\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_correct_credentials(): void
    {
        // A factory cria um objeto temporário com atributos aleatórios de acordo com o tipo
        // No parâmetro do create() podemos sobrescrever algum atributo
        // A senha precisa ser criptografada, por isso usamos o bcrypt()
        $user = User::factory()->create([
            'password' => bcrypt('senha12345'),
        ]);

        // Isso é um helper de teste do Laravel que simula uma requisição HTTP
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'senha12345',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['access_token']);
    }

    public function test_user_cannot_login_with_incorrect_credentials(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'senha_errada',
        ]);

        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_access_protected_route(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer {$token}")
                         ->getJson('/api/user');

        $response->assertStatus(200)
                 ->assertJson(['id' => $user->id]);
    }
}