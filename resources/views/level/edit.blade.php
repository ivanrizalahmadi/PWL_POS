@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header"><h3 class="card-title">{{ $page->title }}</h3></div>
    <div class="card-body">
        <form action="{{ url('level/'.$level->level_id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="level_kode">Kode Level</label>
                <input type="text" name="level_kode" class="form-control" value="{{ $level->level_kode }}" required>
            </div>
            <div class="form-group">
                <label for="level_nama">Nama Level</label>
                <input type="text" name="level_nama" class="form-control" value="{{ $level->level_nama }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ url('level') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
