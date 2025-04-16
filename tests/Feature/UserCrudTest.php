<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr; // <-- Import Arr facade
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;


class UserCrudTest extends TestCase
{
    use RefreshDatabase;

    // Test setup to define countries (avoids repeating in multiple tests)
    protected array $countries = [];
    protected function setUp(): void
    {
        parent::setUp();
        // Define the valid countries consistent with config/countries.php
        // Use the codes as keys, matching the config file
        $this->countries = [
            'USA' => 'United States',
            'CAN' => 'Canada',
            'GBR' => 'United Kingdom',
            'AUS' => 'Australia',
            'DEU' => 'Germany',
            'FRA' => 'France',
        ];
        // Create the dummy config for testing environment
        config(['countries' => $this->countries]);
    }


    #[Test]
    public function user_creation_form_can_be_displayed(): void
    {
        $response = $this->get(route('users.create'));
        $response->assertStatus(200);
        $response->assertViewIs('users.create');
        $response->assertSee('Create New User');
        $response->assertViewHas('countries', $this->countries); // Assert countries are passed
    }

    #[Test]
    public function a_user_can_be_created(): void
    {
        // Use a valid country code from our list
        $validCountryCode = Arr::random(array_keys($this->countries)); // Pick a random valid code

        $userData = [
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone' => '1234567890',
            'country' => $validCountryCode, // <-- Use valid code
            'gender' => 'Male',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];
        $response = $this->post(route('users.store'), $userData);
        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'john.doe@example.com',
            'country' => $validCountryCode // Assert correct country saved
        ]);
    }

    #[Test] // <-- NEW TEST FOR INVALID COUNTRY
    public function user_creation_fails_with_invalid_country(): void
    {
        $userData = [
            'name' => 'Invalid',
            'surname' => 'Country',
            'email' => 'invalid.country@example.com',
            'phone' => '1234567890',
            'country' => 'ZZZ', // <-- Use an INVALID code
            'gender' => 'Male',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        // Act: Post the data
        $response = $this->post(route('users.store'), $userData);

        // Assert: Should redirect back due to validation error
        $response->assertStatus(302); // Check for redirect
        $response->assertSessionHasErrors('country'); // Specifically check for error on 'country' field
        $this->assertDatabaseMissing('users', ['email' => 'invalid.country@example.com']); // Ensure user was NOT created
    }


    #[Test]
    public function a_user_can_be_created_with_profile_picture(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('avatar.jpg', 100, 100)->size(50);
        $validCountryCode = Arr::random(array_keys($this->countries)); // Use valid code

        $userData = [
            'name' => 'Image',
            'surname' => 'User',
            'email' => 'image.user@example.com',
            'phone' => '1112223333',
            'country' => $validCountryCode, // <-- Use valid code
            'gender' => 'Female',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'profile_picture' => $file,
        ];
        $response = $this->post(route('users.store'), $userData);
        $user = User::where('email', 'image.user@example.com')->first();
        $this->assertNotNull($user);
        $this->assertNotNull($user->profile_picture);
        Storage::disk('public')->assertExists($user->profile_picture);
        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'image.user@example.com',
            'country' => $validCountryCode
        ]);
    }

    #[Test]
    public function users_can_be_listed(): void
    { /* ... unchanged ... */
        $user1 = User::factory()->create(['email' => 'alice@example.com', 'name' => 'Alice']);
        $user2 = User::factory()->create(['email' => 'bob@example.com', 'name' => 'Bob']);
        $response = $this->get(route('users.index'));
        $response->assertStatus(200);
        $response->assertViewIs('users.index');
        $response->assertSee($user1->name);
        $response->assertSee($user1->email);
        $response->assertSee($user2->name);
        $response->assertSee($user2->email);
    }

    #[Test]
    public function a_user_can_be_viewed(): void
    { /* ... unchanged ... */
        $user = User::factory()->create(['name' => 'Charlie', 'surname' => 'Brown', 'email' => 'charlie.brown@example.com', 'phone' => '5556667777', 'country' => 'GBR', 'gender' => 'Male',]); // Use valid code GBR
        $response = $this->get(route('users.show', $user->id));
        $response->assertStatus(200);
        $response->assertViewIs('users.show');
        $response->assertViewHas('user', $user);
        $response->assertSee($user->name);
        $response->assertSee($user->surname);
        $response->assertSee($user->email);
        $response->assertSee($user->phone);
        $response->assertSee($user->country); // Assert code is shown
    }

    #[Test]
    public function a_user_edit_form_can_be_displayed(): void
    {
        $user = User::factory()->create();
        $response = $this->get(route('users.edit', $user->id));
        $response->assertStatus(200);
        $response->assertViewIs('users.edit');
        $response->assertViewHas('user', $user);
        $response->assertViewHas('countries', $this->countries); // Assert countries are passed
        $response->assertSee('Edit User');
        $response->assertSee($user->name);
    }

    #[Test]
    public function a_user_can_be_updated(): void
    {
        $user = User::factory()->create();
        $validCountryCode = Arr::random(array_keys($this->countries)); // Use valid code
        $updateData = [
            'name' => 'Updated Name',
            'surname' => 'Updated Surname',
            'email' => 'updated.email@example.com',
            'phone' => '9876543210',
            'country' => $validCountryCode, // <-- Use valid code
            'gender' => 'Female',
        ];
        $response = $this->put(route('users.update', $user->id), $updateData);
        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'country' => $validCountryCode // Assert correct country saved
        ]);
    }

    // Add test for invalid country on update later if desired

    #[Test]
    public function a_user_can_be_deleted(): void
    { /* ... unchanged ... */
        $user = User::factory()->create();
        $this->assertDatabaseCount('users', 1);
        $response = $this->delete(route('users.destroy', $user->id));
        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $this->assertDatabaseCount('users', 0);
    }
}
