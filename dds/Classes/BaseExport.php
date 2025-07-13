<?php

namespace Dds\Classes;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

abstract class BaseExport implements FromCollection, WithMapping, WithHeadings, WithStyles, WithColumnWidths
{
    protected $list;

    public function __construct($list)
    {
        $this->list = $list;
    }

    // implemente asc funcoes
    // public function headings(): array
    // {
    //     return  [
    //         '#'
    //     ];
    // }

    // public function columnWidths(): array
    // {
    //     return [
    //         'A' => 10,
    //     ];
    // }

    public function styles(Worksheet $sheet)
    {
        $lastColumn = $sheet->getHighestColumn();

        // cabeçalho
        $sheet->getRowDimension(1)->setRowHeight(25);
        $sheet->getStyle('A1:' . $lastColumn . '1')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'dddddd'
                ]
            ],
            'font' => [
                'bold' => true,
                'size' => 14,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // organizacao do conteudo
        for ($row = 2; $row <= $sheet->getHighestRow(); $row++) {
            $sheet->getRowDimension($row)->setRowHeight(20);
            $sheet->getStyle("A{$row}:" . $lastColumn . "{$row}")->applyFromArray([
                'font' => [
                    'size' => 12,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);
        }
    }

    public function collection()
    {
        return $this->list->map(function ($item, $key) {
            $item->qtd = $key + 1;
            return $item;
        });
    }
}
