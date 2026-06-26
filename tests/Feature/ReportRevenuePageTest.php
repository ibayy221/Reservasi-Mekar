<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportRevenuePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_revenue_report_page_is_accessible_for_admin(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($user)->get('/admin/reports/revenue');

        $response->assertStatus(200);
        $response->assertSee('Laporan Pendapatan');
    }
}
