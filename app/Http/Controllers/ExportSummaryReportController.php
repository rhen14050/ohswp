<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportSummary;

use App\WorkPermitInformation;



class ExportSummaryReportController extends Controller
{
    public function export_summary(Request $request, $year_id, $selected_month)
    {
        $year_month = $year_id.'-'.$selected_month;
        // return $year_month;

    $work_permit_per_dept_iss = WorkPermitInformation::where('division', 'ISS')
    ->where('created_at', 'LIKE','%'.$year_month.'%')
    ->get();
    $work_permit_per_dept_ess = WorkPermitInformation::where('division', 'ESS')
    ->where('created_at', 'LIKE','%'.$year_month.'%')
    ->get();
    $work_permit_per_dept_hrd = WorkPermitInformation::where('division', 'HRD')
    ->where('created_at', 'LIKE','%'.$year_month.'%')
    ->get();
    $work_permit_per_dept_fac = WorkPermitInformation::where('division', 'FAC')
    ->where('created_at', 'LIKE','%'.$year_month.'%')
    ->get();

    $work_permit_per_dept_ems = WorkPermitInformation::where('division', 'EMS')
    ->where('created_at', 'LIKE','%'.$year_month.'%')
    ->get();
    $work_permit_per_dept_log = WorkPermitInformation::where('division', 'LOG')
    ->where('created_at', 'LIKE','%'.$year_month.'%')
    ->get();
    $work_permit_per_dept_ts = WorkPermitInformation::where('division', 'TS')
    ->where('created_at', 'LIKE','%'.$year_month.'%')
    ->get();
    $work_permit_per_dept_yf = WorkPermitInformation::where('division', 'YF')
    ->where('created_at', 'LIKE','%'.$year_month.'%')
    ->get();
    $work_permit_per_dept_cn = WorkPermitInformation::where('division', 'CN')
    ->where('created_at', 'LIKE','%'.$year_month.'%')
    ->get();
    $work_permit_per_dept_pps_ts = WorkPermitInformation::where('division', 'PPS-TS')
    ->where('created_at', 'LIKE','%'.$year_month.'%')
    ->get();
    $work_permit_per_dept_pps_cn = WorkPermitInformation::where('division', 'PPS-CN')
    ->where('created_at', 'LIKE','%'.$year_month.'%')
    ->get();

    // return $work_permit_per_dept_iss;



        $date = date('Ymd',strtotime(NOW()));
        // return $date;
        return Excel::download(new ReportSummary(
            $date,
            $work_permit_per_dept_iss,
            $work_permit_per_dept_ess,
            $work_permit_per_dept_hrd,
            $work_permit_per_dept_fac,
            $work_permit_per_dept_ems,
            $work_permit_per_dept_log,
            $work_permit_per_dept_ts,
            $work_permit_per_dept_yf,
            $work_permit_per_dept_cn,
            $work_permit_per_dept_pps_ts,
            $work_permit_per_dept_pps_cn,
            $selected_month,

    ), 'Summary - '.$date.'.xlsx');
    }
}
