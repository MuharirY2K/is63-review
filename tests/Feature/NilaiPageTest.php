<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NilaiPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_nilai_page_renders_content(): void
    {
        $response = $this->get('/nilai');

        $response->assertStatus(200);
        $response->assertSee('Data Nilai');
    }
}
