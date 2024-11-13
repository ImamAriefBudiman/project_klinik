@extends('layouts.app_modern')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">DATA PENDAFTARAN PASIEN</div>
                <div class="card-body">
                    <a href="/pasien/create" class="btn btn-primary btn-sm">
                        Tambah Data
                    </a>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Tanggal Daftar</th>
                                <th>Poli</th>
                                <th>Keluhan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($daftar as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->pasien->nama }}</td>
                                    <td>{{ $item->pasien->jenis_kelamin }}</td>
                                    <td>{{ $item->tanggal_daftar }}</td>
                                    <td>{{ $item->poli->nama }}</td>
                                    <td>{{ $item->keluhan }}</td>
                                    <td>
                                        <a href="/daftar/{{ $item->id }}" class="btn btn-info btn-sm">Detail</a>
                                        <form action="/daftar/{{ $item->id }}" method="post" class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm ml-2"
                                                onclick="return confirm('Yakin ingin menghapus data?')">
                                                Hapus </button>
                                        </form>
                                    </td>
                                    {{-- sengaja dikosongkan --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection