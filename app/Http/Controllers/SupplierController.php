<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupplierModel;

class SupplierController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) ['title' => 'Supplier', 'list' => ['Home', 'Supplier']];
        $page = (object) ['title' => 'Daftar Supplier'];
        $activeMenu = 'supplier';

        $filter = (object)[
            'supplier_kode' => request()->supplier_kode
        ];

        return view('supplier.index', compact('breadcrumb', 'page', 'activeMenu', 'filter'));
    }

    public function list()
    {
        $query = SupplierModel::query();

        if (request()->supplier_kode) {
            $query->where('supplier_kode', request()->supplier_kode);
        }

        return datatables($query)->addColumn('aksi', function ($data) {
            $edit = url("supplier/$data->supplier_id/edit");
            $delete = url("supplier/$data->supplier_id");
            return "
                <a href='$edit' class='btn btn-sm btn-warning'>Edit</a>
                <form action='$delete' method='POST' style='display:inline-block'>
                    " . csrf_field() . method_field('DELETE') . "
                    <button class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin hapus?\")'>Hapus</button>
                </form>
            ";
        })->rawColumns(['aksi'])->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) ['title' => 'Tambah Supplier', 'list' => ['Home', 'Supplier', 'Tambah']];
        $page = (object) ['title' => 'Tambah Supplier Baru'];
        $activeMenu = 'supplier';

        return view('supplier.create', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_kode' => 'required|unique:m_supplier,supplier_kode',
            'supplier_nama' => 'required',
            'supplier_alamat' => 'required'
        ]);

        SupplierModel::create($request->all());
        return redirect('/supplier')->with('success', 'Data supplier berhasil disimpan');
    }

    public function edit($id)
    {
        $supplier = SupplierModel::findOrFail($id);
        $breadcrumb = (object) ['title' => 'Edit Supplier', 'list' => ['Home', 'Supplier', 'Edit']];
        $page = (object) ['title' => 'Edit Data Supplier'];
        $activeMenu = 'supplier';

        return view('supplier.edit', compact('breadcrumb', 'page', 'supplier', 'activeMenu'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'supplier_kode' => 'required|unique:m_supplier,supplier_kode,' . $id . ',supplier_id',
            'supplier_nama' => 'required',
            'supplier_alamat' => 'required'
        ]);

        SupplierModel::find($id)->update($request->all());
        return redirect('/supplier')->with('success', 'Data supplier berhasil diubah');
    }

    public function destroy($id)
    {
        SupplierModel::destroy($id);
        return redirect('/supplier')->with('success', 'Data supplier berhasil dihapus');
    }
}
