<?php
namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb = (object) ['title' => 'Barang', 'list' => ['Home', 'Barang']];
        $page = (object) ['title' => 'Daftar Barang'];
        $activeMenu = 'barang';

        $kategori = KategoriModel::all();

        return view('barang.index', compact('breadcrumb', 'page', 'activeMenu', 'kategori'));
    }

    public function list(Request $request)
    {
        $barang = BarangModel::with('kategori');

        if ($request->kategori_id) {
            $barang->where('kategori_id', $request->kategori_id);
        }

        return datatables()->of($barang)
            ->addColumn('kategori_nama', fn($row) => $row->kategori->kategori_nama ?? '-')
            ->addColumn('aksi', function ($row) {
                $editUrl = url("barang/{$row->barang_id}/edit");
                $deleteForm = "<form method='POST' action='" . url("barang/{$row->barang_id}") . "' style='display:inline-block'>
                                " . csrf_field() . method_field('DELETE') . "
                                <button type='submit' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin?\")'>Hapus</button>
                            </form>";
                return "<a href='{$editUrl}' class='btn btn-warning btn-sm'>Edit</a> " . $deleteForm;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Barang',
            'list' => ['Home', 'Barang', 'Tambah']
        ];
        $page = (object)[
            'title' => 'Tambah Barang Baru'
        ];
        $activeMenu = 'barang';
        $kategori = KategoriModel::all();
    
        return view('barang.create', compact('breadcrumb', 'page', 'activeMenu', 'kategori'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'barang_kode' => 'required|unique:m_barang,barang_kode',
            'barang_nama' => 'required',
            'kategori_id' => 'required|exists:m_kategori,kategori_id',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
        ]);
    
        BarangModel::create($request->all());
    
        return redirect('/barang')->with('success', 'Barang berhasil ditambahkan');
    }
    

    public function edit($id)
    {
        $barang = BarangModel::findOrFail($id);
    
        $breadcrumb = (object)[
            'title' => 'Edit Barang',
            'list' => ['Home', 'Barang', 'Edit']
        ];
        $page = (object)[
            'title' => 'Form Edit Barang'
        ];
        $activeMenu = 'barang';
        $kategori = KategoriModel::all();
    
        return view('barang.edit', compact('barang', 'breadcrumb', 'page', 'activeMenu', 'kategori'));
    }
    

    public function update(Request $request, $id)
    {
        $request->validate([
            'barang_kode' => 'required|unique:m_barang,barang_kode,' . $id . ',barang_id',
            'barang_nama' => 'required',
            'kategori_id' => 'required|exists:m_kategori,kategori_id',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
        ]);
    
        BarangModel::findOrFail($id)->update($request->all());
    
        return redirect('/barang')->with('success', 'Barang berhasil diperbarui');
    }
    

    public function destroy($id)
    {
        try {
            BarangModel::destroy($id);
            return redirect('barang')->with('success', 'Data barang berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('barang')->with('error', 'Gagal menghapus data barang');
        }
    }
}
