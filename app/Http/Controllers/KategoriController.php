<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriModel;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) ['title' => 'Kategori', 'list' => ['Home', 'Kategori']];
        $page = (object) ['title' => 'Daftar Kategori'];
        $activeMenu = 'kategori';
    
        $kodeKategori = KategoriModel::select('kategori_kode')->distinct()->pluck('kategori_kode');
    
        return view('kategori.index', compact('breadcrumb', 'page', 'activeMenu', 'kodeKategori'));
    }
    

    public function list(Request $request)
    {
        $query = KategoriModel::query();
    
        if ($request->kategori_kode) {
            $query->where('kategori_kode', $request->kategori_kode);
        }
    
        return datatables()->of($query)
            ->addColumn('aksi', function ($kategori) {
                $editUrl = url('/kategori/' . $kategori->kategori_id . '/edit');
                $deleteUrl = url('/kategori/' . $kategori->kategori_id);
                $csrf = csrf_field();
                $method = method_field('DELETE');
    
                return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>
                    <form action="' . $deleteUrl . '" method="POST" style="display:inline-block;" onsubmit="return confirm(\'Yakin hapus data?\')">
                        ' . $csrf . $method . '
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
    
    
    

    public function create()
    {
        $breadcrumb = (object) ['title' => 'Tambah Kategori', 'list' => ['Home', 'Kategori', 'Tambah']];
        $page = (object) ['title' => 'Tambah Kategori Baru'];
        $activeMenu = 'kategori';

        return view('kategori.create', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_kode' => 'required|string|unique:m_kategori,kategori_kode',
            'kategori_nama' => 'required|string|max:100',
        ]);

        KategoriModel::create($request->all());
        return redirect('/kategori')->with('success', 'Data kategori berhasil disimpan');
    }

    public function edit(string $id)
    {
        $kategori = KategoriModel::find($id);
        $breadcrumb = (object) ['title' => 'Edit Kategori', 'list' => ['Home', 'Kategori', 'Edit']];
        $page = (object) ['title' => 'Edit Kategori'];
        $activeMenu = 'kategori';

        return view('kategori.edit', compact('breadcrumb', 'page', 'kategori', 'activeMenu'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'kategori_kode' => 'required|string|unique:m_kategori,kategori_kode,'.$id.',kategori_id',
            'kategori_nama' => 'required|string|max:100',
        ]);

        KategoriModel::find($id)->update($request->all());
        return redirect('/kategori')->with('success', 'Data kategori berhasil diubah');
    }

    public function destroy(string $id)
    {
        try {
            KategoriModel::destroy($id);
            return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/kategori')->with('error', 'Data kategori gagal dihapus karena terkait data lain');
        }
    }
}


