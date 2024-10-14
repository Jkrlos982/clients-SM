<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Client;
use App\Models\User;
use Tests\TestCase;

class ClientControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Prueba que un usuario autenticado puede almacenar un cliente.
     *
     * @return void
     */
    public function test_authenticated_user_can_store_a_client()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '+1-555-555-5555',
            'address' => '456 Main St',
        ];

        $response = $this->post(route('clients.store'), $data);

        $this->assertDatabaseHas('clients', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);

        $response->assertRedirect(route('clients.index'));
    }

    /**
     * Prueba que un usuario no autenticado no puede almacenar un cliente.
     *
     * @return void
     */
    public function test_guest_user_cannot_store_a_client()
    {
        $data = [
            'name' => 'Guest Client',
            'email' => 'guest@example.com',
            'phone' => '+1-555-555-5555',
            'address' => '789 Main St',
        ];

        $response = $this->post(route('clients.store'), $data);

        $this->assertDatabaseMissing('clients', [
            'name' => 'Guest Client',
            'email' => 'guest@example.com',
        ]);

        $response->assertRedirect(route('login')); 
    }

    /**
     * Prueba que un usuario autenticado puede actualizar un cliente.
     *
     * @return void
     */
    public function test_authenticated_user_can_update_a_client()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $client = Client::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'address' => '123 Main St',
        ]);

        $updatedData = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '+1-555-555-5555',
            'address' => '456 Main St',
        ];

        $response = $this->put(route('clients.update', $client->id), $updatedData);
        $response->assertRedirect(route('clients.index'));

        $this->assertDatabaseHas('clients', $updatedData);
    }

    /**
     * Prueba que un usuario no autenticado no puede actualizar un cliente.
     *
     * @return void
     */
    public function test_unauthenticated_user_cannot_update_a_client()
    {
        $client = Client::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'address' => '123 Main St',
        ]);

        $updatedData = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '+1-555-555-5555',
            'address' => '456 Main St',
        ];

        $response = $this->put(route('clients.update', $client->id), $updatedData);
        $response->assertRedirect(route('login'));

        $this->assertDatabaseHas('clients', [
            'id' => $client->id,
            'name' => 'John Doe', 
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'address' => '123 Main St',
        ]);
    }

    /**
     * Prueba que un usuario autenticado puede borrar un cliente.
     *
     * @return void
     */
    public function test_authenticated_user_can_delete_a_client()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $client = Client::factory()->create();

        $response = $this->delete(route('clients.destroy', $client->id));
        $response->assertRedirect(route('clients.index'));

        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }

    /**
     * Prueba que un usuario no autenticado no puede borrar un cliente.
     *
     * @return void
     */
    public function test_unauthenticated_user_cannot_delete_a_client()
    {
        $client = Client::factory()->create();

        $response = $this->delete(route('clients.destroy', $client->id));
        $response->assertRedirect(route('login'));

        $this->assertDatabaseHas('clients', ['id' => $client->id]);
    }

    /**
     * Prueba para las validaciones en el formulario de creacion de cliente.
     *
     * @return void
     */
    public function test_it_validates_the_client_form_data()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->post(route('clients.store'), [
            'name' => '',
            'email' => 'invalid-email',
            'phone' => '123',
            'address' => ''
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'phone', 'address']);
    }

    /**
     * Prueba para las ruta de clients.index.
     *
     * @return void
     */
    public function test_it_displays_the_client_index_view()
    {
        $this->actingAs(User::factory()->create());
        $clients = Client::factory()->count(10)->create();

        $response = $this->get(route('clients.index'));
        $response->assertStatus(200);
        $response->assertViewIs('clients.index');
        $response->assertViewHas('clients');
    }

    /**
     * Prueba que el formulario de update no identifique el correo como duplicado
     * si este no se modifica.
     *
     * @return void
     */
    public function test_it_validates_unique_email_when_updating_a_client()
    {
        $existingClient = Client::factory()->create(['email' => 'existing@example.com']);
        $clientToUpdate = Client::factory()->create();

        $this->actingAs(User::factory()->create());

        $response = $this->put(route('clients.update', $clientToUpdate->id), [
            'name' => 'Updated Name',
            'email' => 'existing@example.com',
            'phone' => '+1-987-654-3210',
            'address' => 'Updated Address',
        ]);

        $response->assertSessionHasErrors('email');
    }
}
