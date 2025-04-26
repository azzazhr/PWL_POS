<?php

namespace App\Http\Controllers;
use App\Models\StokModel;
use App\Models\BarangModel;
use App\Models\KategoriModel;
use App\Models\UserModel;
use App\Models\SupplierModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Svg\Gradient\Stop;

class StokController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Stok Barang',
            'list' => ['Home', 'Stok']
        ];

        $page = (object) [
            'title' => 'Data Stok Barang yang Masuk'
        ];

        $activeMenu = 'stok';
        $kategori = KategoriModel::all();

        return view('stok.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'kategori' => $kategori,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $stok = StokModel::select('stok_id', 'barang_id','user_id', 'supplier_id', 'stok_tanggal', 'stok_jumlah')
            ->with(['barang', 'user', 'supplier', 'barang.kategori']);

        return DataTables::of($stok)
            ->addIndexColumn()
            ->addColumn('barang_nama', function ($stok) {
                return $stok->barang->barang_nama ?? '-';
            })
            ->addColumn('kategori_nama', function ($stok) {
                return $stok->barang->kategori->kategori_nama ?? '-'; 
            })
            ->addColumn('user_nama', function ($stok) {
                return $stok->user->nama ?? '-';
            })
            ->addColumn('supplier_nama', function ($stok) {
                return $stok->supplier->supplier_nama ?? '-';
            })
            ->addColumn('aksi', function ($stok) {
                $btn = '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id .
                    '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id .
                    '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id .
                    '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {   
        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();
        $barang = BarangModel::select('barang_id', 'barang_nama', 'kategori_id')->get();  
        $user = UserModel::select('user_id', 'nama')->get();
        $supplier = SupplierModel::select('supplier_id', 'supplier_nama')->get();

        // Buat objek stok kosong
        $stok = new StokModel();
        $stok->barang = new BarangModel(); // supaya tidak error saat akses $stok->barang->barang_nama

        return view('stok.create_ajax', compact('stok', 'kategori', 'barang', 'user', 'supplier'));
    }

    public function store_ajax(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'barang_id' => 'required|numeric|exists:m_barang,barang_id',
            'user_id' => 'required|numeric|exists:m_user,user_id',
            'supplier_id' => 'required|numeric|exists:m_supplier,supplier_id',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|numeric|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal!',
                'msgField' => $validator->errors()
            ]);
        }
        try {
        // Simpan data stok
        $stok = new StokModel();
        $stok->barang_id = $request->barang_id;
        $stok->user_id = $request->user_id;
        $stok->supplier_id = $request->supplier_id;
        $stok->stok_tanggal = $request->stok_tanggal;
        $stok->stok_jumlah = $request->stok_jumlah;

        $stok->save();

        return response()->json([
            'status' => true,
            'message' => 'Data stok berhasil ditambahkan.'
        ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function show_ajax(string $id)
    {
        $stok = StokModel::with(['barang.kategori', 'user', 'supplier'])->find($id);

        if (!$stok) {
            return response()->json([
                'status' => false,
                'message' => 'Data stok tidak ditemukan'
            ]);
        }

        return view('stok.show_ajax', [
            'stok' => $stok
        ]);
    }

    public function edit_ajax(string $id)
    {
        $stok = StokModel::with(['barang.kategori', 'user', 'supplier'])->find($id);

        if (!$stok) {
            return response()->json([
                'status' => false,
                'message' => 'Data stok tidak ditemukan.'
            ]);
        }

        $kategori = KategoriModel::all();

        $barang = BarangModel::select('barang_id', 'barang_nama')->get();
        $user = UserModel::select('user_id', 'nama')->get();
        $supplier = SupplierModel::select('supplier_id', 'supplier_nama')->get();

        // Kirim ke view stok.edit_ajax
        return view('stok.edit_ajax', [
            'stok' => $stok,
            'barang' => $barang,
            'user' => $user,
            'supplier' => $supplier,
            'kategori' => $kategori
        ]);
    }

    public function update_ajax(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'barang_id' => 'required|numeric',
            'kategori_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'supplier_id' => 'required|numeric',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors(),
            ]);
        }

        $stok = StokModel::find($id);
        if (!$stok) {
            return response()->json([
                'status' => false,
                'message' => 'Data stok tidak ditemukan',
            ]);
        }

        $stok->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data stok berhasil diperbarui',
        ]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $stok = StokModel::with(['barang.kategori', 'user', 'supplier'])->find($id);
            if ($stok) {
                try {
                    $stok->delete();
                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil dihapus'
                    ]);
                } catch (\Illuminate\Database\QueryException $e) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak dapat dihapus karena masih terkait dengan data lain'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $stok = StokModel::with(['barang.kategori', 'user', 'supplier'])->find($id);


        return view('stok.confirm_ajax', ['stok' => $stok]);
    }

    public function import()
    {
        return view('stok.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_stok' => ['required', 'mimes:xlsx', 'max:1024']
            ];
            // Validasi file
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_stok');

            $reader = IOFactory::createReader('Xlsx'); // load reader file excel
            $reader->setReadDataOnly(true); // hanya membaca data
            $spreadsheet = $reader->load($file->getRealPath()); // load file excel
            $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
            $data = $sheet->toArray(null, false, true, true); // ambil data excel

            $insert = [];
            if (count($data) > 1) { // jika data lebih dari 1 baris
                foreach ($data as $baris => $value) {
                    if ($baris > 1) { // baris ke 1 adalah header, maka lewati
                        $insert[] = [
                            'barang_id' => $value['A'], 
                            'user_id' => $value['B'],   
                            'supplier_id' => $value['C'], 
                            'stok_tanggal' => \Carbon\Carbon::parse($value['D'])->format('Y-m-d'), 
                            'stok_jumlah' => $value['E'], 
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
                // Jika ada data yang akan diinsert
                if (count($insert) > 0) {
                    StokModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Data stok berhasil diimpor'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimpor'
                ]);
            }
        }
        return redirect('/');
    }

    public function export_excel()
    {
        $stok = StokModel::with(['barang.kategori', 'user', 'supplier'])
            ->orderBy('stok_id', 'asc')
            ->get();

        // Load PhpSpreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header kolom Excel
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Barang');
        $sheet->setCellValue('C1', 'Nama Kategori');  
        $sheet->setCellValue('D1', 'Nama User');
        $sheet->setCellValue('E1', 'Nama Supplier');
        $sheet->setCellValue('F1', 'Tanggal Stok');
        $sheet->setCellValue('G1', 'Jumlah Stok');

        // Bold untuk header
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);

        // Isi data
        $no = 1;
        $baris = 2;
        foreach ($stok as $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->barang->barang_nama ?? '-');
            $sheet->setCellValue('C' . $baris, $value->barang->kategori->kategori_nama ?? '-');  // Nama Kategori
            $sheet->setCellValue('D' . $baris, $value->user->nama ?? '-');
            $sheet->setCellValue('E' . $baris, $value->supplier->supplier_nama ?? '-');
            $sheet->setCellValue('F' . $baris, \Carbon\Carbon::parse($value->stok_tanggal)->format('d-m-Y'));
            $sheet->setCellValue('G' . $baris, $value->stok_jumlah);
            $baris++;
            $no++;
        }

        // Auto size kolom A - G
        foreach (range('A', 'G') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Stok');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Stok ' . date('Y-m-d H-i-s') . '.xlsx';

        // Header untuk download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        $stok = StokModel::select('stok_id', 'barang_id', 'user_id', 'supplier_id', 'stok_tanggal', 'stok_jumlah')
            ->with('barang', 'user', 'supplier')  
            ->orderBy('stok_tanggal', 'desc')  
            ->get();

        // Load view untuk PDF dengan data stok
        $pdf = Pdf::loadView('stok.export_pdf', ['stok' => $stok]);
        $pdf->setPaper('a4', 'portrait'); 
        $pdf->setOption('isRemoteEnabled', true); 
        $pdf->render();
        
        // Render dan stream PDF ke browser
        return $pdf->stream('Data Stok ' . date('Y-m-d H:i:s') . '.pdf');
    }
}
