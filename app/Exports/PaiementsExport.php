<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Models\Paiement;

class PaiementsExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithCustomStartCell, WithEvents
{
    protected $search;
    protected $dateDebut;
    protected $dateFin;

    public function __construct($search = null, $dateDebut = null, $dateFin = null)
    {
        $this->search = $search;
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Paiement::with(['serveuse', 'boisson']);

        if ($this->search) {
            $query->whereHas('serveuse', function($q) {
                $q->where('nom', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->dateDebut) {
            $query->where('date_paiement', '>=', $this->dateDebut);
        }

        if ($this->dateFin) {
            $query->where('date_paiement', '<=', $this->dateFin . ' 23:59:59');
        }

        return $query->orderBy('date_paiement', 'desc')->get()->map(function($paiement) {
            return [
                'date' => $paiement->date_paiement ? $paiement->date_paiement->format('d/m/Y H:i') : '-',
                'serveuse' => $paiement->serveuse ? $paiement->serveuse->nom : '-',
                'boisson' => $paiement->boisson ? $paiement->boisson->nom : '-',
                'quantite' => $paiement->quantite,
                'prix_unitaire' => $paiement->boisson ? $paiement->boisson->prix_unitaire : 0,
                'montant' => $paiement->montant,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Date',
            'Serveuse',
            'Boisson',
            'Quantité',
            'Prix unitaire (FCFA)',
            'Montant (FCFA)',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '10B981'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 25,
            'C' => 25,
            'D' => 12,
            'E' => 18,
            'F' => 18,
        ];
    }

    public function startCell(): string
    {
        return 'A4';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Titre principal
                $sheet->mergeCells('A1:F1');
                $sheet->setCellValue('A1', 'RAPPORT DES PAIEMENTS');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 18,
                        'color' => ['rgb' => '1E40AF'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Date de génération
                $sheet->mergeCells('A2:F2');
                $sheet->setCellValue('A2', 'Généré le: ' . now()->format('d/m/Y à H:i'));
                $sheet->getStyle('A2')->applyFromArray([
                    'font' => [
                        'size' => 11,
                        'color' => ['rgb' => '64748B'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Informations de filtre
                $filterInfo = 'Filtres: ';
                if ($this->search) {
                    $filterInfo .= 'Serveuse: ' . $this->search . ' | ';
                }
                if ($this->dateDebut) {
                    $filterInfo .= 'Du: ' . $this->dateDebut . ' | ';
                }
                if ($this->dateFin) {
                    $filterInfo .= 'Au: ' . $this->dateFin;
                }
                if (!$this->search && !$this->dateDebut && !$this->dateFin) {
                    $filterInfo = 'Tous les paiements';
                }

                $sheet->mergeCells('A3:F3');
                $sheet->setCellValue('A3', $filterInfo);
                $sheet->getStyle('A3')->applyFromArray([
                    'font' => [
                        'size' => 10,
                        'italic' => true,
                        'color' => ['rgb' => '64748B'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Style des en-têtes de colonnes
                $sheet->getStyle('A4:F4')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '059669'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '059669'],
                        ],
                    ],
                ]);

                // Ajuster la hauteur des lignes d'entête
                $sheet->getRowDimension(1)->setRowHeight(30);
                $sheet->getRowDimension(2)->setRowHeight(20);
                $sheet->getRowDimension(3)->setRowHeight(20);
                $sheet->getRowDimension(4)->setRowHeight(25);
            },
        ];
    }
}
