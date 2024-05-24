<?php

namespace App\Exports;

use App\Model\WorkPermitInformation;
use App\Model\Contractor;
use App\Model\ApproverEmailRecipient;
use App\Model\Worker;
use App\Model\OhsRequirements;
use App\Model\Tools;
use App\Model\ContractorContactPerson;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
Use \Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Style\Alignment;




class UsersExports implements  FromView, WithTitle, WithEvents, WithDrawings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;
    protected $date;
    protected $workpermit_soic;
    protected $get_ohs_requirements;
    protected $get_worker;
    protected $get_tools;
    protected $get_approver;
    protected $e_signature;


    //
    function __construct($date,$workpermit_soic,$get_ohs_requirements,$get_worker,$get_tools,$get_approver,$e_signature)
    {
        $this->date = $date;
        $this->workpermit_soic = $workpermit_soic;
        $this->get_ohs_requirements = $get_ohs_requirements;
        $this->get_worker = $get_worker;
        $this->get_tools = $get_tools;
        $this->get_approver = $get_approver;
        $this->e_signature = $e_signature;


    }

        public function view(): View {
                return view('exports.inventory', ['date' => $this->date,'workpermit_soic' => $this->workpermit_soic, 'get_ohs_requirements' => $this->get_ohs_requirements, 'get_worker' =>$this->get_worker, 'get_tools' => $this->get_tools, 'get_approver' => $this->get_approver, 'e_signature' => $this->e_signature]);
        }

        public function title(): string
        {
            return 'OHS WORK PERMIT';
        }

        //for designs
        public function registerEvents(): array
        {

            $get_worker_style = $this->get_worker;
            $get_tools_style = $this->get_tools;
            $work_permit = $this->workpermit_soic;


            $style1 = array(
                'font' => array(
                    'name'      =>  'Arial',
                    'size'      =>  14,
                    // 'color'      =>  'red',
                    // 'italic'      =>  true
                )
            );

            $stylex = array(
                'font' => array(
                    'name'      =>  'Arial',
                    'size'      =>  12,
                    // 'color'      =>  'red',
                    // 'italic'      =>  true
                )
            );

            $style2 = array(
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ]
            );

            $style3 = array(
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ]
            );

            $style4 = array(
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

            $styleBorderOutside = [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000']

                    ],
                ]
            ];

            $styleBorderRightThin= [
                'borders' => [
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ];
            $styleBorderLeftThin= [
                'borders' => [
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    ],
                ],
            ];

            $style5 = array(
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,

                    // 'vertical' => Alignment::VERTICAL_CENTER,
                ]
            );

            return [
                AfterSheet::class => function(AfterSheet $event) use ($styleBorderOutside,$style1,$style2,$style3, $style4,$styleBorderBottomThin,$styleBorderAll,$styleBorderRightThin,$styleBorderLeftThin,$get_worker_style,$get_tools_style,$style5,$stylex,$work_permit)  {

                    // $sheet->setpaperSize(1);
                    $event->sheet->getPageSetup()->setFitToPage(true);
                    $event->sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
                    $event->sheet->getDelegate()->getStyle('A6')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    // ->setARGB('DD4B39');
                    ->setARGB('#000000');


                    $event->sheet->getDelegate()->getStyle('A6')
                    ->getFont()
                    ->getColor()
                    ->setARGB('FFFFFF');

                    $event->sheet->getDelegate()->getStyle('A12')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    // ->setARGB('DD4B39');
                    ->setARGB('#000000');


                    $event->sheet->getDelegate()->getStyle('A12')
                    ->getFont()
                    ->getColor()
                    ->setARGB('FFFFFF');

                    $event->sheet->getDelegate()->getStyle('A38')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    // ->setARGB('DD4B39');
                    ->setARGB('#000000');


                    $event->sheet->getDelegate()->getStyle('A38')
                    ->getFont()
                    ->getColor()
                    ->setARGB('FFFFFF');

                    // $exploded_worker_name = explode(', ',  $get_worker_style->name);
                    // $event->sheet->getColumnDimension('39')->setWidth(20);
                // $event->sheet->getDelegate()->getRowDimension('39')->setRowHeight(50);


                    $a = 39;
                    $p = $a;

                    for($q = 0; $q < count($get_worker_style); $q++){

                        $a++;

                    }

                    $result_1 = 'A'.$p.':W'.$a;

                    // dd($result_1);

                    if (count($get_tools_style) >= 3){
                        $b = $a+2;

                        }elseif (count($get_tools_style) == 2)
                        {
                            $b = $a+3;
                        }else{
                            $b = $a+4;

                        }
                        $l = $a+6;

                        for($w = 0; $w < count($get_tools_style); $w++){
                            $b++;
                            $l++;
                        }

                    $c = $b+5;
                    $k = $b+4;
                    $t = $b+5;
                    $d = $c+5;
                    $e = $d+5;
                    $u = $d+9;
                    $result_2 = 'S'.$l.':W'.$k;
                    $result_3 = 'S'.$a.':W'.$u;
                    $result_4 = 'A'.$u.':W'.$u;
                    $result_5 = 'S'.$t.':W'.$t;
                    $result_6 = $t;

                    // $try_result = 'A'
                    // $font_x = $c - 1;

                    $font_name_tools = 'A38'.':V'.$u;

                    // dd($b);

                    // $count = count($exploded_worker_name);

                    // $event->sheet->setCellValue('O46', $this->return_whse_receive_num($rapid_shipment_records1[$i]['ControlNumber'],$packingListProductLine));
                    // $event->sheet->setCellValue('O46', "&#9744;" );


                    $event->sheet->getDelegate()->getStyle('A'.intval($a+1))
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    // ->setARGB('DD4B39');
                    ->setARGB('#000000');

                    // dd('A'.intval($a+1));

                    $event->sheet->getDelegate()->getStyle('A'.intval($a+1))
                    ->getFont()
                    ->getColor()
                    ->setARGB('FFFFFF');

                    $event->sheet->getDelegate()->getStyle('Q'.intval($a+1))
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    // ->setARGB('DD4B39');
                    ->setARGB('#000000');

                    //  dd('A'.intval($a+1));

                    $event->sheet->getDelegate()->getStyle('Q'.intval($a+1))
                    ->getFont()
                    ->getColor()
                    ->setARGB('FFFFFF');

                    $event->sheet->getDelegate()->getStyle('A'.intval($b+1))
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    // ->setARGB('DD4B39');
                    ->setARGB('#000000');

                    // dd('A'.intval($b+1));

                    $event->sheet->getDelegate()->getStyle('A'.intval($b+1))
                    ->getFont()
                    ->getColor()
                    ->setARGB('FFFFFF');

                    $event->sheet->getDelegate()->getStyle('A'.intval($c+1))
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    // ->setARGB('DD4B39');
                    ->setARGB('#000000');


                    $event->sheet->getDelegate()->getStyle('A'.intval($c+1))
                    ->getFont()
                    ->getColor()
                    ->setARGB('FFFFFF');

                    $event->sheet->getDelegate()->getStyle('A'.intval($d+1))
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    // ->setARGB('DD4B39');
                    ->setARGB('#000000');


                    $event->sheet->getDelegate()->getStyle('A'.intval($d+1))
                    ->getFont()
                    ->getColor()
                    ->setARGB('FFFFFF');

                    $event->sheet->getDelegate()->getStyle('A'.intval($e))
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    // ->setARGB('DD4B39');
                    ->setARGB('#000000');


                    $event->sheet->getDelegate()->getStyle('A'.intval($e))
                    ->getFont()
                    ->getColor()
                    ->setARGB('FFFFFF');

                    $event->sheet->getDelegate()->getStyle('A3:W3')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('S1:W1')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('S2:W2')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A4:W4')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A5:W5')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A6:W6')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A7:W7')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A8:W8')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A9:W9')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A10:W10')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A11:W11')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A12:W12')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A13:W13')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A14:W14')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A15:W15')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A16:W16')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A17:W17')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A18:W18')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A19:W19')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A20:W20')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A21:W21')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A22:W22')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A23:W23')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A24:W24')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A25:W25')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A26:W26')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A27:W27')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A28:W28')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A29:W29')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A30:W30')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A31:W31')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A32:W32')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A33:W33')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A34:W34')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A35:W35')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A36:W36')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A37:W37')->applyFromArray($stylex);
                    $event->sheet->getDelegate()->getStyle('A39')->applyFromArray($style2);
                    $event->sheet->getDelegate()->getStyle('B39:G39')->applyFromArray($style2);
                    $event->sheet->getDelegate()->getStyle('H39:I39')->applyFromArray($style2);
                    $event->sheet->getDelegate()->getStyle('S39:W39')->applyFromArray($style2);
                    $event->sheet->getDelegate()->getStyle((string)$font_name_tools)->applyFromArray($stylex);
                    // $event->sheet->getDelegate()->getStyle((string)$font_name_tools)->applyFromArray($style2);
                    // $event->sheet->getDelegate()->getStyle((string)$result_5)->applyFromArray($stylex);
                    // $event->sheet->getDelegate()->getStyle((string)$result_D)->applyFromArray($styleBorderBottomThin);





                    $event->sheet->getDelegate()->getStyle('I1')->getFont()->setSize(55);
                    $event->sheet->getDelegate()->getStyle('A40')->getAlignment()->setWrapText(true);
                    $event->sheet->getDelegate()->getStyle('A40')->getAlignment()->setWrapText(true);
                    $event->sheet->getDelegate()->getStyle('B39:F39')->getAlignment()->setWrapText(true);
                    $event->sheet->getDelegate()->getStyle('B40:F40')->getAlignment()->setWrapText(true);
                    $event->sheet->getDelegate()->getStyle('G39:I39')->getAlignment()->setWrapText(true);
                    $event->sheet->getDelegate()->getStyle('G40:I40')->getAlignment()->setWrapText(true);
                    $event->sheet->getDelegate()->getStyle('J39:M39')->getAlignment()->setWrapText(true);
                    $event->sheet->getDelegate()->getStyle('N39:R39')->getAlignment()->setWrapText(true);
                    $event->sheet->getDelegate()->getStyle('R39:W39')->getAlignment()->setWrapText(true);
                    $event->sheet->getDelegate()->getStyle('J40:M40')->getAlignment()->setWrapText(true);
                    $event->sheet->getDelegate()->getStyle('N40:R40')->getAlignment()->setWrapText(true);
                    $event->sheet->getDelegate()->getStyle('S40:W40')->getAlignment()->setWrapText(true);

                    $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(40);
                    $event->sheet->getDelegate()->getRowDimension('2')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('3')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('4')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('6')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('7')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('8')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('9')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('10')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('11')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('12')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('13')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('14')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('15')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('16')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('17')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('18')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('19')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('20')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('21')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('22')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('23')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('24')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('25')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('26')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('27')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('28')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('29')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('30')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('31')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('32')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('33')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('34')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('35')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('36')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('37')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('38')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('39')->setRowHeight(40);
                    $event->sheet->getDelegate()->getRowDimension('40')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('41')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('42')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('43')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('44')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('45')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('46')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('47')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('48')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('49')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('50')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('51')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('52')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('53')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('54')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('55')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('56')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('57')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('58')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('59')->setRowHeight(20);
                    // $event->sheet->getDelegate()->getRowDimension('60')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('61')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('62')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('63')->setRowHeight(20);
                    // $event->sheet->getDelegate()->getRowDimension('64')->setRowHeight(20);
                    $event->sheet->getDelegate()->getRowDimension('65')->setRowHeight(20);



                    $event->sheet->getColumnDimension('A')->setWidth(4);
                    $event->sheet->getColumnDimension('B')->setWidth(3);
                    $event->sheet->getColumnDimension('C')->setWidth(3);
                    $event->sheet->getColumnDimension('D')->setWidth(3);
                    // $event->sheet->getColumnDimension('A3:W3')->setWidth(3);

                    $event->sheet->getDelegate()->getStyle('A4')->applyFromArray($style3);
                    $event->sheet->getDelegate()->getStyle('G4')->applyFromArray($style3);
                    $event->sheet->getDelegate()->getStyle('K4')->applyFromArray($style3);
                    $event->sheet->getDelegate()->getStyle('N4')->applyFromArray($style3);
                    $event->sheet->getDelegate()->getStyle('R4')->applyFromArray($style3);

                    // $event->sheet->getDelegate()->getStyle('D4')->applyFromArray($style2);
                    // $event->sheet->getDelegate()->getStyle('D4')->applyFromArray($style2);
                    // $event->sheet->getDelegate()->getStyle('H39')->applyFromArray($style3);
                    // $event->sheet->getDelegate()->getStyle('K39')->applyFromArray($style3);
                    // $event->sheet->getDelegate()->getStyle('L54')->applyFromArray($style2);
                    // $event->sheet->getDelegate()->getStyle('R60')->applyFromArray($style3);
                    // $event->sheet->getDelegate()->getStyle('R61')->applyFromArray($style3);
                    // // $event->sheet->getDelegate()->getStyle('R57:T57')->applyFromArray($style2);
                    // $event->sheet->getDelegate()->getStyle('P54:Q54')->applyFromArray($style3);
                    // $event->sheet->getDelegate()->getStyle('N69:Q69')->applyFromArray($style3);
                    // $event->sheet->getDelegate()->getStyle('R69:U69')->applyFromArray($style3);



                    // BOTTOM BORDER FOR SIGNATURE
                    // $exploded_worker_name = explode(', ',  $get_worker_style->name);
                    // $exploded_tools_name = explode(', ',  $get_tools_style->name);
                    $starting_point = 53;

                    $workerCount = count($get_worker_style);
                    $toolsCount = count($get_tools_style);


                    $addToolsAndWorker = ($toolsCount + $workerCount);

                    if($toolsCount >= 3){
                        $total = ((int)$starting_point + (int)$addToolsAndWorker);
                    }else if($toolsCount == 2){

                        $total = ((int)$starting_point + (int)$addToolsAndWorker+1);
                    }else{
                        $total = ((int)$starting_point + (int)$addToolsAndWorker+2);
                    }


                    $jatot = $total +5;


                    $result_D = 'C'.$total.':G'.$total;
                    $result_I = 'I'.$total.':L'.$total;
                    $result_M = 'N'.$total.':P'.$total;
                    $result_R = 'S'.$total.':V'.$total;


                    $result_D2 = 'C'.$jatot.':G'.$jatot;
                    $result_H = 'I'.$jatot.':L'.$jatot;
                    $result_M2 = 'N'.$jatot.':P'.$jatot;
                    $result_R2 = 'S'.$jatot.':V'.$jatot;

                    // dd($result_D);

                    $jatot_2 = $jatot + 2;

                    $event->sheet->getDelegate()->getStyle("A1:W".$jatot_2)->applyFromArray($styleBorderOutside);




                    // dd($jatot_2);

                    // dd((int)$total);
                    // return $starting_point;


                    $event->sheet->getDelegate()->getStyle((string)$result_5)->getFont()->setSize(10);
                    $event->sheet->getDelegate()->getRowDimension((string)$result_6)->setRowHeight(25);
                    $event->sheet->getDelegate()->getRowDimension((string)$total)->setRowHeight(50);
                    $event->sheet->getDelegate()->getRowDimension((string)$jatot)->setRowHeight(50);

                    $event->sheet->getDelegate()->getStyle((string)$result_D)->applyFromArray($styleBorderBottomThin);
                    $event->sheet->getDelegate()->getStyle((string)$result_I)->applyFromArray($styleBorderBottomThin);
                    $event->sheet->getDelegate()->getStyle((string)$result_M)->applyFromArray($styleBorderBottomThin);
                    $event->sheet->getDelegate()->getStyle((string)$result_R)->applyFromArray($styleBorderBottomThin);
                    $event->sheet->getDelegate()->getStyle((string)$result_D2)->applyFromArray($styleBorderBottomThin);
                    $event->sheet->getDelegate()->getStyle((string)$result_H)->applyFromArray($styleBorderBottomThin);
                    $event->sheet->getDelegate()->getStyle((string)$result_M2)->applyFromArray($styleBorderBottomThin);
                    $event->sheet->getDelegate()->getStyle((string)$result_R2)->applyFromArray($styleBorderBottomThin);
                    $event->sheet->getDelegate()->getStyle((string)$result_2)->applyFromArray($styleBorderBottomThin);
                    $event->sheet->getDelegate()->getStyle((string)$result_3)->applyFromArray($styleBorderRightThin);
                    $event->sheet->getDelegate()->getStyle((string)$result_4)->applyFromArray($styleBorderBottomThin);
                    $event->sheet->getDelegate()->getStyle((string)$result_1)->applyFromArray($styleBorderAll);
                    $event->sheet->getDelegate()->getStyle((string)$result_2)->applyFromArray($style5);


                    // dd($result_2);



                    $event->sheet->getDelegate()->getStyle('A1:W1')->applyFromArray($styleBorderAll);
                    // $event->sheet->getDelegate()->getStyle('A1:A5')->applyFromArray($styleBorderLeftThin);
                    $event->sheet->getDelegate()->getStyle('A2:W2')->applyFromArray($styleBorderAll);
                    $event->sheet->getDelegate()->getStyle('W4')->applyFromArray($styleBorderRightThin);
                    $event->sheet->getDelegate()->getStyle('A3:W3')->applyFromArray($styleBorderAll);
                    $event->sheet->getDelegate()->getStyle('W5')->applyFromArray($styleBorderRightThin);
                    $event->sheet->getDelegate()->getStyle('A7:W7')->applyFromArray($styleBorderAll);
                    $event->sheet->getDelegate()->getStyle('A8:W8')->applyFromArray($styleBorderAll);
                    $event->sheet->getDelegate()->getStyle('A9:W9')->applyFromArray($styleBorderAll);
                    $event->sheet->getDelegate()->getStyle('A10:W10')->applyFromArray($styleBorderAll);
                    $event->sheet->getDelegate()->getStyle('A11:W11')->applyFromArray($styleBorderAll);
                    $event->sheet->getDelegate()->getStyle('A13:W13')->applyFromArray($styleBorderAll);
                    $event->sheet->getDelegate()->getStyle('W14')->applyFromArray($styleBorderRightThin);
                    $event->sheet->getDelegate()->getStyle('W15')->applyFromArray($styleBorderRightThin);
                    $event->sheet->getDelegate()->getStyle('W16')->applyFromArray($styleBorderRightThin);
                    $event->sheet->getDelegate()->getStyle('W17')->applyFromArray($styleBorderRightThin);
                    $event->sheet->getDelegate()->getStyle('A18:W18')->applyFromArray($styleBorderAll);
                    $event->sheet->getDelegate()->getStyle('A19:W19')->applyFromArray($styleBorderAll);
                    $event->sheet->getDelegate()->getStyle('A20:W20')->applyFromArray($styleBorderAll);
                    $event->sheet->getDelegate()->getStyle('A21:W21')->applyFromArray($styleBorderAll);
                    $event->sheet->getDelegate()->getStyle('A22:W22')->applyFromArray($styleBorderAll);
                    $event->sheet->getDelegate()->getStyle('A23:W23')->applyFromArray($styleBorderAll);
                    $event->sheet->getDelegate()->getStyle('A24:W24')->applyFromArray($styleBorderAll);
                    $event->sheet->getDelegate()->getStyle('A25:W25')->applyFromArray($styleBorderAll);
                    $event->sheet->getDelegate()->getStyle('A26:W26')->applyFromArray($styleBorderAll);
                    $event->sheet->getDelegate()->getStyle('A27:W27')->applyFromArray($styleBorderAll);
                    $event->sheet->getDelegate()->getStyle('A28:W28')->applyFromArray($styleBorderAll);
                    $event->sheet->getDelegate()->getStyle('A29:W29')->applyFromArray($styleBorderAll);
                    $event->sheet->getDelegate()->getStyle('A30:W30')->applyFromArray($styleBorderAll);
                    $event->sheet->getDelegate()->getStyle('A31:W31')->applyFromArray($styleBorderAll);
                    $event->sheet->getDelegate()->getStyle('A32:W32')->applyFromArray($styleBorderAll);
                    $event->sheet->getDelegate()->getStyle('A33:W33')->applyFromArray($styleBorderAll);
                    $event->sheet->getDelegate()->getStyle('A34:W34')->applyFromArray($styleBorderAll);
                    $event->sheet->getDelegate()->getStyle('A35:W35')->applyFromArray($styleBorderAll);
                    $event->sheet->getDelegate()->getStyle('A36:W36')->applyFromArray($styleBorderAll);
                    $event->sheet->getDelegate()->getStyle('A37:W37')->applyFromArray($styleBorderAll);
                    $event->sheet->getDelegate()->getStyle('A38:W38')->applyFromArray($styleBorderAll);
                    $event->sheet->getDelegate()->getStyle('A39:W39')->applyFromArray($styleBorderAll);
                    // $event->sheet->getDelegate()->getStyle('A40:W40')->applyFromArray($styleBorderAll);
                    // $event->sheet->getDelegate()->getStyle('A41:W41')->applyFromArray($styleBorderAll);

                    $event->sheet->getDelegate()->mergeCells('T2:W2');
                    if($work_permit->status > 9){
                        $event->sheet->setCellValue('T2',"Work Permit Extended");

                    }

                },
            ];
        }

        public function drawings()
        {

            $this->get_worker;
            $this->get_tools;


            $starting_point = 53;

            $workerCount = count($this->get_worker);
            $toolsCount = count($this->get_tools);


            $addToolsAndWorker = ($toolsCount + $workerCount);

            if($toolsCount >= 3){
                $total = ((int)$starting_point + (int)$addToolsAndWorker);
            }else if($toolsCount == 2){

                $total = ((int)$starting_point + (int)$addToolsAndWorker+1);
            }else{
                $total = ((int)$starting_point + (int)$addToolsAndWorker+2);
            }


            $jatot = $total +5;


            //PERMIT APPROVAL
            $result_d1 = 'D'.$total;
            $result_h1 = 'I'.$total;
            $result_m1 = 'M'.$total;
            $result_r1 = 'T'.$total;

            //PERMIT CLEARANCE
            $result_d2 = 'D'.$jatot;
            $result_h2 = 'I'.$jatot;
            $result_m2 = 'M'.$jatot;
            $result_r2 = 'T'.$jatot;


            // $result_R2 = 'S'.$total.':V'.$total;


            $a = 39;
            $p = $a;

            for($q = 0; $q < count($this->get_worker); $q++){

                $a++;

            }

            $result_1 = 'A'.$p.':W'.$a;


            if (count($this->get_tools) >= 3){
                $b = $a+2;

                }elseif (count($this->get_tools) == 2)
                {
                    $b = $a+3;
                }else{
                    $b = $a+4;

                }
                $l = $a+6;

                for($w = 0; $w < count($this->get_tools); $w++){
                    $b++;
                    $l++;
                }

            $c = $b+5;
            $k = $b+3;
            $t = $b+5;
            $d = $c+5;
            $e = $d+5;
            $u = $d+9;

            $result_2 = 'T'.$k;

            // dd($result_2);
            // dd($result_R2);

            $drawings = new Drawing();

            $drawings->setPath(public_path('/images/pricon_logo (2).png'));
            // $drawings->setHeight(450);
            $drawings->setWidth(345);

            $drawings->setCoordinates('B1');
            $drawings->setOffsetY(3);
            // $drawings->setCoordinates('G1');

            //PERMIT APPROVAL
            // dd($this->workpermit_soic->status);


            if ($this->workpermit_soic->status == 1 || $this->workpermit_soic->status == 2
            || $this->workpermit_soic->status == 3 || $this->workpermit_soic->status == 4 || $this->workpermit_soic->status == 5
            || $this->workpermit_soic->status == 6 || $this->workpermit_soic->status == 7 || $this->workpermit_soic->status == 8){

                $project_in_charge_sig = new Drawing();
                $project_in_charge_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['project_in_charge'] .".png")));
                $project_in_charge_sig->setHeight(50);
                $project_in_charge_sig->setCoordinates((string)$result_d1);
                $project_in_charge_sig->setOffsetX(100);
                $project_in_charge_sig->setOffsetY(10);
            }else{
                $project_in_charge_sig = new Drawing();
                $project_in_charge_sig->setPath(public_path( ("/storage/e-signature/". 'white' .".png")));
                $project_in_charge_sig->setHeight(20);
                $project_in_charge_sig->setCoordinates((string)$result_d1);
                $project_in_charge_sig->setOffsetX(100);
                $project_in_charge_sig->setOffsetY(10);
            }

            if ($this->workpermit_soic->status == 2 || $this->workpermit_soic->status == 3 || $this->workpermit_soic->status == 4 || $this->workpermit_soic->status == 5 || $this->workpermit_soic->status == 6 || $this->workpermit_soic->status == 7 || $this->workpermit_soic->status == 8){

                $project_in_charge_sig = new Drawing();
                $project_in_charge_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['project_in_charge'] .".png")));
                $project_in_charge_sig->setHeight(50);
                $project_in_charge_sig->setCoordinates((string)$result_d1);
                $project_in_charge_sig->setOffsetX(100);
                $project_in_charge_sig->setOffsetY(10);

                $safety_officer_in_charge_sig = new Drawing();
                $safety_officer_in_charge_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['safety_officer_in_charge_id'] .".png")));
                $safety_officer_in_charge_sig->setHeight(50);
                $safety_officer_in_charge_sig->setCoordinates((string)$result_h1);
                $safety_officer_in_charge_sig->setOffsetX(100);
                $safety_officer_in_charge_sig->setOffsetY(10);

                $contractor_pmi_soic = new Drawing();
                $contractor_pmi_soic->setPath(public_path( ("/storage/e-signature/". $this->e_signature['safety_officer_in_charge_id'] .".png")));
                $contractor_pmi_soic->setHeight(60);
                $contractor_pmi_soic->setCoordinates((string)$result_2);
                $contractor_pmi_soic->setOffsetX(90);
                $contractor_pmi_soic->setOffsetY(10);


            }else{
                $safety_officer_in_charge_sig = new Drawing();
                $safety_officer_in_charge_sig->setPath(public_path( ("/storage/e-signature/". 'white' .".png")));
                $safety_officer_in_charge_sig->setHeight(20);
                $safety_officer_in_charge_sig->setCoordinates((string)$result_h1);
                $safety_officer_in_charge_sig->setOffsetX(100);
                $safety_officer_in_charge_sig->setOffsetY(10);

                $contractor_pmi_soic = new Drawing();
                $contractor_pmi_soic->setPath(public_path( ("/storage/e-signature/". 'white' .".png")));
                $contractor_pmi_soic->setHeight(50);
                $contractor_pmi_soic->setCoordinates((string)$result_2);
                $contractor_pmi_soic->setOffsetX(100);
                $contractor_pmi_soic->setOffsetY(10);

            }

            if ($this->workpermit_soic->status == 3 || $this->workpermit_soic->status == 4 || $this->workpermit_soic->status == 5 || $this->workpermit_soic->status == 6 || $this->workpermit_soic->status == 7 || $this->workpermit_soic->status == 8){

                $project_in_charge_sig = new Drawing();
                $project_in_charge_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['project_in_charge'] .".png")));
                $project_in_charge_sig->setHeight(50);
                $project_in_charge_sig->setCoordinates((string)$result_d1);
                $project_in_charge_sig->setOffsetX(100);
                $project_in_charge_sig->setOffsetY(10);

                $safety_officer_in_charge_sig = new Drawing();
                $safety_officer_in_charge_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['safety_officer_in_charge_id'] .".png")));
                $safety_officer_in_charge_sig->setHeight(50);
                $safety_officer_in_charge_sig->setCoordinates((string)$result_h1);
                $safety_officer_in_charge_sig->setOffsetX(100);
                $safety_officer_in_charge_sig->setOffsetY(10);


                $over_all_safety_officer_sig = new Drawing();
                $over_all_safety_officer_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['over_all_safety_officer_id'] .".png")));
                $over_all_safety_officer_sig->setHeight(50);
                $over_all_safety_officer_sig->setCoordinates((string)$result_m1);
                $over_all_safety_officer_sig->setOffsetX(100);
                $over_all_safety_officer_sig->setOffsetY(10);

            }else{
                $over_all_safety_officer_sig = new Drawing();
                $over_all_safety_officer_sig->setPath(public_path( ("/storage/e-signature/". 'white' .".png")));
                $over_all_safety_officer_sig->setHeight(20);
                $over_all_safety_officer_sig->setCoordinates((string)$result_m1);
                $over_all_safety_officer_sig->setOffsetX(100);
                $over_all_safety_officer_sig->setOffsetY(10);

            }

            if ($this->workpermit_soic->status == 4 || $this->workpermit_soic->status == 5 || $this->workpermit_soic->status == 6 || $this->workpermit_soic->status == 7 || $this->workpermit_soic->status == 8){

                $project_in_charge_sig = new Drawing();
                $project_in_charge_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['project_in_charge'] .".png")));
                $project_in_charge_sig->setHeight(50);
                $project_in_charge_sig->setCoordinates((string)$result_d1);
                $project_in_charge_sig->setOffsetX(100);
                $project_in_charge_sig->setOffsetY(10);

                $safety_officer_in_charge_sig = new Drawing();
                $safety_officer_in_charge_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['safety_officer_in_charge_id'] .".png")));
                $safety_officer_in_charge_sig->setHeight(50);
                $safety_officer_in_charge_sig->setCoordinates((string)$result_h1);
                $safety_officer_in_charge_sig->setOffsetX(100);
                $safety_officer_in_charge_sig->setOffsetY(10);


                $over_all_safety_officer_sig = new Drawing();
                $over_all_safety_officer_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['over_all_safety_officer_id'] .".png")));
                $over_all_safety_officer_sig->setHeight(50);
                $over_all_safety_officer_sig->setCoordinates((string)$result_m1);
                $over_all_safety_officer_sig->setOffsetX(100);
                $over_all_safety_officer_sig->setOffsetY(10);

                $hrd_manager_sig = new Drawing();
                $hrd_manager_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['hrd_manager_id'] .".png")));
                $hrd_manager_sig->setHeight(50);
                $hrd_manager_sig->setCoordinates((string)$result_r1);
                $hrd_manager_sig->setOffsetX(30);
                $hrd_manager_sig->setOffsetY(10);

            }else{
                $hrd_manager_sig = new Drawing();
                $hrd_manager_sig->setPath(public_path( ("/storage/e-signature/". 'white' .".png")));
                $hrd_manager_sig->setHeight(20);
                $hrd_manager_sig->setCoordinates((string)$result_r1);
                $hrd_manager_sig->setOffsetX(120);
                $hrd_manager_sig->setOffsetY(10);

            }

            if ($this->workpermit_soic->status == 5 || $this->workpermit_soic->status == 6 || $this->workpermit_soic->status == 7 || $this->workpermit_soic->status == 8){

                $project_in_charge_sig = new Drawing();
                $project_in_charge_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['project_in_charge'] .".png")));
                $project_in_charge_sig->setHeight(50);
                $project_in_charge_sig->setCoordinates((string)$result_d1);
                $project_in_charge_sig->setOffsetX(100);
                $project_in_charge_sig->setOffsetY(10);

                $safety_officer_in_charge_sig = new Drawing();
                $safety_officer_in_charge_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['safety_officer_in_charge_id'] .".png")));
                $safety_officer_in_charge_sig->setHeight(50);
                $safety_officer_in_charge_sig->setCoordinates((string)$result_h1);
                $safety_officer_in_charge_sig->setOffsetX(100);
                $safety_officer_in_charge_sig->setOffsetY(10);


                $over_all_safety_officer_sig = new Drawing();
                $over_all_safety_officer_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['over_all_safety_officer_id'] .".png")));
                $over_all_safety_officer_sig->setHeight(50);
                $over_all_safety_officer_sig->setCoordinates((string)$result_m1);
                $over_all_safety_officer_sig->setOffsetX(100);
                $over_all_safety_officer_sig->setOffsetY(10);

                $hrd_manager_sig = new Drawing();
                $hrd_manager_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['hrd_manager_id'] .".png")));
                $hrd_manager_sig->setHeight(50);
                $hrd_manager_sig->setCoordinates((string)$result_r1);
                $hrd_manager_sig->setOffsetX(30);
                $hrd_manager_sig->setOffsetY(10);

                $safety_officer_in_charge_sig2 = new Drawing();
                $safety_officer_in_charge_sig2->setPath(public_path( ("/storage/e-signature/". $this->e_signature['safety_officer_in_charge_id'] .".png")));
                $safety_officer_in_charge_sig2->setHeight(50);
                $safety_officer_in_charge_sig2->setCoordinates((string)$result_d2);
                $safety_officer_in_charge_sig2->setOffsetX(100);
                $safety_officer_in_charge_sig2->setOffsetY(10);

            }else{
                $safety_officer_in_charge_sig2 = new Drawing();
                $safety_officer_in_charge_sig2->setPath(public_path( ("/storage/e-signature/". 'white' .".png")));
                $safety_officer_in_charge_sig2->setHeight(20);
                $safety_officer_in_charge_sig2->setCoordinates((string)$result_d2);
                $safety_officer_in_charge_sig2->setOffsetX(100);
                $safety_officer_in_charge_sig2->setOffsetY(10);

            }

            if ($this->workpermit_soic->status == 6 || $this->workpermit_soic->status == 7 || $this->workpermit_soic->status == 8){

                $project_in_charge_sig = new Drawing();
                $project_in_charge_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['project_in_charge'] .".png")));
                $project_in_charge_sig->setHeight(50);
                $project_in_charge_sig->setCoordinates((string)$result_d1);
                $project_in_charge_sig->setOffsetX(100);
                $project_in_charge_sig->setOffsetY(10);

                $safety_officer_in_charge_sig = new Drawing();
                $safety_officer_in_charge_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['safety_officer_in_charge_id'] .".png")));
                $safety_officer_in_charge_sig->setHeight(50);
                $safety_officer_in_charge_sig->setCoordinates((string)$result_h1);
                $safety_officer_in_charge_sig->setOffsetX(100);
                $safety_officer_in_charge_sig->setOffsetY(10);


                $over_all_safety_officer_sig = new Drawing();
                $over_all_safety_officer_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['over_all_safety_officer_id'] .".png")));
                $over_all_safety_officer_sig->setHeight(50);
                $over_all_safety_officer_sig->setCoordinates((string)$result_m1);
                $over_all_safety_officer_sig->setOffsetX(100);
                $over_all_safety_officer_sig->setOffsetY(10);

                $hrd_manager_sig = new Drawing();
                $hrd_manager_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['hrd_manager_id'] .".png")));
                $hrd_manager_sig->setHeight(50);
                $hrd_manager_sig->setCoordinates((string)$result_r1);
                $hrd_manager_sig->setOffsetX(30);
                $hrd_manager_sig->setOffsetY(5);

                $safety_officer_in_charge_sig2 = new Drawing();
                $safety_officer_in_charge_sig2->setPath(public_path( ("/storage/e-signature/". $this->e_signature['safety_officer_in_charge_id'] .".png")));
                $safety_officer_in_charge_sig2->setHeight(50);
                $safety_officer_in_charge_sig2->setCoordinates((string)$result_d2);
                $safety_officer_in_charge_sig2->setOffsetX(100);
                $safety_officer_in_charge_sig2->setOffsetY(10);

                $ems_manager_sig = new Drawing();
                $ems_manager_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['ems_manager_id'] .".png")));
                $ems_manager_sig->setHeight(50);
                $ems_manager_sig->setCoordinates((string)$result_h2);
                $ems_manager_sig->setOffsetX(100);
                $ems_manager_sig->setOffsetY(10);

            }else{
                $ems_manager_sig = new Drawing();
                $ems_manager_sig->setPath(public_path( ("/storage/e-signature/". 'white' .".png")));
                $ems_manager_sig->setHeight(20);
                $ems_manager_sig->setCoordinates((string)$result_h2);
                $ems_manager_sig->setOffsetX(100);
                $ems_manager_sig->setOffsetY(10);

            }

            if ($this->workpermit_soic->status == 7 || $this->workpermit_soic->status == 8){

                $project_in_charge_sig = new Drawing();
                $project_in_charge_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['project_in_charge'] .".png")));
                $project_in_charge_sig->setHeight(50);
                $project_in_charge_sig->setCoordinates((string)$result_d1);
                $project_in_charge_sig->setOffsetX(100);
                $project_in_charge_sig->setOffsetY(10);

                $safety_officer_in_charge_sig = new Drawing();
                $safety_officer_in_charge_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['safety_officer_in_charge_id'] .".png")));
                $safety_officer_in_charge_sig->setHeight(50);
                $safety_officer_in_charge_sig->setCoordinates((string)$result_h1);
                $safety_officer_in_charge_sig->setOffsetX(100);
                $safety_officer_in_charge_sig->setOffsetY(10);


                $over_all_safety_officer_sig = new Drawing();
                $over_all_safety_officer_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['over_all_safety_officer_id'] .".png")));
                $over_all_safety_officer_sig->setHeight(50);
                $over_all_safety_officer_sig->setCoordinates((string)$result_m1);
                $over_all_safety_officer_sig->setOffsetX(100);
                $over_all_safety_officer_sig->setOffsetY(10);

                $hrd_manager_sig = new Drawing();
                $hrd_manager_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['hrd_manager_id'] .".png")));
                $hrd_manager_sig->setHeight(50);
                $hrd_manager_sig->setCoordinates((string)$result_r1);
                $hrd_manager_sig->setOffsetX(30);
                $hrd_manager_sig->setOffsetY(10);

                $safety_officer_in_charge_sig2 = new Drawing();
                $safety_officer_in_charge_sig2->setPath(public_path( ("/storage/e-signature/". $this->e_signature['safety_officer_in_charge_id'] .".png")));
                $safety_officer_in_charge_sig2->setHeight(50);
                $safety_officer_in_charge_sig2->setCoordinates((string)$result_d2);
                $safety_officer_in_charge_sig2->setOffsetX(100);
                $safety_officer_in_charge_sig2->setOffsetY(10);

                $ems_manager_sig = new Drawing();
                $ems_manager_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['ems_manager_id'] .".png")));
                $ems_manager_sig->setHeight(50);
                $ems_manager_sig->setCoordinates((string)$result_h2);
                $ems_manager_sig->setOffsetX(100);
                $ems_manager_sig->setOffsetY(10);

                $over_all_safety_officer_sig2 = new Drawing();
                $over_all_safety_officer_sig2->setPath(public_path( ("/storage/e-signature/". $this->e_signature['over_all_safety_officer_id'] .".png")));
                $over_all_safety_officer_sig2->setHeight(50);
                $over_all_safety_officer_sig2->setCoordinates((string)$result_m2);
                $over_all_safety_officer_sig2->setOffsetX(100);
                $over_all_safety_officer_sig2->setOffsetY(10);

            }else{
                $over_all_safety_officer_sig2 = new Drawing();
                $over_all_safety_officer_sig2->setPath(public_path( ("/storage/e-signature/". 'white' .".png")));
                $over_all_safety_officer_sig2->setHeight(20);
                $over_all_safety_officer_sig2->setCoordinates((string)$result_m2);
                $over_all_safety_officer_sig2->setOffsetX(100);
                $over_all_safety_officer_sig2->setOffsetY(10);

            }

            if ($this->workpermit_soic->status == 8){

                $project_in_charge_sig = new Drawing();
                $project_in_charge_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['project_in_charge'] .".png")));
                $project_in_charge_sig->setHeight(50);
                $project_in_charge_sig->setCoordinates((string)$result_d1);
                $project_in_charge_sig->setOffsetX(100);
                $project_in_charge_sig->setOffsetY(10);

                $safety_officer_in_charge_sig = new Drawing();
                $safety_officer_in_charge_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['safety_officer_in_charge_id'] .".png")));
                $safety_officer_in_charge_sig->setHeight(50);
                $safety_officer_in_charge_sig->setCoordinates((string)$result_h1);
                $safety_officer_in_charge_sig->setOffsetX(100);
                $safety_officer_in_charge_sig->setOffsetY(10);


                $over_all_safety_officer_sig = new Drawing();
                $over_all_safety_officer_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['over_all_safety_officer_id'] .".png")));
                $over_all_safety_officer_sig->setHeight(50);
                $over_all_safety_officer_sig->setCoordinates((string)$result_m1);
                $over_all_safety_officer_sig->setOffsetX(100);
                $over_all_safety_officer_sig->setOffsetY(10);

                $hrd_manager_sig = new Drawing();
                $hrd_manager_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['hrd_manager_id'] .".png")));
                $hrd_manager_sig->setHeight(50);
                $hrd_manager_sig->setCoordinates((string)$result_r1);
                $hrd_manager_sig->setOffsetX(30);
                $hrd_manager_sig->setOffsetY(10);

                $safety_officer_in_charge_sig2 = new Drawing();
                $safety_officer_in_charge_sig2->setPath(public_path( ("/storage/e-signature/". $this->e_signature['safety_officer_in_charge_id'] .".png")));
                $safety_officer_in_charge_sig2->setHeight(50);
                $safety_officer_in_charge_sig2->setCoordinates((string)$result_d2);
                $safety_officer_in_charge_sig2->setOffsetX(100);
                $safety_officer_in_charge_sig2->setOffsetY(10);

                $ems_manager_sig = new Drawing();
                $ems_manager_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['ems_manager_id'] .".png")));
                $ems_manager_sig->setHeight(50);
                $ems_manager_sig->setCoordinates((string)$result_h2);
                $ems_manager_sig->setOffsetX(100);
                $ems_manager_sig->setOffsetY(10);

                $over_all_safety_officer_sig2 = new Drawing();
                $over_all_safety_officer_sig2->setPath(public_path( ("/storage/e-signature/". $this->e_signature['over_all_safety_officer_id'] .".png")));
                $over_all_safety_officer_sig2->setHeight(50);
                $over_all_safety_officer_sig2->setCoordinates((string)$result_m2);
                $over_all_safety_officer_sig2->setOffsetX(100);
                $over_all_safety_officer_sig2->setOffsetY(10);

                $hrd_manager_sig2 = new Drawing();
                $hrd_manager_sig2->setPath(public_path( ("/storage/e-signature/". $this->e_signature['hrd_manager_id'] .".png")));
                $hrd_manager_sig2->setHeight(50);
                $hrd_manager_sig2->setCoordinates((string)$result_r2);
                $hrd_manager_sig2->setOffsetX(30);
                $hrd_manager_sig2->setOffsetY(10);

            }else{
                $hrd_manager_sig2 = new Drawing();
                $hrd_manager_sig2->setPath(public_path( ("/storage/e-signature/". 'white' .".png")));
                $hrd_manager_sig2->setHeight(20);
                $hrd_manager_sig2->setCoordinates((string)$result_r2);
                $hrd_manager_sig2->setOffsetX(100);
                $hrd_manager_sig2->setOffsetY(10);

            }

            if ($this->workpermit_soic->status == 10 || $this->workpermit_soic->status == 11  || $this->workpermit_soic->status == 12 || $this->workpermit_soic->status == 13 || $this->workpermit_soic->status == 14){

                $project_in_charge_sig = new Drawing();
                $project_in_charge_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['project_in_charge'] .".png")));
                $project_in_charge_sig->setHeight(50);
                $project_in_charge_sig->setCoordinates((string)$result_d1);
                $project_in_charge_sig->setOffsetX(100);
                $project_in_charge_sig->setOffsetY(10);

                $safety_officer_in_charge_sig = new Drawing();
                $safety_officer_in_charge_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['safety_officer_in_charge_id'] .".png")));
                $safety_officer_in_charge_sig->setHeight(50);
                $safety_officer_in_charge_sig->setCoordinates((string)$result_h1);
                $safety_officer_in_charge_sig->setOffsetX(100);
                $safety_officer_in_charge_sig->setOffsetY(10);


                $over_all_safety_officer_sig = new Drawing();
                $over_all_safety_officer_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['over_all_safety_officer_id'] .".png")));
                $over_all_safety_officer_sig->setHeight(50);
                $over_all_safety_officer_sig->setCoordinates((string)$result_m1);
                $over_all_safety_officer_sig->setOffsetX(100);
                $over_all_safety_officer_sig->setOffsetY(10);

                $hrd_manager_sig = new Drawing();
                $hrd_manager_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['hrd_manager_id'] .".png")));
                $hrd_manager_sig->setHeight(50);
                $hrd_manager_sig->setCoordinates((string)$result_r1);
                $hrd_manager_sig->setOffsetX(30);
                $hrd_manager_sig->setOffsetY(10);

                // $safety_officer_in_charge_sig2 = new Drawing();
                // $safety_officer_in_charge_sig2->setPath(public_path( ("/storage/e-signature/". $this->e_signature['safety_officer_in_charge_id'] .".png")));
                // $safety_officer_in_charge_sig2->setHeight(50);
                // $safety_officer_in_charge_sig2->setCoordinates((string)$result_d2);
                // $safety_officer_in_charge_sig2->setOffsetX(100);
                // $safety_officer_in_charge_sig2->setOffsetY(10);
                $contractor_pmi_soic = new Drawing();
                $contractor_pmi_soic->setPath(public_path( ("/storage/e-signature/". $this->e_signature['safety_officer_in_charge_id'] .".png")));
                $contractor_pmi_soic->setHeight(60);
                $contractor_pmi_soic->setCoordinates((string)$result_2);
                $contractor_pmi_soic->setOffsetX(90);
                $contractor_pmi_soic->setOffsetY(10);

            }

            if ($this->workpermit_soic->status == 11  || $this->workpermit_soic->status == 12 || $this->workpermit_soic->status == 13 || $this->workpermit_soic->status == 14){

                $project_in_charge_sig = new Drawing();
                $project_in_charge_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['project_in_charge'] .".png")));
                $project_in_charge_sig->setHeight(50);
                $project_in_charge_sig->setCoordinates((string)$result_d1);
                $project_in_charge_sig->setOffsetX(100);
                $project_in_charge_sig->setOffsetY(10);

                $safety_officer_in_charge_sig = new Drawing();
                $safety_officer_in_charge_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['safety_officer_in_charge_id'] .".png")));
                $safety_officer_in_charge_sig->setHeight(50);
                $safety_officer_in_charge_sig->setCoordinates((string)$result_h1);
                $safety_officer_in_charge_sig->setOffsetX(100);
                $safety_officer_in_charge_sig->setOffsetY(10);


                $over_all_safety_officer_sig = new Drawing();
                $over_all_safety_officer_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['over_all_safety_officer_id'] .".png")));
                $over_all_safety_officer_sig->setHeight(50);
                $over_all_safety_officer_sig->setCoordinates((string)$result_m1);
                $over_all_safety_officer_sig->setOffsetX(100);
                $over_all_safety_officer_sig->setOffsetY(10);

                $hrd_manager_sig = new Drawing();
                $hrd_manager_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['hrd_manager_id'] .".png")));
                $hrd_manager_sig->setHeight(50);
                $hrd_manager_sig->setCoordinates((string)$result_r1);
                $hrd_manager_sig->setOffsetX(30);
                $hrd_manager_sig->setOffsetY(10);

                $safety_officer_in_charge_sig2 = new Drawing();
                $safety_officer_in_charge_sig2->setPath(public_path( ("/storage/e-signature/". $this->e_signature['safety_officer_in_charge_id'] .".png")));
                $safety_officer_in_charge_sig2->setHeight(50);
                $safety_officer_in_charge_sig2->setCoordinates((string)$result_d2);
                $safety_officer_in_charge_sig2->setOffsetX(100);
                $safety_officer_in_charge_sig2->setOffsetY(10);

            }

            if ($this->workpermit_soic->status == 12 || $this->workpermit_soic->status == 13 || $this->workpermit_soic->status == 14){

                $project_in_charge_sig = new Drawing();
                $project_in_charge_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['project_in_charge'] .".png")));
                $project_in_charge_sig->setHeight(50);
                $project_in_charge_sig->setCoordinates((string)$result_d1);
                $project_in_charge_sig->setOffsetX(100);
                $project_in_charge_sig->setOffsetY(10);

                $safety_officer_in_charge_sig = new Drawing();
                $safety_officer_in_charge_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['safety_officer_in_charge_id'] .".png")));
                $safety_officer_in_charge_sig->setHeight(50);
                $safety_officer_in_charge_sig->setCoordinates((string)$result_h1);
                $safety_officer_in_charge_sig->setOffsetX(100);
                $safety_officer_in_charge_sig->setOffsetY(10);


                $over_all_safety_officer_sig = new Drawing();
                $over_all_safety_officer_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['over_all_safety_officer_id'] .".png")));
                $over_all_safety_officer_sig->setHeight(50);
                $over_all_safety_officer_sig->setCoordinates((string)$result_m1);
                $over_all_safety_officer_sig->setOffsetX(100);
                $over_all_safety_officer_sig->setOffsetY(10);

                $hrd_manager_sig = new Drawing();
                $hrd_manager_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['hrd_manager_id'] .".png")));
                $hrd_manager_sig->setHeight(50);
                $hrd_manager_sig->setCoordinates((string)$result_r1);
                $hrd_manager_sig->setOffsetX(30);
                $hrd_manager_sig->setOffsetY(10);

                $safety_officer_in_charge_sig2 = new Drawing();
                $safety_officer_in_charge_sig2->setPath(public_path( ("/storage/e-signature/". $this->e_signature['safety_officer_in_charge_id'] .".png")));
                $safety_officer_in_charge_sig2->setHeight(50);
                $safety_officer_in_charge_sig2->setCoordinates((string)$result_d2);
                $safety_officer_in_charge_sig2->setOffsetX(100);
                $safety_officer_in_charge_sig2->setOffsetY(10);

                $ems_manager_sig = new Drawing();
                $ems_manager_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['ems_manager_id'] .".png")));
                $ems_manager_sig->setHeight(50);
                $ems_manager_sig->setCoordinates((string)$result_h2);
                $ems_manager_sig->setOffsetX(100);
                $ems_manager_sig->setOffsetY(10);

            }

            if ($this->workpermit_soic->status == 13 || $this->workpermit_soic->status == 14){

                $project_in_charge_sig = new Drawing();
                $project_in_charge_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['project_in_charge'] .".png")));
                $project_in_charge_sig->setHeight(50);
                $project_in_charge_sig->setCoordinates((string)$result_d1);
                $project_in_charge_sig->setOffsetX(100);
                $project_in_charge_sig->setOffsetY(10);

                $safety_officer_in_charge_sig = new Drawing();
                $safety_officer_in_charge_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['safety_officer_in_charge_id'] .".png")));
                $safety_officer_in_charge_sig->setHeight(50);
                $safety_officer_in_charge_sig->setCoordinates((string)$result_h1);
                $safety_officer_in_charge_sig->setOffsetX(100);
                $safety_officer_in_charge_sig->setOffsetY(10);


                $over_all_safety_officer_sig = new Drawing();
                $over_all_safety_officer_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['over_all_safety_officer_id'] .".png")));
                $over_all_safety_officer_sig->setHeight(50);
                $over_all_safety_officer_sig->setCoordinates((string)$result_m1);
                $over_all_safety_officer_sig->setOffsetX(100);
                $over_all_safety_officer_sig->setOffsetY(10);

                $hrd_manager_sig = new Drawing();
                $hrd_manager_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['hrd_manager_id'] .".png")));
                $hrd_manager_sig->setHeight(50);
                $hrd_manager_sig->setCoordinates((string)$result_r1);
                $hrd_manager_sig->setOffsetX(30);
                $hrd_manager_sig->setOffsetY(10);

                $safety_officer_in_charge_sig2 = new Drawing();
                $safety_officer_in_charge_sig2->setPath(public_path( ("/storage/e-signature/". $this->e_signature['safety_officer_in_charge_id'] .".png")));
                $safety_officer_in_charge_sig2->setHeight(50);
                $safety_officer_in_charge_sig2->setCoordinates((string)$result_d2);
                $safety_officer_in_charge_sig2->setOffsetX(100);
                $safety_officer_in_charge_sig2->setOffsetY(10);

                $ems_manager_sig = new Drawing();
                $ems_manager_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['ems_manager_id'] .".png")));
                $ems_manager_sig->setHeight(50);
                $ems_manager_sig->setCoordinates((string)$result_h2);
                $ems_manager_sig->setOffsetX(100);
                $ems_manager_sig->setOffsetY(10);

                $over_all_safety_officer_sig2 = new Drawing();
                $over_all_safety_officer_sig2->setPath(public_path( ("/storage/e-signature/". $this->e_signature['over_all_safety_officer_id'] .".png")));
                $over_all_safety_officer_sig2->setHeight(50);
                $over_all_safety_officer_sig2->setCoordinates((string)$result_m2);
                $over_all_safety_officer_sig2->setOffsetX(100);
                $over_all_safety_officer_sig2->setOffsetY(10);

            }

            if ($this->workpermit_soic->status == 14){

                $project_in_charge_sig = new Drawing();
                $project_in_charge_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['project_in_charge'] .".png")));
                $project_in_charge_sig->setHeight(50);
                $project_in_charge_sig->setCoordinates((string)$result_d1);
                $project_in_charge_sig->setOffsetX(100);
                $project_in_charge_sig->setOffsetY(10);

                $safety_officer_in_charge_sig = new Drawing();
                $safety_officer_in_charge_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['safety_officer_in_charge_id'] .".png")));
                $safety_officer_in_charge_sig->setHeight(50);
                $safety_officer_in_charge_sig->setCoordinates((string)$result_h1);
                $safety_officer_in_charge_sig->setOffsetX(100);
                $safety_officer_in_charge_sig->setOffsetY(10);


                $over_all_safety_officer_sig = new Drawing();
                $over_all_safety_officer_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['over_all_safety_officer_id'] .".png")));
                $over_all_safety_officer_sig->setHeight(50);
                $over_all_safety_officer_sig->setCoordinates((string)$result_m1);
                $over_all_safety_officer_sig->setOffsetX(100);
                $over_all_safety_officer_sig->setOffsetY(10);

                $hrd_manager_sig = new Drawing();
                $hrd_manager_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['hrd_manager_id'] .".png")));
                $hrd_manager_sig->setHeight(50);
                $hrd_manager_sig->setCoordinates((string)$result_r1);
                $hrd_manager_sig->setOffsetX(30);
                $hrd_manager_sig->setOffsetY(10);

                $safety_officer_in_charge_sig2 = new Drawing();
                $safety_officer_in_charge_sig2->setPath(public_path( ("/storage/e-signature/". $this->e_signature['safety_officer_in_charge_id'] .".png")));
                $safety_officer_in_charge_sig2->setHeight(50);
                $safety_officer_in_charge_sig2->setCoordinates((string)$result_d2);
                $safety_officer_in_charge_sig2->setOffsetX(100);
                $safety_officer_in_charge_sig2->setOffsetY(10);

                $ems_manager_sig = new Drawing();
                $ems_manager_sig->setPath(public_path( ("/storage/e-signature/". $this->e_signature['ems_manager_id'] .".png")));
                $ems_manager_sig->setHeight(50);
                $ems_manager_sig->setCoordinates((string)$result_h2);
                $ems_manager_sig->setOffsetX(100);
                $ems_manager_sig->setOffsetY(10);

                $over_all_safety_officer_sig2 = new Drawing();
                $over_all_safety_officer_sig2->setPath(public_path( ("/storage/e-signature/". $this->e_signature['over_all_safety_officer_id'] .".png")));
                $over_all_safety_officer_sig2->setHeight(50);
                $over_all_safety_officer_sig2->setCoordinates((string)$result_m2);
                $over_all_safety_officer_sig2->setOffsetX(100);
                $over_all_safety_officer_sig2->setOffsetY(10);

                $hrd_manager_sig2 = new Drawing();
                $hrd_manager_sig2->setPath(public_path( ("/storage/e-signature/". $this->e_signature['hrd_manager_id'] .".png")));
                $hrd_manager_sig2->setHeight(50);
                $hrd_manager_sig2->setCoordinates((string)$result_r2);
                $hrd_manager_sig2->setOffsetX(30);
                $hrd_manager_sig2->setOffsetY(10);

            }


            return [$drawings, $project_in_charge_sig,$safety_officer_in_charge_sig,$over_all_safety_officer_sig,$hrd_manager_sig,$safety_officer_in_charge_sig2, $ems_manager_sig,$over_all_safety_officer_sig2,$hrd_manager_sig2,$contractor_pmi_soic];
        }

    public function collection()
    {
        // dd(WorkPermitInformation::all());
        return WorkPermitInformation::all();
        return Contractor::all();
    }




}
