<?php

namespace Tests\Feature;

use App\Models\compras;
use App\Models\inventario;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventariosTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_delete_inventario_with_compra_dependencies(): void
    {
        $admin = User::factory()->create([
            'rol' => 1,
            'password' => 'password',
        ]);

        $pieza = inventario::factory()->create();

        $compra = compras::create([
            'id_inventario' => $pieza->id_inventario,
            'precio_unitario' => 120.50,
            'cantidad_compra' => 2,
            'fecha' => now()->toDateString(),
            'lugar_compra' => 'Tienda de prueba',
        ]);

        $this->actingAs($admin)
            ->delete(route('inventarios.destroy', $pieza))
            ->assertRedirect(route('inventarios.index'))
            ->assertSessionHas('success', 'Registro eliminado del inventario.');

        $this->assertDatabaseHas('compras', [
            'id_compra' => $compra->id_compra,
            'id_inventario' => null,
        ]);

        $this->assertDatabaseMissing('inventarios', [
            'id_inventario' => $pieza->id_inventario,
        ]);
    }
}
