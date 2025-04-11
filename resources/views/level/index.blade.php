@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a href="{{ url('level/create') }}" class="btn btn-sm btn-primary">Tambah</a>
        </div>
    </div>
    <div class="card-body">
        @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if (session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

        <div class="row mb-3">
            <div class="col-4">
                <input type="text" id="filter_kode" class="form-control" placeholder="Filter Kode" value="{{ $kode }}">
            </div>
            <div class="col-2">
                <button class="btn btn-sm btn-secondary" onclick="refreshTable()">Filter</button>
            </div>
        </div>

        <table class="table table-bordered table-sm" id="table_level">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('js')
<script>
function refreshTable() {
    $('#table_level').DataTable().ajax.reload();
}

$(function() {
    $('#table_level').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ url("level/list") }}',
            type: 'POST',
            data: function(d) {
                d._token = '{{ csrf_token() }}';
                d.kode = $('#filter_kode').val();
            }
        },
        columns: [
            { data: 'level_id', name: 'level_id' },
            { data: 'level_kode', name: 'level_kode' },
            { data: 'level_nama', name: 'level_nama' },
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
        ]
    });
});
</script>
@endpush
