<?php

namespace Tests\Feature;

use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MahasiswaFotoUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_mahasiswa_create_with_foto(): void
    {
        Storage::fake('public');

        $prodi = Prodi::factory()->create();
        $fotoFile = UploadedFile::fake()->image('foto.jpg', 150, 150);

        $response = $this->post('/mahasiswa', [
            'nim' => '2023144895',
            'nama' => 'Test Mahasiswa',
            'email' => 'test@example.com',
            'prodi_id' => $prodi->id,
            'angkatan' => 2023,
            'status' => 'aktif',
            'alamat' => 'Jl. Test',
            'foto' => $fotoFile,
        ]);

        $response->assertRedirect(route('mahasiswa.index'));

        $mahasiswa = Mahasiswa::where('nim', '2023144895')->first();
        $this->assertNotNull($mahasiswa);
        $this->assertNotNull($mahasiswa->foto);
        Storage::disk('public')->assertExists($mahasiswa->foto);
    }

    public function test_mahasiswa_edit_with_new_foto_deletes_old(): void
    {
        Storage::fake('public');

        $prodi = Prodi::factory()->create();
        $mahasiswa = Mahasiswa::factory()->create(['prodi_id' => $prodi->id]);

        // Upload foto pertama
        $fotoLama = UploadedFile::fake()->image('foto-lama.jpg', 150, 150);
        $response = $this->put("/mahasiswa/{$mahasiswa->id}", [
            'nim' => $mahasiswa->nim,
            'nama' => $mahasiswa->nama,
            'email' => $mahasiswa->email,
            'prodi_id' => $mahasiswa->prodi_id,
            'angkatan' => $mahasiswa->angkatan,
            'status' => $mahasiswa->status,
            'alamat' => $mahasiswa->alamat,
            'foto' => $fotoLama,
        ]);

        $mahasiswa->refresh();
        $fotoLamaPath = $mahasiswa->foto;
        Storage::disk('public')->assertExists($fotoLamaPath);

        // Upload foto kedua (mengganti yang pertama)
        $fotoBaru = UploadedFile::fake()->image('foto-baru.jpg', 150, 150);
        $response = $this->put("/mahasiswa/{$mahasiswa->id}", [
            'nim' => $mahasiswa->nim,
            'nama' => $mahasiswa->nama,
            'email' => $mahasiswa->email,
            'prodi_id' => $mahasiswa->prodi_id,
            'angkatan' => $mahasiswa->angkatan,
            'status' => $mahasiswa->status,
            'alamat' => $mahasiswa->alamat,
            'foto' => $fotoBaru,
        ]);

        $response->assertRedirect(route('mahasiswa.index'));

        $mahasiswa->refresh();
        $fotoBaruPath = $mahasiswa->foto;

        // Foto lama harus dihapus
        Storage::disk('public')->assertMissing($fotoLamaPath);
        // Foto baru harus ada
        Storage::disk('public')->assertExists($fotoBaruPath);
        // Path harus berbeda
        $this->assertTrue($fotoLamaPath !== $fotoBaruPath);
    }

}
