<?php

namespace Tests\Feature;

use App\Models\Form;
use App\Models\Ktp;
use App\Models\Slik;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SlikManagementTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function dummy_user(): User
    {
        $user = User::find(1);
        return $user;
    }

    public function dummy_forms($qty = 1): void
    {
        for ($i = 0; $i < $qty; $i++) {
            Ktp::create([
                'nama' => fake()->name(),
                'NIK' => '1234567890',
                'alamat' => fake()->address(),
                'TTL' => 'Gresik, 1990-01-01'
            ]);
        }
        $ktps = Ktp::all();

        foreach ($ktps as $ktp) {
            Form::create([
                'ktp_id' => $ktp->id,
                'kredit_id' => 1,
                'tanggal_pengajuan' => now()
            ]);
        }
    }

    public function dummy_sliks($forms): void
    {
        foreach ($forms as $form) {
            Slik::create([
                'form_id' => $form->id,
                'category_id' => 1
            ]);
        }
    }

    public function test_can_create_form(): void
    {
        $user = $this->dummy_user();
        $this->dummy_forms();
        $response = $this->actingAs($user)->postJson('api/sliks', [
            'form_id' => 1,
            'category_id' => 1
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonStructure(['id', 'form_id', 'category_id']);

        $this->assertDatabaseHas('sliks', [
            'form_id' => $response->json('form_id'),
            'category_id' => $response->json('category_id')
        ]);
    }

    public function test_can_get_all_sliks(): void
    {
        $this->dummy_forms(5);
        $user = $this->dummy_user();

        $forms = Form::all();
        $this->dummy_sliks($forms);

        $response = $this->actingAs($user)->get('api/sliks');

        $response
            ->assertStatus(200)
            ->assertJsonCount(5)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'form_id',
                    'category_id'
                ]
            ]);
    }

    public function test_can_update_form(): void
    {
        $user = $this->dummy_user();
        $this->dummy_forms();

        $forms = Form::all();

        $this->dummy_sliks($forms);

        $sliks = Slik::all();

        $slik = $sliks[0];

        $response = $this->actingAs($user)->putJson('api/sliks/' . $slik->id, [
            'form_id' => $slik->form_id,
            'category_id' => 1
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('sliks', [
            'id' => $slik->id,
            'form_id' => $slik->form_id,
            'category_id' => $slik->category_id
        ]);
    }

    public function test_cam_delete_form(): void
    {
        $user = $this->dummy_user();
        $this->dummy_forms();

        $forms = Form::all();

        $this->dummy_sliks($forms);

        $sliks = Slik::all();

        $slik = $sliks[0];

        $response = $this->actingAs($user)->delete('api/sliks/' . $slik->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('sliks', [
            'id' => $slik->id
        ]);
    }
}
