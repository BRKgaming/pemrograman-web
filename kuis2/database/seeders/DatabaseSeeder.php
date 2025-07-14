<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate all tables
        DB::table('regionals')->truncate();
        DB::table('societies')->truncate();
        DB::table('users')->truncate();
        DB::table('validators')->truncate();
        DB::table('job_categories')->truncate();
        DB::table('job_vacancies')->truncate();
        DB::table('available_positions')->truncate();
        DB::table('validations')->truncate();
        DB::table('job_apply_societies')->truncate();
        DB::table('job_apply_positions')->truncate();

        // Regionals
        DB::table('regionals')->insert([
            ['id' => 1, 'province' => 'DKI Jakarta', 'district' => 'Central Jakarta'],
            ['id' => 2, 'province' => 'DKI Jakarta', 'district' => 'South Jakarta'],
            ['id' => 3, 'province' => 'West Java', 'district' => 'Bandung'],
        ]);

        // Societies
        $societies = [
            ['id' => 1, 'id_card_number' => '20210001', 'password' => Hash::make('121212'), 'name' => 'Omar Gunawan', 'born_date' => '1990-04-18', 'gender' => 'male', 'address' => 'Jln. Baranang Siang No. 479, DKI Jakarta', 'regional_id' => 1],
            ['id' => 2, 'id_card_number' => '20210002', 'password' => Hash::make('121212'), 'name' => 'Nilam Sinaga', 'born_date' => '1998-09-11', 'gender' => 'female', 'address' => 'Gg. Sukajadi No. 26, DKI Jakarta', 'regional_id' => 1],
            ['id' => 3, 'id_card_number' => '20210003', 'password' => Hash::make('121212'), 'name' => 'Rosman Lailasari', 'born_date' => '1983-02-12', 'gender' => 'male', 'address' => 'Jln. Moch. Ramdan No. 242, DKI Jakarta', 'regional_id' => 1],
            ['id' => 4, 'id_card_number' => '20210004', 'password' => Hash::make('121212'), 'name' => 'Ifa Adriansyah', 'born_date' => '1993-05-17', 'gender' => 'female', 'address' => 'Gg. Setia Budi No. 215, DKI Jakarta', 'regional_id' => 1],
            ['id' => 5, 'id_card_number' => '20210005', 'password' => Hash::make('121212'), 'name' => 'Sakura Susanti', 'born_date' => '1973-11-05', 'gender' => 'male', 'address' => 'Kpg. B.Agam 1 No. 729, DKI Jakarta', 'regional_id' => 1],
            ['id' => 6, 'id_card_number' => '20210006', 'password' => Hash::make('121212'), 'name' => 'Jail Utama', 'born_date' => '2001-12-28', 'gender' => 'male', 'address' => 'Kpg. Cikutra Timur No. 57, DKI Jakarta', 'regional_id' => 1],
            ['id' => 7, 'id_card_number' => '20210007', 'password' => Hash::make('121212'), 'name' => 'Gawati Wibowo', 'born_date' => '1971-08-23', 'gender' => 'male', 'address' => 'Kpg. Bara No. 346, DKI Jakarta', 'regional_id' => 1],
            ['id' => 8, 'id_card_number' => '20210008', 'password' => Hash::make('121212'), 'name' => 'Pia Rajata', 'born_date' => '1976-08-04', 'gender' => 'male', 'address' => 'Kpg. Yohanes No. 445, DKI Jakarta', 'regional_id' => 1],
            ['id' => 9, 'id_card_number' => '20210009', 'password' => Hash::make('121212'), 'name' => 'Darmaji Suartini', 'born_date' => '1999-10-05', 'gender' => 'male', 'address' => 'Gg. Kusmanto No. 622, DKI Jakarta', 'regional_id' => 1],
            ['id' => 10, 'id_card_number' => '20210010', 'password' => Hash::make('121212'), 'name' => 'Kiandra Tamba', 'born_date' => '1988-05-31', 'gender' => 'male', 'address' => 'Ki. Sutarto No. 66, DKI Jakarta', 'regional_id' => 1],
            ['id' => 11, 'id_card_number' => '20210011', 'password' => Hash::make('121212'), 'name' => 'Manah Thamrin', 'born_date' => '1989-06-20', 'gender' => 'female', 'address' => 'Jln. Baung No. 871, DKI Jakarta', 'regional_id' => 1],
            ['id' => 12, 'id_card_number' => '20210012', 'password' => Hash::make('121212'), 'name' => 'Banara Ardianto', 'born_date' => '1978-10-27', 'gender' => 'male', 'address' => 'Ki. Yos Sudarso No. 411, DKI Jakarta', 'regional_id' => 1],
            ['id' => 13, 'id_card_number' => '20210013', 'password' => Hash::make('121212'), 'name' => 'Anggabaya Mustofa', 'born_date' => '1979-05-11', 'gender' => 'female', 'address' => 'Psr. Pacuan Kuda No. 351, DKI Jakarta', 'regional_id' => 1],
            ['id' => 14, 'id_card_number' => '20210014', 'password' => Hash::make('121212'), 'name' => 'Emong Purnawati', 'born_date' => '1979-07-15', 'gender' => 'male', 'address' => 'Jln. Jayawijaya No. 141, DKI Jakarta', 'regional_id' => 1],
            ['id' => 15, 'id_card_number' => '20210015', 'password' => Hash::make('121212'), 'name' => 'Nardi Pertiwi', 'born_date' => '1981-05-14', 'gender' => 'male', 'address' => 'Psr. Barasak No. 554, DKI Jakarta', 'regional_id' => 1],
            ['id' => 16, 'id_card_number' => '20210016', 'password' => Hash::make('121212'), 'name' => 'Ina Nasyiah', 'born_date' => '1971-05-21', 'gender' => 'female', 'address' => 'Ds. Suryo No. 100, DKI Jakarta', 'regional_id' => 2],
            ['id' => 17, 'id_card_number' => '20210017', 'password' => Hash::make('121212'), 'name' => 'Jinawi Wastuti', 'born_date' => '1994-06-18', 'gender' => 'male', 'address' => 'Ki. Sugiono No. 918, DKI Jakarta', 'regional_id' => 2],
            ['id' => 18, 'id_card_number' => '20210018', 'password' => Hash::make('121212'), 'name' => 'Marsudi Utama', 'born_date' => '1979-06-04', 'gender' => 'female', 'address' => 'Kpg. Cikapayang No. 229, DKI Jakarta', 'regional_id' => 2],
            ['id' => 19, 'id_card_number' => '20210019', 'password' => Hash::make('121212'), 'name' => 'Ilsa Gunarto', 'born_date' => '1992-06-11', 'gender' => 'female', 'address' => 'Gg. Baing No. 871, DKI Jakarta', 'regional_id' => 2],
            ['id' => 20, 'id_card_number' => '20210020', 'password' => Hash::make('121212'), 'name' => 'Hani Pratiwi', 'born_date' => '1990-07-10', 'gender' => 'male', 'address' => 'Dk. Yap Tjwan Bing No. 528, DKI Jakarta', 'regional_id' => 2],
            ['id' => 21, 'id_card_number' => '20210021', 'password' => Hash::make('121212'), 'name' => 'Najwa Pratiwi', 'born_date' => '1996-11-05', 'gender' => 'male', 'address' => 'Kpg. Raden No. 688, DKI Jakarta', 'regional_id' => 2],
            ['id' => 22, 'id_card_number' => '20210022', 'password' => Hash::make('121212'), 'name' => 'Samiah Haryanto', 'born_date' => '1985-10-26', 'gender' => 'male', 'address' => 'Gg. Juanda No. 863, DKI Jakarta', 'regional_id' => 2],
            ['id' => 23, 'id_card_number' => '20210023', 'password' => Hash::make('121212'), 'name' => 'Olga Safitri', 'born_date' => '1971-03-04', 'gender' => 'male', 'address' => 'Psr. Ir. H. Juanda No. 728, DKI Jakarta', 'regional_id' => 2],
            ['id' => 24, 'id_card_number' => '20210024', 'password' => Hash::make('121212'), 'name' => 'Halim Winarsih', 'born_date' => '1974-11-16', 'gender' => 'male', 'address' => 'Dk. Nakula No. 730, DKI Jakarta', 'regional_id' => 2],
            ['id' => 25, 'id_card_number' => '20210025', 'password' => Hash::make('121212'), 'name' => 'Vivi Widodo', 'born_date' => '1988-09-19', 'gender' => 'male', 'address' => 'Kpg. Astana Anyar No. 983, DKI Jakarta', 'regional_id' => 2],
            ['id' => 26, 'id_card_number' => '20210026', 'password' => Hash::make('121212'), 'name' => 'Dian Firmansyah', 'born_date' => '1985-04-01', 'gender' => 'male', 'address' => 'Kpg. Baha No. 855, DKI Jakarta', 'regional_id' => 2],
            ['id' => 27, 'id_card_number' => '20210027', 'password' => Hash::make('121212'), 'name' => 'Patricia Usada', 'born_date' => '1986-08-28', 'gender' => 'male', 'address' => 'Psr. Ters. Jakarta No. 993, DKI Jakarta', 'regional_id' => 2],
            ['id' => 28, 'id_card_number' => '20210028', 'password' => Hash::make('121212'), 'name' => 'Soleh Mandasari', 'born_date' => '1988-09-28', 'gender' => 'female', 'address' => 'Ki. Flores No. 869, DKI Jakarta', 'regional_id' => 2],
            ['id' => 29, 'id_card_number' => '20210029', 'password' => Hash::make('121212'), 'name' => 'Kamal Pranowo', 'born_date' => '1976-08-10', 'gender' => 'male', 'address' => 'Jln. Baung No. 80, DKI Jakarta', 'regional_id' => 2],
            ['id' => 30, 'id_card_number' => '20210030', 'password' => Hash::make('121212'), 'name' => 'Ade Kusmawati', 'born_date' => '1996-08-29', 'gender' => 'male', 'address' => 'Jln. Kiaracondong No. 398, DKI Jakarta', 'regional_id' => 2],
            ['id' => 31, 'id_card_number' => '20210031', 'password' => Hash::make('121212'), 'name' => 'Irwan Sinaga', 'born_date' => '1976-10-06', 'gender' => 'female', 'address' => 'Dk. Basmol Raya No. 714, West Java', 'regional_id' => 3],
            ['id' => 32, 'id_card_number' => '20210032', 'password' => Hash::make('121212'), 'name' => 'Lulut Lestari', 'born_date' => '1981-03-31', 'gender' => 'male', 'address' => 'Ds. Cihampelas No. 933, West Java', 'regional_id' => 3],
            ['id' => 33, 'id_card_number' => '20210033', 'password' => Hash::make('121212'), 'name' => 'Balijan Rahimah', 'born_date' => '1972-04-25', 'gender' => 'female', 'address' => 'Ki. Ciwastra No. 539, West Java', 'regional_id' => 3],
            ['id' => 34, 'id_card_number' => '20210034', 'password' => Hash::make('121212'), 'name' => 'Kasiyah Sitompul', 'born_date' => '1975-01-14', 'gender' => 'male', 'address' => 'Dk. Sutarto No. 434, West Java', 'regional_id' => 3],
            ['id' => 35, 'id_card_number' => '20210035', 'password' => Hash::make('121212'), 'name' => 'Wulan Nasyidah', 'born_date' => '1974-11-04', 'gender' => 'male', 'address' => 'Dk. Mahakam No. 367, West Java', 'regional_id' => 3],
            ['id' => 36, 'id_card_number' => '20210036', 'password' => Hash::make('121212'), 'name' => 'Damar Palastri', 'born_date' => '1981-03-24', 'gender' => 'female', 'address' => 'Jr. Teuku Umar No. 547, West Java', 'regional_id' => 3],
            ['id' => 37, 'id_card_number' => '20210037', 'password' => Hash::make('121212'), 'name' => 'Gamanto Simanjuntak', 'born_date' => '1972-01-13', 'gender' => 'female', 'address' => 'Jln. Salam No. 421, West Java', 'regional_id' => 3],
            ['id' => 38, 'id_card_number' => '20210038', 'password' => Hash::make('121212'), 'name' => 'Lukita Gunarto', 'born_date' => '1998-11-27', 'gender' => 'female', 'address' => 'Jr. HOS. Cjokroaminoto (Pasirkaliki) No. 9, West Java', 'regional_id' => 3],
            ['id' => 39, 'id_card_number' => '20210039', 'password' => Hash::make('121212'), 'name' => 'Malika Nashiruddin', 'born_date' => '1989-07-05', 'gender' => 'male', 'address' => 'Psr. Kartini No. 960, West Java', 'regional_id' => 3],
            ['id' => 40, 'id_card_number' => '20210040', 'password' => Hash::make('121212'), 'name' => 'Siska Hutapea', 'born_date' => '1972-03-30', 'gender' => 'female', 'address' => 'Ki. Wora Wari No. 501, West Java', 'regional_id' => 3],
            ['id' => 41, 'id_card_number' => '20210041', 'password' => Hash::make('121212'), 'name' => 'Laras Sirait', 'born_date' => '1971-01-13', 'gender' => 'male', 'address' => 'Psr. Basmol Raya No. 859, West Java', 'regional_id' => 3],
            ['id' => 42, 'id_card_number' => '20210042', 'password' => Hash::make('121212'), 'name' => 'Embuh Mulyani', 'born_date' => '1996-08-05', 'gender' => 'male', 'address' => 'Kpg. Wahidin No. 512, West Java', 'regional_id' => 3],
            ['id' => 43, 'id_card_number' => '20210043', 'password' => Hash::make('121212'), 'name' => 'Mutia Nashiruddin', 'born_date' => '1985-05-08', 'gender' => 'female', 'address' => 'Ds. Hang No. 765, West Java', 'regional_id' => 3],
            ['id' => 44, 'id_card_number' => '20210044', 'password' => Hash::make('121212'), 'name' => 'Pangestu Lazuardi', 'born_date' => '2001-08-02', 'gender' => 'male', 'address' => 'Dk. Bass No. 886, West Java', 'regional_id' => 3],
            ['id' => 45, 'id_card_number' => '20210045', 'password' => Hash::make('121212'), 'name' => 'Gaduh Suwarno', 'born_date' => '1971-07-27', 'gender' => 'female', 'address' => 'Psr. Basuki No. 591, West Java', 'regional_id' => 3],
        ];

        DB::table('societies')->insert($societies);

        // Users
        $users = [
            ['id' => 1, 'username' => 'validator2', 'password' => Hash::make('121212')],
            ['id' => 2, 'username' => 'validator3', 'password' => Hash::make('121212')],
            ['id' => 3, 'username' => 'validator4', 'password' => Hash::make('121212')],
            ['id' => 4, 'username' => 'officer2', 'password' => Hash::make('121212')],
            ['id' => 5, 'username' => 'officer3', 'password' => Hash::make('121212')],
            ['id' => 6, 'username' => 'validator5', 'password' => Hash::make('121212')],
            ['id' => 7, 'username' => 'validator6', 'password' => Hash::make('121212')],
            ['id' => 8, 'username' => 'validator7', 'password' => Hash::make('121212')],
            ['id' => 9, 'username' => 'officer5', 'password' => Hash::make('121212')],
            ['id' => 10, 'username' => 'officer6', 'password' => Hash::make('121212')],
            ['id' => 11, 'username' => 'validator8', 'password' => Hash::make('121212')],
            ['id' => 12, 'username' => 'validator9', 'password' => Hash::make('121212')],
            ['id' => 13, 'username' => 'validator10', 'password' => Hash::make('121212')],
            ['id' => 14, 'username' => 'officer8', 'password' => Hash::make('121212')],
            ['id' => 15, 'username' => 'officer9', 'password' => Hash::make('121212')],
            ['id' => 16, 'username' => 'validator11', 'password' => Hash::make('121212')],
            ['id' => 17, 'username' => 'validator12', 'password' => Hash::make('121212')],
            ['id' => 18, 'username' => 'validator13', 'password' => Hash::make('121212')],
            ['id' => 19, 'username' => 'officer11', 'password' => Hash::make('121212')],
            ['id' => 20, 'username' => 'officer12', 'password' => Hash::make('121212')],
            ['id' => 21, 'username' => 'validator14', 'password' => Hash::make('121212')],
            ['id' => 22, 'username' => 'validator15', 'password' => Hash::make('121212')],
            ['id' => 23, 'username' => 'validator16', 'password' => Hash::make('121212')],
            ['id' => 24, 'username' => 'officer14', 'password' => Hash::make('121212')],
            ['id' => 25, 'username' => 'officer15', 'password' => Hash::make('121212')],
            ['id' => 26, 'username' => 'validator17', 'password' => Hash::make('121212')],
            ['id' => 27, 'username' => 'validator18', 'password' => Hash::make('121212')],
            ['id' => 28, 'username' => 'validator19', 'password' => Hash::make('121212')],
            ['id' => 29, 'username' => 'officer17', 'password' => Hash::make('121212')],
            ['id' => 30, 'username' => 'officer18', 'password' => Hash::make('121212')],
            ['id' => 31, 'username' => 'validator20', 'password' => Hash::make('121212')],
            ['id' => 32, 'username' => 'validator21', 'password' => Hash::make('121212')],
            ['id' => 33, 'username' => 'validator22', 'password' => Hash::make('121212')],
            ['id' => 34, 'username' => 'officer20', 'password' => Hash::make('121212')],
            ['id' => 35, 'username' => 'officer21', 'password' => Hash::make('121212')],
            ['id' => 36, 'username' => 'validator23', 'password' => Hash::make('121212')],
            ['id' => 37, 'username' => 'validator24', 'password' => Hash::make('121212')],
            ['id' => 38, 'username' => 'validator25', 'password' => Hash::make('121212')],
            ['id' => 39, 'username' => 'officer23', 'password' => Hash::make('121212')],
            ['id' => 40, 'username' => 'officer24', 'password' => Hash::make('121212')],
            ['id' => 41, 'username' => 'validator26', 'password' => Hash::make('121212')],
            ['id' => 42, 'username' => 'validator27', 'password' => Hash::make('121212')],
            ['id' => 43, 'username' => 'validator28', 'password' => Hash::make('121212')],
            ['id' => 44, 'username' => 'officer26', 'password' => Hash::make('121212')],
            ['id' => 45, 'username' => 'officer27', 'password' => Hash::make('121212')],
            ['id' => 46, 'username' => 'validator29', 'password' => Hash::make('121212')],
            ['id' => 47, 'username' => 'validator30', 'password' => Hash::make('121212')],
            ['id' => 48, 'username' => 'validator31', 'password' => Hash::make('121212')],
            ['id' => 49, 'username' => 'officer29', 'password' => Hash::make('121212')],
            ['id' => 50, 'username' => 'officer30', 'password' => Hash::make('121212')],
            ['id' => 51, 'username' => 'validator32', 'password' => Hash::make('121212')],
            ['id' => 52, 'username' => 'validator33', 'password' => Hash::make('121212')],
            ['id' => 53, 'username' => 'validator34', 'password' => Hash::make('121212')],
            ['id' => 54, 'username' => 'officer32', 'password' => Hash::make('121212')],
            ['id' => 55, 'username' => 'officer33', 'password' => Hash::make('121212')],
            ['id' => 56, 'username' => 'validator35', 'password' => Hash::make('121212')],
            ['id' => 57, 'username' => 'validator36', 'password' => Hash::make('121212')],
            ['id' => 58, 'username' => 'validator37', 'password' => Hash::make('121212')],
            ['id' => 59, 'username' => 'officer35', 'password' => Hash::make('121212')],
            ['id' => 60, 'username' => 'officer36', 'password' => Hash::make('121212')],
            ['id' => 61, 'username' => 'validator38', 'password' => Hash::make('121212')],
            ['id' => 62, 'username' => 'validator39', 'password' => Hash::make('121212')],
            ['id' => 63, 'username' => 'validator40', 'password' => Hash::make('121212')],
            ['id' => 64, 'username' => 'officer38', 'password' => Hash::make('121212')],
            ['id' => 65, 'username' => 'officer39', 'password' => Hash::make('121212')],
            ['id' => 66, 'username' => 'validator41', 'password' => Hash::make('121212')],
            ['id' => 67, 'username' => 'validator42', 'password' => Hash::make('121212')],
            ['id' => 68, 'username' => 'validator43', 'password' => Hash::make('121212')],
            ['id' => 69, 'username' => 'officer41', 'password' => Hash::make('121212')],
            ['id' => 70, 'username' => 'officer42', 'password' => Hash::make('121212')],
            ['id' => 71, 'username' => 'validator44', 'password' => Hash::make('121212')],
            ['id' => 72, 'username' => 'validator45', 'password' => Hash::make('121212')],
            ['id' => 73, 'username' => 'validator46', 'password' => Hash::make('121212')],
            ['id' => 74, 'username' => 'officer44', 'password' => Hash::make('121212')],
            ['id' => 75, 'username' => 'officer45', 'password' => Hash::make('121212')],
        ];

        DB::table('users')->insert($users);

        // Validators
        $validators = [
            ['id' => 1, 'user_id' => 1, 'role' => 'validator', 'name' => 'Kamila Wibisono'],
            ['id' => 2, 'user_id' => 2, 'role' => 'validator', 'name' => 'Maya Kusmawati'],
            ['id' => 3, 'user_id' => 3, 'role' => 'validator', 'name' => 'Gaduh Prasetyo'],
            ['id' => 4, 'user_id' => 4, 'role' => 'officer', 'name' => 'Indra Usamah'],
            ['id' => 5, 'user_id' => 5, 'role' => 'officer', 'name' => 'Kalim Yulianti'],
            ['id' => 6, 'user_id' => 6, 'role' => 'validator', 'name' => 'Eva Mandasari'],
            ['id' => 7, 'user_id' => 7, 'role' => 'validator', 'name' => 'Jatmiko Handayani'],
            ['id' => 8, 'user_id' => 8, 'role' => 'validator', 'name' => 'Ratna Riyanti'],
            ['id' => 9, 'user_id' => 9, 'role' => 'officer', 'name' => 'Ayu Iswahyudi'],
            ['id' => 10, 'user_id' => 10, 'role' => 'officer', 'name' => 'Azalea Mulyani'],
            ['id' => 11, 'user_id' => 11, 'role' => 'validator', 'name' => 'Hesti Andriani'],
            ['id' => 12, 'user_id' => 12, 'role' => 'validator', 'name' => 'Kusuma Nasyidah'],
            ['id' => 13, 'user_id' => 13, 'role' => 'validator', 'name' => 'Gaman Sihotang'],
            ['id' => 14, 'user_id' => 14, 'role' => 'officer', 'name' => 'Bella Habibi'],
            ['id' => 15, 'user_id' => 15, 'role' => 'officer', 'name' => 'Titin Agustina'],
            ['id' => 16, 'user_id' => 16, 'role' => 'validator', 'name' => 'Ami Kurniawan'],
            ['id' => 17, 'user_id' => 17, 'role' => 'validator', 'name' => 'Hasta Riyanti'],
            ['id' => 18, 'user_id' => 18, 'role' => 'validator', 'name' => 'Laila Hassanah'],
            ['id' => 19, 'user_id' => 19, 'role' => 'officer', 'name' => 'Martana Hakim'],
            ['id' => 20, 'user_id' => 20, 'role' => 'officer', 'name' => 'Aurora Siregar'],
            ['id' => 21, 'user_id' => 21, 'role' => 'validator', 'name' => 'Tina Prastuti'],
            ['id' => 22, 'user_id' => 22, 'role' => 'validator', 'name' => 'Farhunnisa Widiastuti'],
            ['id' => 23, 'user_id' => 23, 'role' => 'validator', 'name' => 'Olga Hartati'],
            ['id' => 24, 'user_id' => 24, 'role' => 'officer', 'name' => 'Tira Purwanti'],
            ['id' => 25, 'user_id' => 25, 'role' => 'officer', 'name' => 'Darmanto Nuraini'],
            ['id' => 26, 'user_id' => 26, 'role' => 'validator', 'name' => 'Okto Pradana'],
            ['id' => 27, 'user_id' => 27, 'role' => 'validator', 'name' => 'Dian Hariyah'],
            ['id' => 28, 'user_id' => 28, 'role' => 'validator', 'name' => 'Ganda Gunawan'],
            ['id' => 29, 'user_id' => 29, 'role' => 'officer', 'name' => 'Najam Rajata'],
            ['id' => 30, 'user_id' => 30, 'role' => 'officer', 'name' => 'Hani Maulana'],
            ['id' => 31, 'user_id' => 31, 'role' => 'validator', 'name' => 'Galak Uyainah'],
            ['id' => 32, 'user_id' => 32, 'role' => 'validator', 'name' => 'Eka Suartini'],
            ['id' => 33, 'user_id' => 33, 'role' => 'validator', 'name' => 'Asmianto Kusumo'],
            ['id' => 34, 'user_id' => 34, 'role' => 'officer', 'name' => 'Prayitna Yuniar'],
            ['id' => 35, 'user_id' => 35, 'role' => 'officer', 'name' => 'Banawi Prastuti'],
            ['id' => 36, 'user_id' => 36, 'role' => 'validator', 'name' => 'Kania Maulana'],
            ['id' => 37, 'user_id' => 37, 'role' => 'validator', 'name' => 'Salwa Mansur'],
            ['id' => 38, 'user_id' => 38, 'role' => 'validator', 'name' => 'Dagel Puspita'],
            ['id' => 39, 'user_id' => 39, 'role' => 'officer', 'name' => 'Jamal Rahimah'],
            ['id' => 40, 'user_id' => 40, 'role' => 'officer', 'name' => 'Ami Prastuti'],
            ['id' => 41, 'user_id' => 41, 'role' => 'validator', 'name' => 'Puput Suryatmi'],
            ['id' => 42, 'user_id' => 42, 'role' => 'validator', 'name' => 'Hani Uyainah'],
            ['id' => 43, 'user_id' => 43, 'role' => 'validator', 'name' => 'Aditya Kusmawati'],
            ['id' => 44, 'user_id' => 44, 'role' => 'officer', 'name' => 'Agnes Permadi'],
            ['id' => 45, 'user_id' => 45, 'role' => 'officer', 'name' => 'Edison Susanti'],
            ['id' => 46, 'user_id' => 46, 'role' => 'validator', 'name' => 'Winda Pertiwi'],
            ['id' => 47, 'user_id' => 47, 'role' => 'validator', 'name' => 'Emil Nuraini'],
            ['id' => 48, 'user_id' => 48, 'role' => 'validator', 'name' => 'Raden Sinaga'],
            ['id' => 49, 'user_id' => 49, 'role' => 'officer', 'name' => 'Sadina Nurdiyanti'],
            ['id' => 50, 'user_id' => 50, 'role' => 'officer', 'name' => 'Jessica Habibi'],
            ['id' => 51, 'user_id' => 51, 'role' => 'validator', 'name' => 'Maya Napitupulu'],
            ['id' => 52, 'user_id' => 52, 'role' => 'validator', 'name' => 'Nurul Utama'],
            ['id' => 53, 'user_id' => 53, 'role' => 'validator', 'name' => 'Asmianto Ardianto'],
            ['id' => 54, 'user_id' => 54, 'role' => 'officer', 'name' => 'Cawisono Wulandari'],
            ['id' => 55, 'user_id' => 55, 'role' => 'officer', 'name' => 'Candrakanta Palastri'],
            ['id' => 56, 'user_id' => 56, 'role' => 'validator', 'name' => 'Uda Sitorus'],
            ['id' => 57, 'user_id' => 57, 'role' => 'validator', 'name' => 'Paiman Zulaika'],
            ['id' => 58, 'user_id' => 58, 'role' => 'validator', 'name' => 'Eko Putra'],
            ['id' => 59, 'user_id' => 59, 'role' => 'officer', 'name' => 'Mariadi Samosir'],
            ['id' => 60, 'user_id' => 60, 'role' => 'officer', 'name' => 'Chandra Januar'],
            ['id' => 61, 'user_id' => 61, 'role' => 'validator', 'name' => 'Padma Hariyah'],
            ['id' => 62, 'user_id' => 62, 'role' => 'validator', 'name' => 'Taufik Uyainah'],
            ['id' => 63, 'user_id' => 63, 'role' => 'validator', 'name' => 'Maria Laksmiwati'],
            ['id' => 64, 'user_id' => 64, 'role' => 'officer', 'name' => 'Harjo Tamba'],
            ['id' => 65, 'user_id' => 65, 'role' => 'officer', 'name' => 'Vanesa Palastri'],
            ['id' => 66, 'user_id' => 66, 'role' => 'validator', 'name' => 'Diah Mulyani'],
            ['id' => 67, 'user_id' => 67, 'role' => 'validator', 'name' => 'Syahrini Farida'],
            ['id' => 68, 'user_id' => 68, 'role' => 'validator', 'name' => 'Fitria Winarsih'],
            ['id' => 69, 'user_id' => 69, 'role' => 'officer', 'name' => 'Clara Pratiwi'],
            ['id' => 70, 'user_id' => 70, 'role' => 'officer', 'name' => 'Dian Habibi'],
            ['id' => 71, 'user_id' => 71, 'role' => 'validator', 'name' => 'Aurora Wulandari'],
            ['id' => 72, 'user_id' => 72, 'role' => 'validator', 'name' => 'Safina Hassanah'],
            ['id' => 73, 'user_id' => 73, 'role' => 'validator', 'name' => 'Cinthia Adriansyah'],
            ['id' => 74, 'user_id' => 74, 'role' => 'officer', 'name' => 'Wadi Prakasa'],
            ['id' => 75, 'user_id' => 75, 'role' => 'officer', 'name' => 'Parman Namaga'],
        ];

        DB::table('validators')->insert($validators);

        // Job Categories
        DB::table('job_categories')->insert([
            ['id' => 1, 'job_category' => 'Computing and ICT'],
            ['id' => 2, 'job_category' => 'Construction and building'],
            ['id' => 3, 'job_category' => 'Animals, land and environment'],
            ['id' => 4, 'job_category' => 'Design, arts and crafts'],
            ['id' => 5, 'job_category' => 'Design, arts and crafts'], // Note: Duplicate in original data
        ]);

        // Job Vacancies
        $jobVacancies = [
            ['id' => 1, 'job_category_id' => 1, 'company' => 'PT. Maju Mundur Sejahtera', 'address' => 'Jln. Gotong Royong No. 31, DKI Jakarta', 'description' => 'Lowongan pekerjaan untuk beberapa list berikut'],
            ['id' => 2, 'job_category_id' => 2, 'company' => 'PT. Bangun Jaya Abadi', 'address' => 'Jln. Konstruksi No. 45, DKI Jakarta', 'description' => 'Membutuhkan tenaga konstruksi berpengalaman'],
            ['id' => 3, 'job_category_id' => 3, 'company' => 'PT. Hijau Lestari', 'address' => 'Jln. Lingkungan No. 12, West Java', 'description' => 'Perusahaan yang bergerak di bidang lingkungan hidup'],
            ['id' => 4, 'job_category_id' => 4, 'company' => 'PT. Kreatif Desain', 'address' => 'Jln. Seni No. 78, DKI Jakarta', 'description' => 'Membutuhkan desainer kreatif untuk berbagai proyek'],
            ['id' => 5, 'job_category_id' => 1, 'company' => 'PT. Teknologi Informasi', 'address' => 'Jln. Digital No. 56, West Java', 'description' => 'Perusahaan IT yang sedang berkembang pesat'],
            ['id' => 6, 'job_category_id' => 2, 'company' => 'PT. Konstruksi Bangunan', 'address' => 'Jln. Pembangunan No. 89, DKI Jakarta', 'description' => 'Membutuhkan tenaga ahli konstruksi'],
            ['id' => 7, 'job_category_id' => 3, 'company' => 'PT. Alam Hijau', 'address' => 'Jln. Hutan No. 34, West Java', 'description' => 'Perusahaan konservasi alam dan lingkungan'],
            ['id' => 8, 'job_category_id' => 4, 'company' => 'PT. Seni Kreatif', 'address' => 'Jln. Artistik No. 67, DKI Jakarta', 'description' => 'Membutuhkan seniman dan desainer kreatif'],
            ['id' => 9, 'job_category_id' => 1, 'company' => 'PT. Solusi Digital', 'address' => 'Jln. Teknologi No. 23, West Java', 'description' => 'Perusahaan pengembangan software dan aplikasi'],
            ['id' => 10, 'job_category_id' => 2, 'company' => 'PT. Bangun Bersama', 'address' => 'Jln. Proyek No. 56, DKI Jakarta', 'description' => 'Perusahaan konstruksi skala besar'],
            ['id' => 11, 'job_category_id' => 3, 'company' => 'PT. Lingkungan Sehat', 'address' => 'Jln. Alam No. 78, West Java', 'description' => 'Perusahaan pengelolaan lingkungan dan daur ulang'],
            ['id' => 12, 'job_category_id' => 4, 'company' => 'PT. Desain Modern', 'address' => 'Jln. Kreatif No. 45, DKI Jakarta', 'description' => 'Studio desain grafis dan interior'],
            ['id' => 13, 'job_category_id' => 1, 'company' => 'PT. Teknologi Maju', 'address' => 'Jln. Inovasi No. 12, West Java', 'description' => 'Perusahaan pengembangan teknologi terbaru'],
            ['id' => 14, 'job_category_id' => 2, 'company' => 'PT. Konstruksi Terpadu', 'address' => 'Jln. Bangunan No. 34, DKI Jakarta', 'description' => 'Perusahaan konstruksi terintegrasi'],
            ['id' => 15, 'job_category_id' => 3, 'company' => 'PT. Hijau Alam', 'address' => 'Jln. Konservasi No. 56, West Java', 'description' => 'Perusahaan pelestarian alam dan lingkungan'],
        ];

        DB::table('job_vacancies')->insert($jobVacancies);

        // Available Positions
        $availablePositions = [
            ['id' => 1, 'job_vacancy_id' => 1, 'position' => 'Web Developer', 'capacity' => 2, 'apply_capacity' => 15],
            ['id' => 2, 'job_vacancy_id' => 1, 'position' => 'Mobile Developer', 'capacity' => 3, 'apply_capacity' => 10],
            ['id' => 3, 'job_vacancy_id' => 1, 'position' => 'UI/UX Designer', 'capacity' => 1, 'apply_capacity' => 8],
            ['id' => 4, 'job_vacancy_id' => 2, 'position' => 'Site Manager', 'capacity' => 1, 'apply_capacity' => 5],
            ['id' => 5, 'job_vacancy_id' => 2, 'position' => 'Civil Engineer', 'capacity' => 2, 'apply_capacity' => 10],
            ['id' => 6, 'job_vacancy_id' => 3, 'position' => 'Environmental Specialist', 'capacity' => 2, 'apply_capacity' => 8],
            ['id' => 7, 'job_vacancy_id' => 4, 'position' => 'Graphic Designer', 'capacity' => 3, 'apply_capacity' => 12],
            ['id' => 8, 'job_vacancy_id' => 4, 'position' => 'Illustrator', 'capacity' => 1, 'apply_capacity' => 5],
            ['id' => 9, 'job_vacancy_id' => 5, 'position' => 'Backend Developer', 'capacity' => 2, 'apply_capacity' => 10],
            ['id' => 10, 'job_vacancy_id' => 5, 'position' => 'Frontend Developer', 'capacity' => 2, 'apply_capacity' => 10],
            ['id' => 11, 'job_vacancy_id' => 6, 'position' => 'Architect', 'capacity' => 1, 'apply_capacity' => 5],
            ['id' => 12, 'job_vacancy_id' => 6, 'position' => 'Construction Worker', 'capacity' => 5, 'apply_capacity' => 20],
            ['id' => 13, 'job_vacancy_id' => 7, 'position' => 'Conservation Officer', 'capacity' => 2, 'apply_capacity' => 8],
            ['id' => 14, 'job_vacancy_id' => 8, 'position' => 'Art Director', 'capacity' => 1, 'apply_capacity' => 5],
            ['id' => 15, 'job_vacancy_id' => 8, 'position' => 'Creative Designer', 'capacity' => 2, 'apply_capacity' => 10],
            ['id' => 16, 'job_vacancy_id' => 9, 'position' => 'Data Scientist', 'capacity' => 1, 'apply_capacity' => 5],
            ['id' => 17, 'job_vacancy_id' => 9, 'position' => 'DevOps Engineer', 'capacity' => 1, 'apply_capacity' => 5],
            ['id' => 18, 'job_vacancy_id' => 10, 'position' => 'Project Manager', 'capacity' => 1, 'apply_capacity' => 5],
            ['id' => 19, 'job_vacancy_id' => 10, 'position' => 'Surveyor', 'capacity' => 2, 'apply_capacity' => 8],
            ['id' => 20, 'job_vacancy_id' => 11, 'position' => 'Waste Management', 'capacity' => 2, 'apply_capacity' => 8],
            ['id' => 21, 'job_vacancy_id' => 12, 'position' => 'Interior Designer', 'capacity' => 1, 'apply_capacity' => 5],
            ['id' => 22, 'job_vacancy_id' => 12, 'position' => '3D Artist', 'capacity' => 1, 'apply_capacity' => 5],
            ['id' => 23, 'job_vacancy_id' => 13, 'position' => 'AI Engineer', 'capacity' => 1, 'apply_capacity' => 5],
            ['id' => 24, 'job_vacancy_id' => 13, 'position' => 'Cybersecurity', 'capacity' => 1, 'apply_capacity' => 5],
            ['id' => 25, 'job_vacancy_id' => 14, 'position' => 'Structural Engineer', 'capacity' => 1, 'apply_capacity' => 5],
            ['id' => 26, 'job_vacancy_id' => 14, 'position' => 'Quantity Surveyor', 'capacity' => 1, 'apply_capacity' => 5],
            ['id' => 27, 'job_vacancy_id' => 15, 'position' => 'Ecologist', 'capacity' => 1, 'apply_capacity' => 5],
            ['id' => 28, 'job_vacancy_id' => 15, 'position' => 'Forestry Officer', 'capacity' => 1, 'apply_capacity' => 5],
        ];

        DB::table('available_positions')->insert($availablePositions);

        // Validations
        $validations = [
            ['id' => 1, 'job_category_id' => 1, 'society_id' => 1, 'validator_id' => 1, 'status' => 'accepted', 'work_experience' => '5 years as web developer', 'job_position' => 'Senior Web Developer', 'reason_accepted' => 'Experienced candidate', 'validator_notes' => 'Verified documents'],
            ['id' => 2, 'job_category_id' => 2, 'society_id' => 2, 'validator_id' => 2, 'status' => 'accepted', 'work_experience' => '3 years in construction', 'job_position' => 'Site Supervisor', 'reason_accepted' => 'Qualified for position', 'validator_notes' => 'Documents complete'],
            ['id' => 3, 'job_category_id' => 3, 'society_id' => 3, 'validator_id' => 3, 'status' => 'accepted', 'work_experience' => '2 years in environmental field', 'job_position' => 'Environmental Officer', 'reason_accepted' => 'Relevant education background', 'validator_notes' => 'All documents verified'],
            ['id' => 4, 'job_category_id' => 4, 'society_id' => 4, 'validator_id' => 4, 'status' => 'accepted', 'work_experience' => '4 years as graphic designer', 'job_position' => 'Lead Designer', 'reason_accepted' => 'Impressive portfolio', 'validator_notes' => 'Portfolio reviewed'],
            ['id' => 5, 'job_category_id' => 1, 'society_id' => 5, 'validator_id' => 5, 'status' => 'accepted', 'work_experience' => '1 year as junior developer', 'job_position' => 'Junior Developer', 'reason_accepted' => 'Good potential', 'validator_notes' => 'Needs mentoring'],
            ['id' => 6, 'job_category_id' => 2, 'society_id' => 6, 'validator_id' => 6, 'status' => 'pending', 'work_experience' => 'Fresh graduate', 'job_position' => 'Construction Trainee', 'reason_accepted' => 'Willing to learn', 'validator_notes' => null],
            ['id' => 7, 'job_category_id' => 3, 'society_id' => 7, 'validator_id' => 7, 'status' => 'pending', 'work_experience' => 'Internship experience', 'job_position' => 'Environmental Intern', 'reason_accepted' => 'Educational background matches', 'validator_notes' => null],
            ['id' => 8, 'job_category_id' => 4, 'society_id' => 8, 'validator_id' => 8, 'status' => 'declined', 'work_experience' => 'Freelance designer', 'job_position' => 'Graphic Designer', 'reason_accepted' => 'Portfolio not strong enough', 'validator_notes' => 'Needs more experience'],
            ['id' => 9, 'job_category_id' => 1, 'society_id' => 9, 'validator_id' => 9, 'status' => 'accepted', 'work_experience' => '3 years as fullstack developer', 'job_position' => 'Fullstack Developer', 'reason_accepted' => 'Strong technical skills', 'validator_notes' => 'Technical test passed'],
            ['id' => 10, 'job_category_id' => 2, 'society_id' => 10, 'validator_id' => 10, 'status' => 'accepted', 'work_experience' => '5 years as civil engineer', 'job_position' => 'Senior Civil Engineer', 'reason_accepted' => 'Extensive experience', 'validator_notes' => 'Certifications verified'],
        ];

        DB::table('validations')->insert($validations);

        // Job Apply Societies
        $jobApplySocieties = [
            ['id' => 1, 'notes' => 'I have relevant experience for this position', 'date' => '2023-09-01', 'society_id' => 1, 'job_vacancy_id' => 1],
            ['id' => 2, 'notes' => 'Looking for new challenges', 'date' => '2023-09-02', 'society_id' => 2, 'job_vacancy_id' => 2],
            ['id' => 3, 'notes' => 'Passionate about environmental work', 'date' => '2023-09-03', 'society_id' => 3, 'job_vacancy_id' => 3],
            ['id' => 4, 'notes' => 'Creative designer with innovative ideas', 'date' => '2023-09-04', 'society_id' => 4, 'job_vacancy_id' => 4],
            ['id' => 5, 'notes' => 'Eager to learn and grow in IT field', 'date' => '2023-09-05', 'society_id' => 5, 'job_vacancy_id' => 5],
            ['id' => 6, 'notes' => 'Fresh graduate with construction education', 'date' => '2023-09-06', 'society_id' => 6, 'job_vacancy_id' => 6],
            ['id' => 7, 'notes' => 'Internship experience in environmental sector', 'date' => '2023-09-07', 'society_id' => 7, 'job_vacancy_id' => 7],
            ['id' => 8, 'notes' => 'Freelance design projects completed', 'date' => '2023-09-08', 'society_id' => 8, 'job_vacancy_id' => 8],
            ['id' => 9, 'notes' => 'Fullstack development projects portfolio', 'date' => '2023-09-09', 'society_id' => 9, 'job_vacancy_id' => 9],
            ['id' => 10, 'notes' => 'Civil engineering certification holder', 'date' => '2023-09-10', 'society_id' => 10, 'job_vacancy_id' => 10],
        ];

        DB::table('job_apply_societies')->insert($jobApplySocieties);

        // Job Apply Positions
        $jobApplyPositions = [
            ['id' => 1, 'date' => '2023-09-01', 'society_id' => 1, 'job_vacancy_id' => 1, 'position_id' => 1, 'job_apply_societies_id' => 1, 'status' => 'pending'],
            ['id' => 2, 'date' => '2023-09-02', 'society_id' => 2, 'job_vacancy_id' => 2, 'position_id' => 4, 'job_apply_societies_id' => 2, 'status' => 'pending'],
            ['id' => 3, 'date' => '2023-09-03', 'society_id' => 3, 'job_vacancy_id' => 3, 'position_id' => 6, 'job_apply_societies_id' => 3, 'status' => 'pending'],
            ['id' => 4, 'date' => '2023-09-04', 'society_id' => 4, 'job_vacancy_id' => 4, 'position_id' => 7, 'job_apply_societies_id' => 4, 'status' => 'accepted'],
            ['id' => 5, 'date' => '2023-09-05', 'society_id' => 5, 'job_vacancy_id' => 5, 'position_id' => 9, 'job_apply_societies_id' => 5, 'status' => 'pending'],
            ['id' => 6, 'date' => '2023-09-06', 'society_id' => 6, 'job_vacancy_id' => 6, 'position_id' => 11, 'job_apply_societies_id' => 6, 'status' => 'pending'],
            ['id' => 7, 'date' => '2023-09-07', 'society_id' => 7, 'job_vacancy_id' => 7, 'position_id' => 13, 'job_apply_societies_id' => 7, 'status' => 'pending'],
            ['id' => 8, 'date' => '2023-09-08', 'society_id' => 8, 'job_vacancy_id' => 8, 'position_id' => 14, 'job_apply_societies_id' => 8, 'status' => 'rejected'],
            ['id' => 9, 'date' => '2023-09-09', 'society_id' => 9, 'job_vacancy_id' => 9, 'position_id' => 16, 'job_apply_societies_id' => 9, 'status' => 'accepted'],
            ['id' => 10, 'date' => '2023-09-10', 'society_id' => 10, 'job_vacancy_id' => 10, 'position_id' => 18, 'job_apply_societies_id' => 10, 'status' => 'accepted'],
        ];

        DB::table('job_apply_positions')->insert($jobApplyPositions);

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
