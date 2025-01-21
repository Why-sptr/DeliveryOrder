<?php

namespace App\Exports;

use App\Models\Reservation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ReservationsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    private $userId;
    private $startDate;
    private $endDate;

    public function __construct($userId = null, $startDate = null, $endDate = null)
    {
        $this->userId = $userId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * Mengambil data reservations untuk di-export.
     */
    public function collection()
    {
        $query = Reservation::with('user.idBadges')->orderBy('reservation_date', 'desc');

        if ($this->userId) {
            $query->where('user_id', $this->userId);
        }

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('reservation_date', [$this->startDate, $this->endDate]);
        }

        return $query->get();
    }

    /**
     * Menambahkan heading untuk file Excel.
     */
    public function headings(): array
    {
        return [
            'No', // Dinamis
            'Name',
            'No Reservation',
            'Badge',
            'Reservation Date',
            'Item',
            'Quantity',
        ];
    }

    /**
     * Mapping data untuk setiap baris.
     */
    public function map($reservation): array
    {
        static $rowNumber = 1; // Menyediakan nomor otomatis

        $badges = $reservation->user->idBadges->pluck('badge_name')->implode(', ');

        return [
            $rowNumber++, // No dinamis
            $reservation->user->name,
            $reservation->no_reservation,
            $badges,
            $reservation->reservation_date,
            $reservation->item,
            $reservation->quantity,
        ];
    }

    /**
     * Tambahkan style ke worksheet.
     */
    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow(); // Mendapatkan baris terakhir dengan data

        // Gaya umum untuk semua sel
        $sheet->getStyle("A1:G$lastRow")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'wrapText' => true,
            ],
        ]);

        // Header khusus
        $sheet->getStyle("A1:G1")->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '4CAF50'],
            ],
        ]);
    }
}
