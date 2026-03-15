<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\General;
use App\Models\Aktivitas_sales;
use App\Models\Master_unit_kerja;
use App\Models\SalesTargetBudget;
use App\Models\User;
use Illuminate\Http\Request;

class BudgetSalesController extends AdminCoreController
{
    /**
     * Halaman input Budget Sales (bukan laporan): pilih periode → form isian target & budget per sales.
     */
    public function index(Request $request)
    {
        $data['link_budget_sales'] = 'budget_sales';
        $data['unit_kerjas'] = Master_unit_kerja::orderBy('nama_unit_kerjas')->get();
        $data['bulan'] = (int) $request->get('bulan', date('n'));
        $data['tahun'] = (int) $request->get('tahun', date('Y'));
        $data['unit_kerjas_id'] = $request->get('unit_kerjas_id', '');

        if ($data['bulan'] < 1 || $data['bulan'] > 12) {
            $data['bulan'] = (int) date('n');
        }
        if ($data['tahun'] < 2000 || $data['tahun'] > 2100) {
            $data['tahun'] = (int) date('Y');
        }

        $period = sprintf('%04d-%02d', $data['tahun'], $data['bulan']);

        // Hanya user sales: punya aktivitas_sales ATAU sudah punya budget (sales_target_budgets)
        $salesUserIds = Aktivitas_sales::query()->distinct()->pluck('users_id')->toArray();
        $budgetUserIds = SalesTargetBudget::query()->distinct()->pluck('users_id')->toArray();
        $salesUserIds = array_values(array_unique(array_merge($salesUserIds, $budgetUserIds)));
        if (empty($salesUserIds)) {
            $users = collect();
        } else {
            $usersQuery = User::query()
                ->whereIn('users.id', $salesUserIds)
                ->leftJoin('master_unit_kerjas', 'users.unit_kerjas_id', '=', 'master_unit_kerjas.id_unit_kerjas')
                ->select('users.id', 'users.name', 'users.unit_kerjas_id', 'master_unit_kerjas.nama_unit_kerjas');

            if ($data['unit_kerjas_id'] !== '' && $data['unit_kerjas_id'] !== null) {
                $usersQuery->where('users.unit_kerjas_id', $data['unit_kerjas_id']);
            }

            $users = $usersQuery->orderBy('master_unit_kerjas.nama_unit_kerjas')->orderBy('users.name')->get();
        }

        $budgetsByUser = SalesTargetBudget::where('period', $period)
            ->get()
            ->keyBy('users_id');

        $data['users'] = $users;
        $data['budgetsByUser'] = $budgetsByUser;
        $data['period'] = $period;
        $data['period_label'] = General::ubahDBKeBulan($data['bulan']) . ' ' . $data['tahun'];

        return view('dashboard.budget_sales.index', $data);
    }

    /**
     * Simpan budget/target untuk periode yang dipilih.
     */
    public function simpan(Request $request)
    {
        $request->validate([
            'period' => 'required|string|size:7',
        ]);

        $period = $request->input('period');
        if (!preg_match('/^\d{4}-\d{2}$/', $period)) {
            return redirect(url('dashboard/budget_sales'))
                ->with('setelah_simpan', ['alert' => 'error', 'text' => 'Periode tidak valid.']);
        }

        $users = $request->input('users', []);
        $saved = 0;

        foreach ($users as $userId => $row) {
            $userId = (int) $userId;
            if ($userId <= 0) {
                continue;
            }

            $totalSalesTarget = General::ubahHargaKeDB($row['total_sales_target'] ?? 0);
            $roomRevTarget = General::ubahHargaKeDB($row['room_rev_target'] ?? 0);
            $fbRevTarget = General::ubahHargaKeDB($row['fb_rev_target'] ?? 0);
            $budgetW1 = General::ubahHargaKeDB($row['budget_w1'] ?? 0);
            $budgetW2 = General::ubahHargaKeDB($row['budget_w2'] ?? 0);
            $budgetW3 = General::ubahHargaKeDB($row['budget_w3'] ?? 0);
            $budgetW4 = General::ubahHargaKeDB($row['budget_w4'] ?? 0);

            SalesTargetBudget::updateOrCreate(
                [
                    'users_id' => $userId,
                    'period'   => $period,
                ],
                [
                    'total_sales_target' => (float) $totalSalesTarget,
                    'room_rev_target'    => (float) $roomRevTarget ?: null,
                    'fb_rev_target'     => (float) $fbRevTarget ?: null,
                    'budget_w1'         => (float) $budgetW1,
                    'budget_w2'         => (float) $budgetW2,
                    'budget_w3'         => (float) $budgetW3,
                    'budget_w4'         => (float) $budgetW4,
                ]
            );
            $saved++;
        }

        $params = [
            'bulan' => substr($period, 5, 2),
            'tahun' => substr($period, 0, 4),
        ];
        if ($request->filled('unit_kerjas_id')) {
            $params['unit_kerjas_id'] = $request->input('unit_kerjas_id');
        }

        return redirect(url('dashboard/budget_sales') . '?' . http_build_query($params))
            ->with('setelah_simpan', ['alert' => 'sukses', 'text' => 'Budget sales untuk ' . $period . ' berhasil disimpan.']);
    }
}
