<?php

namespace Tests\Feature;

use App\Models\Mahasiswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FotoDebugTest extends TestCase
{
    use RefreshDatabase;

    public function test_debug_foto_path(): void
    {
        // Create test data
        $mahasiswa = Mahasiswa::factory()->create([
            'foto' => 'foto-mahasiswa/test.jpg'
        ]);

        $storagePath = storage_path('app/public/' . $mahasiswa->foto);
        $publicUrl = asset('storage/' . $mahasiswa->foto);

        echo "\n=== FOTO DEBUG ===\n";
        echo "Mahasiswa: {$mahasiswa->nama}\n";
        echo "  DB path: {$mahasiswa->foto}\n";
        echo "  Storage full path: {$storagePath}\n";
        echo "  Public URL: {$publicUrl}\n";
        echo "  File exists: " . (file_exists($storagePath) ? 'YES' : 'NO') . "\n";

        $this->assertTrue(true);
    }
}
