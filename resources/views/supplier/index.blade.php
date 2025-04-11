@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a href="{{ url('supplier/create') }}" class="btn btn-primary btn-sm">Tambah</a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        <div class="row">
            <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-1 control-label">Filter :</label>
                    <div class="col-3">
                        <input type="text" class="form-control" id="filter_kode" placeholder="Cari Supplier Kode" value="{{ $filter->supplier_kode }}">
                        <small class="form-text text-muted">Supplier Kode</small>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-bordered table-sm" id="table_supplier">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Alamat</th>
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
    let table = $('#table_supplier').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ url("supplier/list") }}',
            type: 'POST',
            data: function(d) {
                d._token = '{{ csrf_token() }}';
                d.supplier_kode = $('#filter_kode').val();
            }
        },
        columns: [
            { data: 'supplier_id' },
            { data: 'supplier_kode' },
            { data: 'supplier_nama' },
            { data: 'supplier_alamat' },
            { data: 'aksi', orderable: false, searchable: false }
        ]
    });

    $('#filter_kode').on('keyup change', function() {
        table.ajax.reload();
    });
});
</script>
@endpush
