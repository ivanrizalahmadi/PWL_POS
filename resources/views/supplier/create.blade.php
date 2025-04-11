@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header"><h3 class="card-title">{{ $page->title }}</h3></div>
    <form action="{{ url('supplier') }}" method="post">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label>Kode Supplier</label>
                <input type="text" name="supplier_kode" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Nama Supplier</label>
                <input type="text" name="supplier_nama" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Alamat Supplier</label>
                <textarea name="supplier_alamat" class="form-control" required></textarea>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-success">Simpan</button>
            <a href="{{ url('supplier') }}" class="btn btn-danger">Batal</a>
        </div>
    </form>
</div>
@endsection
