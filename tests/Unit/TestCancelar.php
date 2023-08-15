<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Ventafecha;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class VentafechaTest extends TestCase
{
    public function testActualizarEntregado()
    {
        // Crea una instancia de Ventafecha o utiliza datos de prueba existentes
        $ventafecha = Ventafecha::create([
            // Rellenar los campos necesarios para tu prueba
        ]);

        // Simula una solicitud para actualizar el estado
        $response = $this->post(route('venta.actualizar_entregado'), [
            'ventaf_id' => $ventafecha->id,
            'entregado' => true, // O false, según lo que quieras probar
            'envio' => false, // O true, según lo que quieras probar
            'cancelar' => true, // O false, según lo que quieras probar
            // Otros campos necesarios para la solicitud
        ]);

        // Verifica que la respuesta sea exitosa y tenga la estructura esperada
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        // Opcionalmente, verifica los cambios en la base de datos según tus expectativas
        $this->assertTrue(Ventafecha::find($ventafecha->id)->entregado);
        // Realiza más verificaciones según tus necesidades
    }
}