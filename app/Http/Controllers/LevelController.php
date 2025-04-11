<?php
// app/Http/Controllers/LevelController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LevelModel;
use Yajra\DataTables\Facades\DataTables;

class LevelController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb = (object)[
            'title' => 'Level Pengguna',
            'list' => ['Home', 'Level']
        ];
        $page = (object)[
            'title' => 'Daftar Level Pengguna'
        ];
        $activeMenu = 'level';
        $kode = $request->kode;

        return view('level.index', compact('breadcrumb', 'page', 'activeMenu', 'kode'));
    }

    public function list(Request $request)
    {
        $query = LevelModel::query();

        if ($request->kode) {
            $query->where('level_kode', 'like', '%' . $request->kode . '%');
        }

        return DataTables::of($query)
            ->addColumn('aksi', function ($level) {
                $editUrl = url("/level/$level->level_id/edit");
                $deleteUrl = url("/level/$level->level_id");
                return '
                    <a href="'.$editUrl.'" class="btn btn-sm btn-warning">Edit</a>
                    <form method="POST" action="'.$deleteUrl.'" style="display:inline">
                        '.csrf_field().method_field('DELETE').'
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Hapus data ini?\')">Hapus</button>
                    </form>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Level',
            'list' => ['Home', 'Level', 'Tambah']
        ];
        $page = (object)[
            'title' => 'Form Tambah Level'
        ];
        $activeMenu = 'level';

        return view('level.create', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'level_kode' => 'required|unique:m_level,level_kode',
            'level_nama' => 'required'
        ]);

        LevelModel::create($request->all());

        return redirect('/level')->with('success', 'Data level berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $level = LevelModel::findOrFail($id);

        $breadcrumb = (object)[
            'title' => 'Edit Level',
            'list' => ['Home', 'Level', 'Edit']
        ];
        $page = (object)[
            'title' => 'Form Edit Level'
        ];
        $activeMenu = 'level';

        return view('level.edit', compact('level', 'breadcrumb', 'page', 'activeMenu'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'level_kode' => 'required|unique:m_level,level_kode,'.$id.',level_id',
            'level_nama' => 'required'
        ]);

        LevelModel::findOrFail($id)->update($request->all());

        return redirect('/level')->with('success', 'Data level berhasil diubah');
    }

    public function destroy(string $id)
    {
        try {
            LevelModel::destroy($id);
            return redirect('/level')->with('success', 'Data level berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/level')->with('error', 'Data gagal dihapus karena masih digunakan.');
        }
    }
}

