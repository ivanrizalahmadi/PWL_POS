@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a href="{{ url('kategori/create') }}" class="btn btn-sm btn-primary">Tambah</a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

        {{-- Filter --}}
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Filter :</label>
                    <div class="col-3">
                        <select class="form-control form-control-sm" id="filter_kode">
                            <option value="">- Semua -</option>
                            @foreach($kodeKategori as $kode)
                                <option value="{{ $kode }}">{{ $kode }}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Filter berdasarkan Kode Kategori</small>
                    </div>
                </div>
            </div>
        </div>
        

        <table class="table table-bordered table-striped table-sm" id="table_kategori">
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
$(function() {
    let table = $('#table_kategori').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ url("kategori/list") }}',
            type: 'POST',
            data: function(d) {
                d.kategori_kode = $('#filter_kode').val();
                d._token = '{{ csrf_token() }}';
            }
        },
        columns: [
            { data: 'kategori_id', name: 'kategori_id' },
            { data: 'kategori_kode', name: 'kategori_kode' },
            { data: 'kategori_nama', name: 'kategori_nama' },
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
        ]
    });

    $('#filter_kode').on('change', function() {
        table.draw();
    });
});
</script>
@endpush

