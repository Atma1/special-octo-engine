<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

/**
 * @group Nilai Getter
 *
 * APIs for getting nilai ST and RT
 */

class NilaiController extends Controller
{
    /**
     * Get Nilai RT
     *
     * @group Nilai
     * @responseField nama string The student's name
     * @responseField nilaiRT object The subject and score mapping
     * @responseField nisn string The student's NISN
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNilaiRT()
    {
        $rawData = DB::select("
            SELECT nama, nisn, skor, nama_pelajaran
            FROM nilai
            WHERE materi_uji_id = 7
            AND nama_pelajaran != 'Pelajaran Khusus'");

        $groupedData = collect($rawData)->groupBy('nama')->map(function ($items, $nama) {

            $nilaiRT = $items->pluck('skor', 'nama_pelajaran')->toArray();
            $nisn    = $items->first()->nisn;

            return [
                'nama'    => $nama,
                'nilaiRT' => $nilaiRT,
                'nisn'    => $nisn,
            ];
        })->values();

        return response()->json($groupedData);
    }

    /**
     * Get Nilai ST
     *
     * @group Nilai
     * @responseField listNilai object The subject and multiplied score mapping
     * @responseField nama string The student's name
     * @responseField nisn string The student's NISN
     * @responseField total float The total score (rounded)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNilaiST()
    {
        $rawData = DB::select("
            SELECT
                nama,
                nisn,
                nama_pelajaran,
                CASE
                    WHEN pelajaran_id = 44 THEN skor * 41.67
                    WHEN pelajaran_id = 45 THEN skor * 29.67
                    WHEN pelajaran_id = 46 THEN skor * 100
                    WHEN pelajaran_id = 47 THEN skor * 23.81
                    ELSE skor
                END as skor_multiplied
            FROM nilai
            WHERE materi_uji_id = 4");

        $groupedData = collect($rawData)->groupBy('nama')->map(function ($items, $nama) {
            $nisn = $items->first()->nisn;

            $listNilai = $items->pluck('skor_multiplied', 'nama_pelajaran')->toArray();

            $total = $items->sum('skor_multiplied');

            return [
                'listNilai' => $listNilai,
                'nama'      => $nama,
                'nisn'      => $nisn,
                'total'     => round($total, 2),
            ];
        })->sortByDesc('total')->values();

        return response()->json($groupedData);
    }
}
