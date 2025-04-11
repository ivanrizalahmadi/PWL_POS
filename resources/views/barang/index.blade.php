@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a href="{{ url('barang/create') }}" class="btn btn-sm btn-primary">Tambah</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-3">
                <select class="form-control" id="filter_kategori">
                    <option value="">- Semua Kategori -</option>
                    @foreach ($kategori as $item)
                        <option value="{{ $item->kategori_id }}">{{ $item->kategori_nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

        <table class="table table-bordered table-striped table-sm" id="table_barang">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('js')
<script>
$(function() {
    let table = $('#table_barang').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ url("barang/list") }}',
            data: function(d) {
                d.kategori_id = $('#filter_kategori').val()
            }
        },
        columns: [
            { data: 'barang_id', name: 'barang_id' },
            { data: 'barang_kode', name: 'barang_kode' },
            { data: 'barang_nama', name: 'barang_nama' },
            { data: 'kategori_nama', name: 'kategori_nama' },
            { data: 'harga_beli', name: 'harga_beli' },
            { data: 'harga_jual', name: 'harga_jual' },
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false },
        ]
    });

    $('#filter_kategori').change(function() {
        table.ajax.reload();
    });
});
</script>
@endpush
