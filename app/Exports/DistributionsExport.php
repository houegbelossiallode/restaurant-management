<?php

namespace App\Exports;

use App\Models\Distribution;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DistributionsExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithCustomStartCell, WithEvents
{
    public function __construct(
        private ?string $search = null,
        private ?string $dateDebut = null,
        private ?string $dateFin = null
    ) {}

    public function collection(): Collection
    {
        $query = Distribution::with(['serveuse', 'boisson']);

        if ($this->search) {
            $search = trim($this->search);
            $query->where(function ($query) use ($search) {
                $query->whereHas('serveuse', function ($serveuseQuery) use ($search) {
                    $serveuseQuery->where('nom', 'like', '%' . $search . '%');
                })->orWhereHas('boisson', function ($boissonQuery) use ($search) {
                    $boissonQuery->where('nom', 'like', '%' . $search . '%');
                });
            });
        }

        if ($this->dateDebut) {
            $query->where('date_distribution', '>=', $this->dateDebut);
        }

        if ($this->dateFin) {
            $query->where('date_distribution', '<=', $this->dateFin . ' 23:59:59');
        }

        $rows = $query->orderBy('date_distribution', 'desc')->get()->map(function ($distribution) {
            return [
                'date' => $distribution->date_distribution?->format('d/m/Y H:i') ?? '-',
                'serveuse' => $distribution->serveuse?->nom ?? '-',
                'boisson' => $distribution->boisson?->nom ?? '-',
                'quantite' => $distribution->quantite,
                'prix_unitaire' => $distribution->prix_unitaire,
                'montant' => $distribution->prix_unitaire * $distribution->quantite,
            ];
        });

        $rows->push([
            'date' => 'TOTAL DES MONTANTS',
            'serveuse' => '',
            'boisson' => '',
            'quantite' => '',
            'prix_unitaire' => '',
            'montant' => $rows->sum('montant'),
        ]);

        return $rows;
    }

    public function headings(): array
    {
        return ['Date', 'Serveuse', 'Boisson', 'Quantité', 'Prix unitaire (FCFA)', 'Montant (FCFA)'];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            4 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '2563EB'],
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return ['A' => 20, 'B' => 25, 'C' => 25, 'D' => 12, 'E' => 20, 'F' => 20];
    }

    public function startCell(): string
    {
        return 'A4';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->mergeCells('A1:F1');
                $sheet->setCellValue('A1', 'RAPPORT DES DISTRIBUTIONS');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 18, 'color' => ['rgb' => '1E40AF']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $sheet->mergeCells('A2:F2');
                $sheet->setCellValue('A2', 'Généré le: ' . now()->format('d/m/Y à H:i'));
                $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $filterInfo = 'Filtres: ' . ($this->search ?: 'Toutes les distributions');
                if ($this->dateDebut) {
                    $filterInfo .= ' | Du: ' . $this->dateDebut;
                }
                if ($this->dateFin) {
                    $filterInfo .= ' | Au: ' . $this->dateFin;
                }
                $sheet->mergeCells('A3:F3');
                $sheet->setCellValue('A3', $filterInfo);
                $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $totalRow = $sheet->getHighestRow();
                $sheet->mergeCells("A{$totalRow}:E{$totalRow}");
                $sheet->getStyle("A{$totalRow}:F{$totalRow}")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'DBEAFE'],
                    ],
                    'borders' => [
                        'top' => [
                            'borderStyle' => Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '2563EB'],
                        ],
                    ],
                ]);
                $sheet->getStyle("F{$totalRow}")->getNumberFormat()->setFormatCode('#,##0 "FCFA"');
            },
        ];
    }
}