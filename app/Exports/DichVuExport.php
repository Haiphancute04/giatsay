<?php

namespace App\Exports;

use App\Models\DichVu;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize; 
use Maatwebsite\Excel\Concerns\WithStyles;     
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DichVuExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return DichVu::with('danhMuc')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tên Dịch Vụ',
            'Danh Mục',
            'Mô Tả',
            'Đơn Giá (VNĐ)',
            'Đơn Giá Tối Đa (VNĐ)',
            'Đơn Vị Tính',
            'Là Giá Dao Động', 
           
            'Trung Bình Đánh Giá',
            'Đường Dẫn Hình Ảnh', 
        ];
    }

    public function map($dichVu): array
    {
        return [
            $dichVu->id,
            $dichVu->tendichvu ?? '', 
            $dichVu->danhMuc ? $dichVu->danhMuc->tendanhmuc : 'Chưa phân loại', 
            $dichVu->motadichvu ?? '', 
            
            $dichVu->dongia ?? 0,
            $dichVu->dongia_toida ?? 0, 
            
            $dichVu->donvitinh ?? '',
            
            $dichVu->la_gia_dao_dong ? 'Có' : 'Không', 
            
           
            $dichVu->rating_trungbinh ?? 0,
            
            $dichVu->hinhanh ,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}