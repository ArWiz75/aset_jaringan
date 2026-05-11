<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\OpdLocation;
use App\Models\Device;
use App\Models\MaintenanceLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin user
        $admin = User::create([
            'name' => 'Admin Kominfo',
            'email' => 'admin@kominfo.go.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Viewer user
        $viewer = User::create([
            'name' => 'Staf Kecamatan',
            'email' => 'staf@kecamatan.go.id',
            'password' => Hash::make('password'),
            'role' => 'viewer',
        ]);

        // Create OPD Locations
        $locations = [
            [
                'nama' => 'Dinas Komunikasi dan Informatika',
                'alamat' => 'Jl. Merdeka No. 1, Pusat Kota',
                'kecamatan' => 'Kecamatan Pusat',
                'latitude' => -6.9175,
                'longitude' => 107.6191,
                'kontak_person' => 'Budi Santoso',
                'telepon' => '022-1234567',
                'keterangan' => 'Gedung utama Diskominfo',
            ],
            [
                'nama' => 'Dinas Pendidikan',
                'alamat' => 'Jl. Pendidikan No. 10',
                'kecamatan' => 'Kecamatan Utara',
                'latitude' => -6.9100,
                'longitude' => 107.6200,
                'kontak_person' => 'Siti Nurhaliza',
                'telepon' => '022-2345678',
                'keterangan' => 'Kantor Dinas Pendidikan',
            ],
            [
                'nama' => 'Dinas Kesehatan',
                'alamat' => 'Jl. Sehat No. 5',
                'kecamatan' => 'Kecamatan Selatan',
                'latitude' => -6.9250,
                'longitude' => 107.6150,
                'kontak_person' => 'Dr. Ahmad',
                'telepon' => '022-3456789',
                'keterangan' => 'Kantor Dinas Kesehatan',
            ],
            [
                'nama' => 'Kantor Kecamatan Barat',
                'alamat' => 'Jl. Barat No. 15',
                'kecamatan' => 'Kecamatan Barat',
                'latitude' => -6.9180,
                'longitude' => 107.6100,
                'kontak_person' => 'Agus Prasetyo',
                'telepon' => '022-4567890',
                'keterangan' => 'Kantor Camat Barat',
            ],
            [
                'nama' => 'Dinas Pekerjaan Umum',
                'alamat' => 'Jl. Pembangunan No. 20',
                'kecamatan' => 'Kecamatan Timur',
                'latitude' => -6.9200,
                'longitude' => 107.6250,
                'kontak_person' => 'Hendra Wijaya',
                'telepon' => '022-5678901',
                'keterangan' => 'Kantor Dinas PU',
            ],
            [
                'nama' => 'Kantor Kecamatan Tengah',
                'alamat' => 'Jl. Tengah No. 8',
                'kecamatan' => 'Kecamatan Tengah',
                'latitude' => -6.9160,
                'longitude' => 107.6180,
                'kontak_person' => 'Rina Susanti',
                'telepon' => '022-6789012',
                'keterangan' => 'Kantor Camat Tengah',
            ],
        ];

        $opdLocations = [];
        foreach ($locations as $loc) {
            $opdLocations[] = OpdLocation::create($loc);
        }

        // Create Devices
        $devices = [
            // Diskominfo
            ['opd_location_id' => $opdLocations[0]->id, 'merk' => 'MikroTik', 'tipe' => 'Router', 'model' => 'RB750Gr3', 'nomor_seri' => 'MT-RTR-001', 'ip_address' => '192.168.1.1', 'status' => 'Aktif', 'tanggal_install' => '2024-01-15', 'mikrotik_backup_config' => "/ip address\nadd address=192.168.1.1/24 interface=ether1\n/ip dhcp-server\nadd address-pool=pool1 interface=ether1\n/ip firewall filter\nadd chain=input action=accept protocol=tcp dst-port=8291"],
            ['opd_location_id' => $opdLocations[0]->id, 'merk' => 'Cisco', 'tipe' => 'Switch', 'model' => 'Catalyst 2960', 'nomor_seri' => 'CS-SW-001', 'ip_address' => '192.168.1.2', 'status' => 'Aktif', 'tanggal_install' => '2024-01-15'],
            ['opd_location_id' => $opdLocations[0]->id, 'merk' => 'Ubiquiti', 'tipe' => 'Access Point', 'model' => 'UniFi AC Pro', 'nomor_seri' => 'UB-AP-001', 'ip_address' => '192.168.1.10', 'status' => 'Aktif', 'tanggal_install' => '2024-02-01'],
            ['opd_location_id' => $opdLocations[0]->id, 'merk' => 'MikroTik', 'tipe' => 'Firewall', 'model' => 'CCR1009', 'nomor_seri' => 'MT-FW-001', 'ip_address' => '192.168.1.254', 'status' => 'Aktif', 'tanggal_install' => '2024-01-10', 'mikrotik_backup_config' => "/ip firewall filter\nadd chain=forward action=drop protocol=tcp dst-port=445\n/ip firewall nat\nadd chain=srcnat action=masquerade out-interface=ether1"],

            // Dinas Pendidikan
            ['opd_location_id' => $opdLocations[1]->id, 'merk' => 'MikroTik', 'tipe' => 'Router', 'model' => 'hAP ac²', 'nomor_seri' => 'MT-RTR-002', 'ip_address' => '192.168.2.1', 'status' => 'Aktif', 'tanggal_install' => '2024-03-01'],
            ['opd_location_id' => $opdLocations[1]->id, 'merk' => 'TP-Link', 'tipe' => 'Switch', 'model' => 'TL-SG108', 'nomor_seri' => 'TP-SW-001', 'ip_address' => '192.168.2.2', 'status' => 'Rusak', 'tanggal_install' => '2023-06-15', 'keterangan' => 'Port 3-8 tidak berfungsi'],
            ['opd_location_id' => $opdLocations[1]->id, 'merk' => 'Ubiquiti', 'tipe' => 'Access Point', 'model' => 'UniFi 6 Lite', 'nomor_seri' => 'UB-AP-002', 'ip_address' => '192.168.2.10', 'status' => 'Aktif', 'tanggal_install' => '2024-03-05'],

            // Dinas Kesehatan
            ['opd_location_id' => $opdLocations[2]->id, 'merk' => 'MikroTik', 'tipe' => 'Router', 'model' => 'RB4011', 'nomor_seri' => 'MT-RTR-003', 'ip_address' => '192.168.3.1', 'status' => 'Maintenance', 'tanggal_install' => '2024-02-20'],
            ['opd_location_id' => $opdLocations[2]->id, 'merk' => 'D-Link', 'tipe' => 'Switch', 'model' => 'DGS-1210-28', 'nomor_seri' => 'DL-SW-001', 'ip_address' => '192.168.3.2', 'status' => 'Aktif', 'tanggal_install' => '2024-02-20'],
            ['opd_location_id' => $opdLocations[2]->id, 'merk' => 'TP-Link', 'tipe' => 'Access Point', 'model' => 'EAP245', 'nomor_seri' => 'TP-AP-001', 'ip_address' => '192.168.3.10', 'status' => 'Aktif', 'tanggal_install' => '2024-04-10'],

            // Kecamatan Barat
            ['opd_location_id' => $opdLocations[3]->id, 'merk' => 'MikroTik', 'tipe' => 'Router', 'model' => 'hAP lite', 'nomor_seri' => 'MT-RTR-004', 'ip_address' => '192.168.4.1', 'status' => 'Aktif', 'tanggal_install' => '2024-05-01'],
            ['opd_location_id' => $opdLocations[3]->id, 'merk' => 'TP-Link', 'tipe' => 'Access Point', 'model' => 'Archer C6', 'nomor_seri' => 'TP-AP-002', 'ip_address' => '192.168.4.10', 'status' => 'Nonaktif', 'tanggal_install' => '2023-11-01', 'keterangan' => 'Digantikan unit baru'],

            // Dinas PU
            ['opd_location_id' => $opdLocations[4]->id, 'merk' => 'MikroTik', 'tipe' => 'Router', 'model' => 'CCR1016', 'nomor_seri' => 'MT-RTR-005', 'ip_address' => '192.168.5.1', 'status' => 'Aktif', 'tanggal_install' => '2024-04-15', 'mikrotik_backup_config' => "/ip address\nadd address=192.168.5.1/24 interface=ether1\n/queue simple\nadd name=Bandwidth-Limit target=192.168.5.0/24 max-limit=100M/100M"],
            ['opd_location_id' => $opdLocations[4]->id, 'merk' => 'Cisco', 'tipe' => 'Switch', 'model' => 'SG350-28', 'nomor_seri' => 'CS-SW-002', 'ip_address' => '192.168.5.2', 'status' => 'Aktif', 'tanggal_install' => '2024-04-15'],
            ['opd_location_id' => $opdLocations[4]->id, 'merk' => 'Dell', 'tipe' => 'Server', 'model' => 'PowerEdge R740', 'nomor_seri' => 'DL-SRV-001', 'ip_address' => '192.168.5.100', 'status' => 'Aktif', 'tanggal_install' => '2024-01-01', 'keterangan' => 'Server utama aplikasi'],

            // Kecamatan Tengah
            ['opd_location_id' => $opdLocations[5]->id, 'merk' => 'MikroTik', 'tipe' => 'Router', 'model' => 'RB941-2nD', 'nomor_seri' => 'MT-RTR-006', 'ip_address' => '192.168.6.1', 'status' => 'Rusak', 'tanggal_install' => '2023-08-20', 'keterangan' => 'Board rusak, perlu penggantian'],
            ['opd_location_id' => $opdLocations[5]->id, 'merk' => 'Huawei', 'tipe' => 'Modem', 'model' => 'HG8245H5', 'nomor_seri' => 'HW-MDM-001', 'ip_address' => '192.168.6.254', 'status' => 'Aktif', 'tanggal_install' => '2024-01-10'],
        ];

        $createdDevices = [];
        foreach ($devices as $device) {
            $createdDevices[] = Device::create($device);
        }

        // Create Maintenance Logs
        $maintenanceLogs = [
            ['device_id' => $createdDevices[0]->id, 'user_id' => $admin->id, 'jenis' => 'Konfigurasi', 'deskripsi' => 'Update firmware RouterOS ke versi terbaru dan konfigurasi ulang firewall rules', 'tanggal' => '2024-06-15', 'biaya' => 0, 'status' => 'Selesai'],
            ['device_id' => $createdDevices[5]->id, 'user_id' => $admin->id, 'jenis' => 'Perbaikan', 'deskripsi' => 'Port 3-8 tidak berfungsi, perlu pengecekan board switch', 'tanggal' => '2024-07-01', 'biaya' => 250000, 'status' => 'Pending', 'catatan' => 'Menunggu spare part dari supplier'],
            ['device_id' => $createdDevices[7]->id, 'user_id' => $admin->id, 'jenis' => 'Preventif', 'deskripsi' => 'Pembersihan hardware dan pengecekan suhu operasional router', 'tanggal' => '2024-07-10', 'biaya' => 100000, 'status' => 'Selesai'],
            ['device_id' => $createdDevices[16]->id, 'user_id' => $admin->id, 'jenis' => 'Penggantian', 'deskripsi' => 'Board router rusak total, perlu penggantian unit baru', 'tanggal' => '2024-07-20', 'biaya' => 1500000, 'status' => 'Dalam Proses', 'catatan' => 'Unit pengganti sudah dipesan'],
            ['device_id' => $createdDevices[3]->id, 'user_id' => $admin->id, 'jenis' => 'Konfigurasi', 'deskripsi' => 'Update rule firewall untuk blokir port berbahaya', 'tanggal' => '2024-08-01', 'biaya' => 0, 'status' => 'Selesai'],
            ['device_id' => $createdDevices[12]->id, 'user_id' => $admin->id, 'jenis' => 'Konfigurasi', 'deskripsi' => 'Konfigurasi bandwidth management untuk seluruh jaringan', 'tanggal' => '2024-08-05', 'biaya' => 0, 'status' => 'Selesai'],
            ['device_id' => $createdDevices[11]->id, 'user_id' => $admin->id, 'jenis' => 'Penggantian', 'deskripsi' => 'Penggantian AP lama dengan unit baru yang mendukung WiFi 6', 'tanggal' => '2024-08-15', 'biaya' => 2000000, 'status' => 'Selesai', 'catatan' => 'Unit lama disimpan sebagai cadangan'],
            ['device_id' => $createdDevices[14]->id, 'user_id' => $admin->id, 'jenis' => 'Preventif', 'deskripsi' => 'Maintenance rutin server: update OS, cek disk health, backup data', 'tanggal' => '2024-09-01', 'biaya' => 0, 'status' => 'Selesai'],
        ];

        foreach ($maintenanceLogs as $log) {
            MaintenanceLog::create($log);
        }
    }
}
