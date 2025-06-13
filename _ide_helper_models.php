<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string $nama_lengkap
 * @property string $email
 * @property string|null $phone
 * @property string $level_akses
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PesananMakanan> $pesananMakanan
 * @property-read int|null $pesanan_makanan_count
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ValidasiFisik> $validasiFisik
 * @property-read int|null $validasi_fisik_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminHrga newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminHrga newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminHrga query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminHrga whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminHrga whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminHrga whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminHrga whereLevelAkses($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminHrga whereNamaLengkap($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminHrga wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminHrga whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminHrga whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminHrga whereUserId($value)
 */
	class AdminHrga extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $pesanan_makanan_id
 * @property int $karyawan_id
 * @property int $koki_id
 * @property int $qr_code_dinamis_id
 * @property \Illuminate\Support\Carbon $waktu_pengambilan
 * @property string $status_distribusi
 * @property string|null $catatan
 * @property array<array-key, mixed>|null $detail_validasi
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Karyawan $karyawan
 * @property-read \App\Models\Koki $koki
 * @property-read \App\Models\PesananMakanan $pesananMakanan
 * @property-read \App\Models\QrCodeDinamis $qrCodeDinamis
 * @method static \Database\Factories\DistribusiMakananFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistribusiMakanan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistribusiMakanan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistribusiMakanan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistribusiMakanan whereCatatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistribusiMakanan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistribusiMakanan whereDetailValidasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistribusiMakanan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistribusiMakanan whereKaryawanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistribusiMakanan whereKokiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistribusiMakanan wherePesananMakananId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistribusiMakanan whereQrCodeDinamisId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistribusiMakanan whereStatusDistribusi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistribusiMakanan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistribusiMakanan whereWaktuPengambilan($value)
 */
	class DistribusiMakanan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nama_divisi
 * @property string $kode_divisi
 * @property string|null $deskripsi
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Karyawan> $karyawan
 * @property-read int|null $karyawan_count
 * @method static \Database\Factories\DivisiFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Divisi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Divisi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Divisi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Divisi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Divisi whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Divisi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Divisi whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Divisi whereKodeDivisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Divisi whereNamaDivisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Divisi whereUpdatedAt($value)
 */
	class Divisi extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $divisi_id
 * @property int $shift_id
 * @property string $nip
 * @property string $nama_lengkap
 * @property string $email
 * @property string|null $phone
 * @property string $status_kerja
 * @property \Illuminate\Support\Carbon $tanggal_bergabung
 * @property bool $berhak_konsumsi
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DistribusiMakanan> $distribusiMakanan
 * @property-read int|null $distribusi_makanan_count
 * @property-read \App\Models\Divisi $divisi
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LogScanQr> $logScanQr
 * @property-read int|null $log_scan_qr_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\QrCodeDinamis> $qrCodeDinamis
 * @property-read int|null $qr_code_dinamis_count
 * @property-read \App\Models\Shift $shift
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StatusKonsumsi> $statusKonsumsi
 * @property-read int|null $status_konsumsi_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\KaryawanFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereBerhakKonsumsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereDivisiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereNamaLengkap($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereShiftId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereStatusKerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereTanggalBergabung($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereUserId($value)
 */
	class Karyawan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string $nama_lengkap
 * @property string $email
 * @property string|null $phone
 * @property string $status
 * @property array<array-key, mixed>|null $shift_bertugas
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DistribusiMakanan> $distribusiMakanan
 * @property-read int|null $distribusi_makanan_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LogScanQr> $logScanQr
 * @property-read int|null $log_scan_qr_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Koki newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Koki newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Koki query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Koki whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Koki whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Koki whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Koki whereNamaLengkap($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Koki wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Koki whereShiftBertugas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Koki whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Koki whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Koki whereUserId($value)
 */
	class Koki extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $key
 * @property string $value
 * @property string $group
 * @property string|null $description
 * @property string $type
 * @property bool $is_public
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KonfigurasiSistem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KonfigurasiSistem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KonfigurasiSistem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KonfigurasiSistem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KonfigurasiSistem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KonfigurasiSistem whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KonfigurasiSistem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KonfigurasiSistem whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KonfigurasiSistem whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KonfigurasiSistem whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KonfigurasiSistem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KonfigurasiSistem whereValue($value)
 */
	class KonfigurasiSistem extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $bulan
 * @property int $tahun
 * @property int $vendor_id
 * @property int $total_hari_operasional
 * @property int $total_porsi_dipesan
 * @property int $total_porsi_dikonsumsi
 * @property int $total_porsi_sisa
 * @property numeric $total_biaya
 * @property numeric $rata_rata_konsumsi_harian
 * @property numeric $persentase_efektivitas
 * @property array<array-key, mixed>|null $detail_per_shift
 * @property array<array-key, mixed>|null $detail_per_divisi
 * @property array<array-key, mixed>|null $trend_konsumsi
 * @property string|null $evaluasi
 * @property string|null $rekomendasi
 * @property int $dibuat_oleh
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AdminHrga $pembuat
 * @property-read \App\Models\Vendor $vendor
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanBulanan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanBulanan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanBulanan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanBulanan whereBulan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanBulanan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanBulanan whereDetailPerDivisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanBulanan whereDetailPerShift($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanBulanan whereDibuatOleh($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanBulanan whereEvaluasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanBulanan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanBulanan wherePersentaseEfektivitas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanBulanan whereRataRataKonsumsiHarian($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanBulanan whereRekomendasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanBulanan whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanBulanan whereTotalBiaya($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanBulanan whereTotalHariOperasional($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanBulanan whereTotalPorsiDikonsumsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanBulanan whereTotalPorsiDipesan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanBulanan whereTotalPorsiSisa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanBulanan whereTrendKonsumsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanBulanan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanBulanan whereVendorId($value)
 */
	class LaporanBulanan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $tanggal
 * @property int $shift_id
 * @property int $pesanan_makanan_id
 * @property int $total_karyawan_hadir
 * @property int $total_porsi_dipesan
 * @property int $total_porsi_dikonsumsi
 * @property int $total_porsi_sisa
 * @property numeric $persentase_konsumsi
 * @property array<array-key, mixed>|null $detail_per_divisi
 * @property string|null $catatan
 * @property int $dibuat_oleh
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AdminHrga $pembuat
 * @property-read \App\Models\PesananMakanan $pesananMakanan
 * @property-read \App\Models\Shift $shift
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanHarian newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanHarian newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanHarian query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanHarian whereCatatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanHarian whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanHarian whereDetailPerDivisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanHarian whereDibuatOleh($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanHarian whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanHarian wherePersentaseKonsumsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanHarian wherePesananMakananId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanHarian whereShiftId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanHarian whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanHarian whereTotalKaryawanHadir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanHarian whereTotalPorsiDikonsumsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanHarian whereTotalPorsiDipesan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanHarian whereTotalPorsiSisa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanHarian whereUpdatedAt($value)
 */
	class LaporanHarian extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $karyawan_id
 * @property int $koki_id
 * @property int|null $qr_code_dinamis_id
 * @property string $qr_token_scanned
 * @property \Illuminate\Support\Carbon $waktu_scan
 * @property string $hasil_scan
 * @property string|null $pesan_error
 * @property array<array-key, mixed>|null $detail_validasi
 * @property string|null $ip_scanner
 * @property string|null $device_info
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Karyawan $karyawan
 * @property-read \App\Models\Koki $koki
 * @property-read \App\Models\QrCodeDinamis|null $qrCodeDinamis
 * @method static \Database\Factories\LogScanQrFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogScanQr newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogScanQr newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogScanQr query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogScanQr whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogScanQr whereDetailValidasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogScanQr whereDeviceInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogScanQr whereHasilScan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogScanQr whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogScanQr whereIpScanner($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogScanQr whereKaryawanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogScanQr whereKokiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogScanQr wherePesanError($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogScanQr whereQrCodeDinamisId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogScanQr whereQrTokenScanned($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogScanQr whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogScanQr whereWaktuScan($value)
 */
	class LogScanQr extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string|null $email_verified_at
 * @property string $password
 * @property string $nama_lengkap
 * @property string $role
 * @property int $is_active
 * @property string|null $phone
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengguna newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengguna newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengguna query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengguna whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengguna whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengguna whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengguna whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengguna whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengguna whereNamaLengkap($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengguna wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengguna wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengguna whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengguna whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengguna whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengguna whereUsername($value)
 */
	class Pengguna extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $admin_hrga_id
 * @property int $vendor_id
 * @property int $shift_id
 * @property \Illuminate\Support\Carbon $tanggal_pesanan
 * @property int $jumlah_porsi_dipesan
 * @property numeric $total_harga
 * @property string $status_pesanan
 * @property \Illuminate\Support\Carbon|null $waktu_pengiriman_estimasi
 * @property string|null $catatan_pesanan
 * @property array<array-key, mixed>|null $menu_detail
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AdminHrga $adminHrga
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DistribusiMakanan> $distribusiMakanan
 * @property-read int|null $distribusi_makanan_count
 * @property-read \App\Models\LaporanHarian|null $laporanHarian
 * @property-read \App\Models\Shift $shift
 * @property-read \App\Models\ValidasiFisik|null $validasiFisik
 * @property-read \App\Models\Vendor $vendor
 * @method static \Database\Factories\PesananMakananFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PesananMakanan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PesananMakanan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PesananMakanan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PesananMakanan whereAdminHrgaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PesananMakanan whereCatatanPesanan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PesananMakanan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PesananMakanan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PesananMakanan whereJumlahPorsiDipesan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PesananMakanan whereMenuDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PesananMakanan whereShiftId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PesananMakanan whereStatusPesanan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PesananMakanan whereTanggalPesanan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PesananMakanan whereTotalHarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PesananMakanan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PesananMakanan whereVendorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PesananMakanan whereWaktuPengirimanEstimasi($value)
 */
	class PesananMakanan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $karyawan_id
 * @property string $qr_token
 * @property string $qr_hash
 * @property \Illuminate\Support\Carbon $created_at_qr
 * @property \Illuminate\Support\Carbon $expired_at
 * @property bool $is_used
 * @property \Illuminate\Support\Carbon|null $used_at
 * @property string|null $generated_ip
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Karyawan $karyawan
 * @method static \Database\Factories\QrCodeDinamisFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QrCodeDinamis newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QrCodeDinamis newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QrCodeDinamis query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QrCodeDinamis whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QrCodeDinamis whereCreatedAtQr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QrCodeDinamis whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QrCodeDinamis whereGeneratedIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QrCodeDinamis whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QrCodeDinamis whereIsUsed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QrCodeDinamis whereKaryawanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QrCodeDinamis whereQrHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QrCodeDinamis whereQrToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QrCodeDinamis whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QrCodeDinamis whereUsedAt($value)
 */
	class QrCodeDinamis extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nama_shift
 * @property string $jam_mulai
 * @property string $jam_selesai
 * @property string $jam_makan_mulai
 * @property string $jam_makan_selesai
 * @property string|null $keterangan
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Karyawan> $karyawan
 * @property-read int|null $karyawan_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LaporanHarian> $laporanHarian
 * @property-read int|null $laporan_harian_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PesananMakanan> $pesananMakanan
 * @property-read int|null $pesanan_makanan_count
 * @method static \Database\Factories\ShiftFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereJamMakanMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereJamMakanSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereJamMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereJamSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereNamaShift($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereUpdatedAt($value)
 */
	class Shift extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $karyawan_id
 * @property \Illuminate\Support\Carbon $tanggal
 * @property int $shift_id
 * @property bool $sudah_konsumsi
 * @property \Illuminate\Support\Carbon|null $waktu_konsumsi
 * @property string $status_kehadiran
 * @property string|null $catatan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Karyawan $karyawan
 * @property-read \App\Models\Shift $shift
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StatusKonsumsi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StatusKonsumsi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StatusKonsumsi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StatusKonsumsi whereCatatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StatusKonsumsi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StatusKonsumsi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StatusKonsumsi whereKaryawanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StatusKonsumsi whereShiftId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StatusKonsumsi whereStatusKehadiran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StatusKonsumsi whereSudahKonsumsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StatusKonsumsi whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StatusKonsumsi whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StatusKonsumsi whereWaktuKonsumsi($value)
 */
	class StatusKonsumsi extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AdminHrga|null $adminHrga
 * @property-read \App\Models\Karyawan|null $karyawan
 * @property-read \App\Models\Koki|null $koki
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $pesanan_makanan_id
 * @property int $admin_hrga_id
 * @property int $jumlah_fisik_diterima
 * @property int $jumlah_kurang
 * @property int $jumlah_rusak
 * @property string $status_validasi
 * @property string|null $catatan_validasi
 * @property \Illuminate\Support\Carbon $waktu_validasi
 * @property array<array-key, mixed>|null $foto_bukti
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AdminHrga $adminHrga
 * @property-read \App\Models\PesananMakanan $pesananMakanan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ValidasiFisik newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ValidasiFisik newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ValidasiFisik query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ValidasiFisik whereAdminHrgaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ValidasiFisik whereCatatanValidasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ValidasiFisik whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ValidasiFisik whereFotoBukti($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ValidasiFisik whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ValidasiFisik whereJumlahFisikDiterima($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ValidasiFisik whereJumlahKurang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ValidasiFisik whereJumlahRusak($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ValidasiFisik wherePesananMakananId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ValidasiFisik whereStatusValidasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ValidasiFisik whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ValidasiFisik whereWaktuValidasi($value)
 */
	class ValidasiFisik extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nama_vendor
 * @property string $kontak_person
 * @property string $email
 * @property string $phone
 * @property string $alamat
 * @property string $status_kontrak
 * @property \Illuminate\Support\Carbon $tanggal_kontrak_mulai
 * @property \Illuminate\Support\Carbon $tanggal_kontrak_berakhir
 * @property numeric $harga_per_porsi
 * @property string|null $catatan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LaporanBulanan> $laporanBulanan
 * @property-read int|null $laporan_bulanan_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PesananMakanan> $pesananMakanan
 * @property-read int|null $pesanan_makanan_count
 * @method static \Database\Factories\VendorFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereCatatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereHargaPerPorsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereKontakPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereNamaVendor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereStatusKontrak($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereTanggalKontrakBerakhir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereTanggalKontrakMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vendor whereUpdatedAt($value)
 */
	class Vendor extends \Eloquent {}
}

