<?php

namespace App\Exports;


use App\Model\WorkPermitInformation;
// use App\DateTime;

// use App\FactorItemList;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
Use \Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ReportSummary implements FromView, WithTitle, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;

    protected $date;
    protected $work_permit_per_dept_iss;
    protected $work_permit_per_dept_ess;
    protected $work_permit_per_dept_hrd;
    protected $work_permit_per_dept_fac;
    protected $work_permit_per_dept_ems;
    protected $work_permit_per_dept_log;
    protected $work_permit_per_dept_ts;
    protected $work_permit_per_dept_yf;
    protected $work_permit_per_dept_cn;
    protected $work_permit_per_dept_pps_ts;
    protected $work_permit_per_dept_pps_cn;
    protected $selected_month;




    function __construct($date,
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
    $selected_month
    )

    {
        $this->date = $date;
        $this->work_permit_per_dept_iss = $work_permit_per_dept_iss;
        $this->work_permit_per_dept_ess = $work_permit_per_dept_ess;
        $this->work_permit_per_dept_hrd = $work_permit_per_dept_hrd;
        $this->work_permit_per_dept_fac = $work_permit_per_dept_fac;
        $this->work_permit_per_dept_ems = $work_permit_per_dept_ems;
        $this->work_permit_per_dept_log = $work_permit_per_dept_log;
        $this->work_permit_per_dept_ts = $work_permit_per_dept_ts;
        $this->work_permit_per_dept_yf = $work_permit_per_dept_yf;
        $this->work_permit_per_dept_cn = $work_permit_per_dept_cn;
        $this->work_permit_per_dept_pps_ts = $work_permit_per_dept_pps_ts;
        $this->work_permit_per_dept_pps_cn = $work_permit_per_dept_pps_cn;
        $this->selected_month = $selected_month;




    }


    public function view(): View {
        return view('exports.export_summary', ['date' => $this->date, 'iss_count' => $this->work_permit_per_dept_iss]);
    }


    public function title(): string
    {
        return 'Summary';
    }


    // for designs
    public function registerEvents(): array
    {

        $work_permit_iss = $this->work_permit_per_dept_iss;
        $work_permit_ess = $this->work_permit_per_dept_ess;
        $work_permit_hrd = $this->work_permit_per_dept_hrd;
        $work_permit_fac = $this->work_permit_per_dept_fac;
        $work_permit_ems = $this->work_permit_per_dept_ems;
        $work_permit_log = $this->work_permit_per_dept_log;
        $work_permit_ts = $this->work_permit_per_dept_ts;
        $work_permit_yf = $this->work_permit_per_dept_yf;
        $work_permit_cn = $this->work_permit_per_dept_cn;
        $work_permit_pps_ts = $this->work_permit_per_dept_pps_ts;
        $work_permit_pps_cn = $this->work_permit_per_dept_pps_cn;
        $selected_month_export = $this->selected_month;

        $arial_font_12 = array(
            'font' => array(
                'name'      =>  'Arial',
                'size'      =>  12,
                // 'color'      =>  'red',
                // 'italic'      =>  true
            )
        );

        $hv_center = array(
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrap' => TRUE
            ]
        );

        $hlv_center = array(
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrap' => TRUE
            ]
        );

        $hrv_center = array(
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_RIGHT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ]
        );
        $styleBorderBottomThin= [
            'borders' => [
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $styleBorderAll = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        return [
            AfterSheet::class => function(AfterSheet $event) use (
                $arial_font_12,
                $hv_center,
                $hlv_center,
                $hrv_center,
                $styleBorderBottomThin,
                $styleBorderAll,
                $work_permit_iss,
                $work_permit_ess,
                $work_permit_hrd,
                $work_permit_fac,
                $work_permit_ems,
                $work_permit_log,
                $work_permit_ts,
                $work_permit_yf,
                $work_permit_cn,
                $work_permit_pps_ts,
                $work_permit_pps_cn,
                $selected_month_export
            )  {

                // $month = "";

                // if($selected_month_export == "06"){
                //     $month == "June";
                // }

                $monthNum  = $selected_month_export;
                $month_name = date("F", mktime(0, 0, 0, $monthNum, 10));

                $event->sheet->getColumnDimension('A')->setWidth(15);

                $event->sheet->getDelegate()->mergeCells('A1:E2');
                $event->sheet->setCellValue('A1',"Work Permit Summary for the month of {$month_name}");
                $event->sheet->getDelegate()->getStyle('A1')->applyFromArray($hv_center);
                $event->sheet->getDelegate()->getStyle('A1')->applyFromArray($arial_font_12);



                $event->sheet->setCellValue('A3',"ISS");
                $event->sheet->getDelegate()->mergeCells('B3:E3');
                $event->sheet->getDelegate()->getStyle('A3')->applyFromArray($hv_center);
                $event->sheet->getDelegate()->getStyle('A3')->applyFromArray($arial_font_12);
                $event->sheet->setCellValue('B3',count($work_permit_iss));
                $event->sheet->getDelegate()->getStyle('B3')->applyFromArray($hv_center);
                $event->sheet->getDelegate()->getStyle('B3')->applyFromArray($arial_font_12);



                $event->sheet->setCellValue('A4',"ESS");
                $event->sheet->getDelegate()->mergeCells('B4:E4');
                $event->sheet->getDelegate()->getStyle('A4')->applyFromArray($hv_center);
                $event->sheet->getDelegate()->getStyle('A4')->applyFromArray($arial_font_12);
                $event->sheet->setCellValue('B4',count($work_permit_ess));
                $event->sheet->getDelegate()->getStyle('B4')->applyFromArray($hv_center);
                $event->sheet->getDelegate()->getStyle('B4')->applyFromArray($arial_font_12);

                $event->sheet->setCellValue('A5',"HRD");
                $event->sheet->getDelegate()->mergeCells('B5:E5');
                $event->sheet->getDelegate()->getStyle('A5')->applyFromArray($hv_center);
                $event->sheet->getDelegate()->getStyle('A5')->applyFromArray($arial_font_12);
                $event->sheet->setCellValue('B5',count($work_permit_hrd));
                $event->sheet->getDelegate()->getStyle('B5')->applyFromArray($hv_center);
                $event->sheet->getDelegate()->getStyle('B5')->applyFromArray($arial_font_12);


                $event->sheet->setCellValue('A6',"FAC");
                $event->sheet->getDelegate()->mergeCells('B6:E6');
                $event->sheet->getDelegate()->getStyle('A6')->applyFromArray($hv_center);
                $event->sheet->getDelegate()->getStyle('A6')->applyFromArray($arial_font_12);
                $event->sheet->setCellValue('B6',count($work_permit_fac));
                $event->sheet->getDelegate()->getStyle('B6')->applyFromArray($hv_center);
                $event->sheet->getDelegate()->getStyle('B6')->applyFromArray($arial_font_12);

                $event->sheet->setCellValue('A7',"EMS");
                $event->sheet->getDelegate()->mergeCells('B7:E7');
                $event->sheet->getDelegate()->getStyle('A7')->applyFromArray($hv_center);
                $event->sheet->getDelegate()->getStyle('A7')->applyFromArray($arial_font_12);
                $event->sheet->setCellValue('B7',count($work_permit_ems));
                $event->sheet->getDelegate()->getStyle('B7')->applyFromArray($hv_center);
                $event->sheet->getDelegate()->getStyle('B7')->applyFromArray($arial_font_12);

                $event->sheet->setCellValue('A8',"LOG");
                $event->sheet->getDelegate()->mergeCells('B8:E8');
                $event->sheet->getDelegate()->getStyle('A8')->applyFromArray($hv_center);
                $event->sheet->getDelegate()->getStyle('A8')->applyFromArray($arial_font_12);
                $event->sheet->setCellValue('B8',count($work_permit_log));
                $event->sheet->getDelegate()->getStyle('B8')->applyFromArray($hv_center);
                $event->sheet->getDelegate()->getStyle('B8')->applyFromArray($arial_font_12);

                $event->sheet->setCellValue('A9',"TS");
                $event->sheet->getDelegate()->mergeCells('B9:E9');
                $event->sheet->getDelegate()->getStyle('A9')->applyFromArray($hv_center);
                $event->sheet->getDelegate()->getStyle('A9')->applyFromArray($arial_font_12);
                $event->sheet->setCellValue('B9',count($work_permit_ts));
                $event->sheet->getDelegate()->getStyle('B9')->applyFromArray($hv_center);
                $event->sheet->getDelegate()->getStyle('B9')->applyFromArray($arial_font_12);

                $event->sheet->setCellValue('A10',"YF");
                $event->sheet->getDelegate()->mergeCells('B10:E10');
                $event->sheet->getDelegate()->getStyle('A10')->applyFromArray($hv_center);
                $event->sheet->getDelegate()->getStyle('A10')->applyFromArray($arial_font_12);
                $event->sheet->setCellValue('B10',count($work_permit_yf));
                $event->sheet->getDelegate()->getStyle('B10')->applyFromArray($hv_center);
                $event->sheet->getDelegate()->getStyle('B10')->applyFromArray($arial_font_12);

                $event->sheet->setCellValue('A11',"CN");
                $event->sheet->getDelegate()->mergeCells('B11:E11');
                $event->sheet->getDelegate()->getStyle('A11')->applyFromArray($hv_center);
                $event->sheet->getDelegate()->getStyle('A11')->applyFromArray($arial_font_12);
                $event->sheet->setCellValue('B11',count($work_permit_cn));
                $event->sheet->getDelegate()->getStyle('B11')->applyFromArray($hv_center);
                $event->sheet->getDelegate()->getStyle('B11')->applyFromArray($arial_font_12);

                $event->sheet->setCellValue('A12',"PPS-TS");
                $event->sheet->getDelegate()->mergeCells('B12:E12');
                $event->sheet->getDelegate()->getStyle('A12')->applyFromArray($hv_center);
                $event->sheet->getDelegate()->getStyle('A12')->applyFromArray($arial_font_12);
                $event->sheet->setCellValue('B12',count($work_permit_pps_ts));
                $event->sheet->getDelegate()->getStyle('B12')->applyFromArray($hv_center);
                $event->sheet->getDelegate()->getStyle('B12')->applyFromArray($arial_font_12);

                $event->sheet->setCellValue('A13',"PPS-CN");
                $event->sheet->getDelegate()->mergeCells('B13:E13');
                $event->sheet->getDelegate()->getStyle('A13')->applyFromArray($hv_center);
                $event->sheet->getDelegate()->getStyle('A13')->applyFromArray($arial_font_12);
                $event->sheet->setCellValue('B13',count($work_permit_pps_cn));
                $event->sheet->getDelegate()->getStyle('B13')->applyFromArray($hv_center);
                $event->sheet->getDelegate()->getStyle('B13')->applyFromArray($arial_font_12);

                $event->sheet->setCellValue('A14',"Total");
                $event->sheet->getDelegate()->mergeCells('B14:E14');
                $event->sheet->getDelegate()->getStyle('A14')->applyFromArray($hv_center);
                $event->sheet->getDelegate()->getStyle('A14')->applyFromArray($arial_font_12);
                $event->sheet->setCellValue('B14',
                count($work_permit_iss)
                +count($work_permit_ess)
                +count($work_permit_hrd)
                +count($work_permit_fac)
                +count($work_permit_ems)
                +count($work_permit_log)
                +count($work_permit_ts)
                +count($work_permit_yf)
                +count($work_permit_cn)
                +count($work_permit_pps_ts)
                +count($work_permit_pps_cn)
                );
                $event->sheet->getDelegate()->getStyle('B14')->applyFromArray($hv_center);
                $event->sheet->getDelegate()->getStyle('B14')->applyFromArray($arial_font_12);

            $event->sheet->getDelegate()->getStyle('A1:E2')->applyFromArray($styleBorderAll);
            $event->sheet->getDelegate()->getStyle('A3:E14')->applyFromArray($styleBorderAll);
            //  $event->sheet->getDelegate()->getColumnDimension('C')->setVisible(false);
            //  $event->sheet->getDelegate()->getRowDimension('5')->setVisible(false);


            },
        ];
    }
}
