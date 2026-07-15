<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\choferes;
use App\Models\bitacora;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BitacoraTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_manage_bitacoras(): void
    {
        $user = User::factory()->create([
            'email' => 'chofer@siges.test',
            'rol' => 3,
            'password' => 'password',
        ]);

        $chofer = choferes::create([
            'id_usuario' => $user->id,
            'unidad_asignada' => null,
            'identificacion' => 'ID-001',
        ]);

        $this->actingAs($user)
            ->get(route('bitacoras.index'))
            ->assertOk()
            ->assertSee('Registro de actividad');

        $this->actingAs($user)
            ->post(route('bitacoras.store'), [
                'id_chofer' => $chofer->id_chofer,
                'fecha_hora' => '2026-07-12T10:30',
                'locacion' => 'Centro',
            ])
            ->assertRedirect(route('bitacoras.index'));

        $bitacora = bitacora::firstOrFail();

        $this->actingAs($user)
            ->put(route('bitacoras.update', $bitacora), [
                'id_chofer' => $chofer->id_chofer,
                'fecha_hora' => '2026-07-12T11:00',
                'locacion' => 'Terminal',
            ])
            ->assertRedirect(route('bitacoras.index'));

        $bitacora->refresh();

        $this->assertSame('Terminal', $bitacora->locacion);
        $this->assertSame('2026-07-12 11:00', $bitacora->fecha_hora->format('Y-m-d H:i'));

        $this->actingAs($user)
            ->delete(route('bitacoras.destroy', $bitacora))
            ->assertRedirect(route('bitacoras.index'));

        $this->assertDatabaseMissing('bitacoras', [
            'id_bitacora' => $bitacora->id_bitacora,
        ]);
    }
}