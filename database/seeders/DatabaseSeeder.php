<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Responden;
use App\Models\NamaSurvey;
use App\Models\Profile;
use App\Models\Survey;
use Illuminate\Database\Seeder;
use Database\Seeders\SoalSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\SurveySeeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\ProfileSeeder;
use Database\Seeders\RespondenSeeder;
use Database\Seeders\NamaSurveySeeder;
use Database\Seeders\JawabanSoalSeeder;
use Database\Seeders\KategoriSoalSeeder;
use Database\Seeders\ProvinsiTableSeeder;
use Database\Seeders\KecamatanTableSeeder;
use Database\Seeders\DesaKelurahanTableSeeder;
use Database\Seeders\KabupatenKotaTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {


        # Start : Untuk Banyak Data Dummy
        // Responden::factory(1500)->create();

        // DB::table('nama_survey')->insert(array(
        //     0 =>
        //     array(
        //         'id' => 1,
        //         'nama' => 'Survey Develop',
        //         'tipe' => 'Pre',
        //         'deleted_at' => NULL,
        //         // 'created_at' => '2022-02-22 02:17:42',
        //         // 'updated_at' => '2022-02-22 02:17:42',
        //     ),
        // ));
        // NamaSurvey::factory(50)->create();

        // $data = [
        //     [
        //         'id' => 1,
        //         'username' => 'admin',
        //         'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        //         'status' => 1,
        //         'role' => 'Admin'
        //         ]
        //     ];
        // DB::table('users')->insert($data);

        // User::factory(50)->create();

        // $data2 = [
        //     [
        //         'id' => 1,
        //         'user_id' => 1,
        //         'nama_lengkap' => 'Administrator',
        //         'jenis_kelamin' => 'Laki-laki',
        //         'tempat_lahir' => 'Palopo',
        //         'tanggal_lahir' => '1997-09-07',
        //         'alamat' => 'Jl. Palopo',
        //         'provinsi' => 73,
        //         'kabupaten_kota' => 7373,
        //         'kecamatan' => 7373020,
        //         'desa_kelurahan' => 7373020003,
        //         'nomor_hp' => '081212121212',
        //         'email' => 'admin@gmail.com',
        //     ]
        // ];
        // DB::table('profiles')->insert($data2);
        // Profile::factory(50)->create();

        // Survey::factory(1000)->create();
        # End : Untuk Banyak Data Dummy




        // $this->call(RespondenSeeder::class);
        // $this->call(UserSeeder::class);
        // $this->call(ProfileSeeder::class);
        // $this->call(InstitusiSeeder::class);
        // $this->call(SurveySeeder::class);
        $this->call(ProvinsiTableSeeder::class);
        $this->call(KabupatenKotaTableSeeder::class);
        $this->call(KecamatanTableSeeder::class);
        $this->call(DesaKelurahanTableSeeder::class);
        $this->call(NamaSurveyTableSeeder::class);
        $this->call(KategoriSoalTableSeeder::class);
        $this->call(SoalTableSeeder::class);
        $this->call(JawabanSoalTableSeeder::class);
        $this->call(InstitusiTableSeeder::class);
        $this->call(ProfilesTableSeeder::class);
        $this->call(RespondenTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(LokasiSurveyTableSeeder::class);
        $this->call(JawabanSurveyTableSeeder::class);
        $this->call(SurveyTableSeeder::class);
        $this->call(LokasiSurveySupervisorTableSeeder::class);
        $this->call(AnggotaSupervisorTableSeeder::class);
    }
}
