<?php

namespace Tests\Feature;

use App\Models\Form;
use App\Models\Ktp;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FormManagementTest extends TestCase
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

    public function test_can_create_form(): void
    {
        $user = $this->dummy_user();
        $response = $this->actingAs($user)->postJson('api/forms', [
            'nama' => 'John Doe',
            'NIK' => '1234567890',
            'alamat' => '123 Main St',
            'TTL' => 'Gresik, 1990-01-01',
            'tanggal_pengajuan' => now(),
            'kredit_id' => 1
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonStructure(['id', 'ktp_id', 'kredit_id', 'tanggal_pengajuan']);

        $this->assertDatabaseHas('forms', [
            'ktp_id' => $response->json('ktp_id'),
            'kredit_id' => $response->json('kredit_id'),
            'tanggal_pengajuan' => $response->json('tanggal_pengajuan')
        ]);
    }

    public function test_can_get_all_forms(): void
    {
        $this->dummy_forms(5);
        $user = $this->dummy_user();

        $response = $this->actingAs($user)->get('api/forms');

        $response
            ->assertStatus(200)
            ->assertJsonCount(5)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'ktp_id',
                    'kredit_id',
                    'tanggal_pengajuan'
                ]
            ]);
    }

    public function test_can_update_form(): void
    {
        $user = $this->dummy_user();
        $this->dummy_forms();

        $forms = Form::all();

        $form = $forms[0];

        $response = $this->actingAs($user)->putJson('api/forms/' . $form->id, [
            'kredit_id' => 1,
            'tanggal_pengajuan' => now(),
            'nama' => 'sasha',
            'NIK' => '11111111',
            'TTL' => 'Gresik, 1990-01-01',
            'alamat' => 'Jl. Raya'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('forms', [
            'id' => $form->id,
            'ktp_id' => 1,
            'kredit_id' => 1,
            'tanggal_pengajuan' => $response->json('tanggal_pengajuan')
        ]);

        $this->assertDatabaseHas('ktps', [
            'id' => $form->ktp->id,
            'nama' => 'sasha',
            'NIK' => '11111111',
            'alamat' => 'Jl. Raya',
            'TTL' => 'Gresik, 1990-01-01'
        ]);
    }

    public function test_cam_delete_form(): void
    {
        $user = $this->dummy_user();
        $this->dummy_forms();

        $forms = Form::all();

        $form = $forms[0];

        $response = $this->actingAs($user)->delete('api/forms/' . $form->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('forms', [
            'id' => $form->id
        ]);

        $this->assertDatabaseMissing('ktps', [
            'id' => $form->ktp_id
        ]);
    }
}
