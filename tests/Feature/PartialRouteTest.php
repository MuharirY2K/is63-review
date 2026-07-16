<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PartialRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_required_menu_routes_are_registered(): void
    {
        $this->assertTrue(route('dashboard') !== null);
        $this->assertTrue(route('prodi.index') !== null);
        $this->assertTrue(route('mahasiswa.index') !== null);
        $this->assertTrue(route('nilai.index') !== null);
    }
}
