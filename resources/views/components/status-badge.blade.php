@props(['status'])

@php
    $badgeClass = '';
    switch (strtolower($status)) {
        case 'aktif':
        case 'sesuai':
        case 'berhasil':
            $badgeClass = 'text-bg-success';
            break;
        case 'non_aktif':
        case 'gagal':
        case 'dibatalkan':
            $badgeClass = 'text-bg-danger';
            break;
        case 'cuti':
        case 'draft':
            $badgeClass = 'text-bg-secondary';
            break;
        case 'sakit':
        case 'dikirim':
            $badgeClass = 'text-bg-warning';
            break;
        default:
            $badgeClass = 'text-bg-primary';
    }
@endphp

<span class="badge {{ $badgeClass }}">{{ ucfirst($status) }}</span>