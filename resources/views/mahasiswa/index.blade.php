{{-- resources/views/mahasiswa/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Data Mahasiswa')
@section('page-title', 'Data Mahasiswa')

@section('page-action')
    <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary btn-sm shadow-sm">
        <i class="fas fa-plus fa-sm mr-1"></i> Tambah Mahasiswa
    </a>
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-users mr-2"></i>Daftar Mahasiswa
            </h6>
        </div>

        <div class="card-body">
            {{-- Form Filter --}}
            <form method="GET" class="row g-3 mb-3" action="{{ route('mahasiswa.index') }}">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama atau NIM" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="">-- Semua Status --</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="cuti" {{ request('status') == 'cuti' ? 'selected' : '' }}>Cuti</option>
                        <option value="lulus" {{ request('status') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                        <option value="dropout" {{ request('status') == 'dropout' ? 'selected' : '' }}>Dropout</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="prodi_id" class="form-control">
                        <option value="">-- Semua Prodi --</option>
                        @foreach($prodis as $prodi)
                            <option value="{{ $prodi->id }}" {{ request('prodi_id') == $prodi->id ? 'selected' : '' }}>
                                {{ $prodi->nama_prodi }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-block">Filter</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th width="70">No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Prodi</th>
                            <th>Angkatan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mahasiswas as $mahasiswa)
                            <tr>
                                <td class="text-center font-weight-bold">
                                    {{ $mahasiswas->firstItem() + $loop->index }}
                                </td>
                                <td>{{ $mahasiswa->nim }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($mahasiswa->foto)
                                            <img src="{{ asset('storage/' . $mahasiswa->foto) }}"
                                                 class="rounded-circle border border-primary shadow-sm mr-2"
                                                 style="width:36px;height:36px;object-fit:cover;"
                                                 onerror="this.onerror=null;this.src='{{ asset('vendor/startbootstrap-sb-admin-2/img/undraw_profile.svg') }}';">
                                        @else
                                            <div class="rounded-circle bg-gradient-primary d-inline-flex align-items-center justify-content-center border border-primary shadow-sm mr-2"
                                                 style="width:36px;height:36px;font-size:13px;font-weight:700;color:white;">
                                                {{ strtoupper(substr($mahasiswa->nama, 0, 1)) }}
                                            </div>
                                        @endif
                                        <span>{{ $mahasiswa->nama }}</span>
                                    </div>
                                </td>
                                <td>{{ $mahasiswa->prodi->nama_prodi ?? '-' }}</td>
                                <td>{{ $mahasiswa->angkatan }}</td>
                                <td>
                                    <span class="badge badge-{{ $mahasiswa->statusLabel }}">
                                        {{ ucfirst($mahasiswa->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('mahasiswa.show', $mahasiswa) }}" class="btn btn-info btn-sm" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('mahasiswa.edit', $mahasiswa) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('mahasiswa.destroy', $mahasiswa) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Apakah yakin menghapus data ini?');" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Belum ada data mahasiswa.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">
                    Menampilkan {{ $mahasiswas->firstItem() }}–{{ $mahasiswas->lastItem() }} dari {{ $mahasiswas->total() }} data
                </small>
                {{ $mahasiswas->links() }}
            </div>
        </div>
    </div>
@endsection
