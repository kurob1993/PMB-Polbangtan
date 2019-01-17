<?php

use App\Jurusan;
use App\Libs\Services\SerialNumberService;
use App\Pendaftaran;
use App\SerialNumber;
use App\Siswa;
use Illuminate\Database\Seeder;

use App\Pegawai;
use App\User;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');

    	$pegawai = Pegawai::create([
    		'institusi_id' => 0,
    		'nama' => 'Admin Pusat'
    	]);
        $user = User::create([
        	'name' => $pegawai->nama,
        	'email' => 'adminpst@polbangtan.com',
        	'password' => bcrypt('123456'),
        	'status' => 1,
        	'person_id' => $pegawai->getKey(),
        	'person_type' => 'admin'
        ]);
        $user->assignRole(config('rolepermission.roles.admin_pusat.name'));

        for ( $i=1; $i<=7; $i++ ) {
	    	$pegawai = Pegawai::create([
	    		'institusi_id' => $i,
	    		'nama' => 'Operator'
	    	]);
	        $user = User::create([
	        	'name' => $pegawai->nama,
	        	'email' => "admin$i@polbangtan.com",
	        	'password' => bcrypt('123456'),
	        	'status' => 1,
	        	'person_id' => $pegawai->getKey(),
	        	'person_type' => 'operator'
	        ]);
	        $user->assignRole(config('rolepermission.roles.operator.name'));
        }

        $jalur = ['tugas-belajar', 'undangan-smk', 'undangan-petani', 'kerjasama-pemda', 'umum'];

        foreach ($jalur as $value) {
            for ($i=0; $i<100; $i++) {
                $siswa = Siswa::create([
                    'nisn' => 'demo',
                    'nama' => $faker->name,
                    'alamat' => 'demo',
                    'kelurahan' => 'demo',
                    'kecamatan' => 'demo',
                    'kota' => 'demo',
                    'provinsi' => 'demo',
                    'kode_pos' => 'demo',
                    'tempat_lahir' => 'demo',
                    'tanggal_lahir' => 'demo',
                    'jenis_kelamin' => 'demo',
                    'ktp' => 'demo',
                    'tipe_sekolah' => '2',
                    'nama_sekolah' => 'demo',
                    'alamat_sekolah' => 'demo',
                    'no_telepon_sekolah' => 'demo',
                    'jurusan' => '21',
                    'tahun_lulus' => '2018',
                    'no_ijazah' => 'demo',
                    'ijazah' => 'demo',
                    'tinggi_badan' => '180',
                    'sk_sehat' => 'demo',
                    'sk_tidak_hamil' => 'demo',
                    'foto' => 'demo'
                ]);

                $user = User::create([
                    'name' => $siswa->nama,
                    'email' => $faker->unique()->safeEmail,
                    'password' => bcrypt(123456),
                    'person_id' => $siswa->getKey(),
                    'person_type' => 'siswa',
                    'status' => 1
                ]);
                $user->assignRole(config('rolepermission.roles.siswa.name'));

                $serial = new SerialNumberService(new SerialNumber());
                $no_pendaftaran = $serial->getSerialNumber(5);

                Pendaftaran::create([
                    'no_pendaftaran' => $no_pendaftaran,
                    'siswa_id' => $siswa->getKey(),
                    'jalur' => $value,
                    'institusi' => 5,
                    'jurusan_1' => 21,
                    'jurusan_2' => 22,
                    'state' => 'verifikasi_dokumen'
                ]);
            }
        }
    }
}
