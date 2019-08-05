<?php

use App\Models\District;
use Illuminate\Database\Seeder;

class DistrictDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $districts = [
        ['name' => 'Buikwe', 'type' => 'district'],
        ['name' => 'Buvuma', 'type' => 'district'],
        ['name' => 'Namayingo', 'type' => 'district'],
        ['name' => 'Katakwi', 'type' => 'district'],
        ['name' => 'Nakapiripirit', 'type' => 'district'],
        ['name' => 'Kamwenge', 'type' => 'district'],
        ['name' => 'Mbarara', 'type' => 'district'],
        ['name' => 'Kotido', 'type' => 'district'],
        ['name' => 'Agago', 'type' => 'district'],
        ['name' => 'Bulambuli', 'type' => 'district'],
        ['name' => 'Kween', 'type' => 'district'],
        ['name' => 'Amudat', 'type' => 'district'],
        ['name' => 'Kaberamaido', 'type' => 'district'],
        ['name' => 'Amolatar', 'type' => 'district'],
        ['name' => 'Kaliro', 'type' => 'district'],
        ['name' => 'Namutumba', 'type' => 'district'],
        ['name' => 'Kitgum', 'type' => 'district'],
        ['name' => 'Lamwo', 'type' => 'district'],
        ['name' => 'Pader', 'type' => 'district'],
        ['name' => 'Sironko', 'type' => 'district'],
        ['name' => 'Mbale', 'type' => 'district'],
        ['name' => 'Kalangala', 'type' => 'district'],
        ['name' => 'Bugiri', 'type' => 'district'],
        ['name' => 'Busia', 'type' => 'district'],
        ['name' => 'Butaleja', 'type' => 'district'],
        ['name' => 'Mayuge', 'type' => 'district'],
        ['name' => 'Manafwa', 'type' => 'district'],
        ['name' => 'Tororo', 'type' => 'district'],
        ['name' => 'Masaka', 'type' => 'district'],
        ['name' => 'Kasese', 'type' => 'district'],
        ['name' => 'Ntungamo', 'type' => 'district'],
        ['name' => 'Bushenyi', 'type' => 'district'],
        ['name' => 'Rukungiri', 'type' => 'district'],
        ['name' => 'Mbararaa', 'type' => 'district'],
        ['name' => 'Kabale', 'type' => 'district'],
        ['name' => 'Kanungu', 'type' => 'district'],
        ['name' => 'Nebbi', 'type' => 'district'],
        ['name' => 'Zombo', 'type' => 'district'],
        ['name' => 'Ngora', 'type' => 'district'],
        ['name' => 'Bukedea', 'type' => 'district'],
        ['name' => 'Budaka', 'type' => 'district'],
        ['name' => 'Kibuku', 'type' => 'district'],
        ['name' => 'Pallisa', 'type' => 'district'],
        ['name' => 'Serere', 'type' => 'district'],
        ['name' => 'Kalungu', 'type' => 'district'],
        ['name' => 'Gomba', 'type' => 'district'],
        ['name' => 'Amuru', 'type' => 'district'],
        ['name' => 'Amuria', 'type' => 'district'],
        ['name' => 'Otuke', 'type' => 'district'],
        ['name' => 'Oyam', 'type' => 'district'],
        ['name' => 'Kibale', 'type' => 'district'],
        ['name' => 'Ntoroko', 'type' => 'district'],
        ['name' => 'Kyegegwa', 'type' => 'district'],
        ['name' => 'Napak', 'type' => 'district'],
        ['name' => 'Moroto', 'type' => 'district'],
        ['name' => 'Bukwa', 'type' => 'district'],
        ['name' => 'Lwengo', 'type' => 'district'],
        ['name' => 'Lyantonde', 'type' => 'district'],
        ['name' => 'Butambala', 'type' => 'district'],
        ['name' => 'Rubirizi', 'type' => 'district'],
        ['name' => 'Sheema', 'type' => 'district'],
        ['name' => 'Mitooma', 'type' => 'district'],
        ['name' => 'Buhweju', 'type' => 'district'],
        ['name' => 'Bududa', 'type' => 'district'],
        ['name' => 'Jinja', 'type' => 'district'],
        ['name' => 'Kayunga', 'type' => 'district'],
        ['name' => 'Iganga', 'type' => 'district'],
        ['name' => 'Alebtong', 'type' => 'district'],
        ['name' => 'Soroti', 'type' => 'district'],
        ['name' => 'Buyende', 'type' => 'district'],
        ['name' => 'Kumi', 'type' => 'district'],
        ['name' => 'Mpigi', 'type' => 'district'],
        ['name' => 'Adjumani', 'type' => 'district'],
        ['name' => 'Yumbe', 'type' => 'district'],
        ['name' => 'Kampala', 'type' => 'district'],
        ['name' => 'Mukono', 'type' => 'district'],
        ['name' => 'Wakiso', 'type' => 'district'],
        ['name' => 'Sembabule', 'type' => 'district'],
        ['name' => 'Mityana', 'type' => 'district'],
        ['name' => 'Nakaseke', 'type' => 'district'],
        ['name' => 'Dokolo', 'type' => 'district'],
        ['name' => 'Lira', 'type' => 'district'],
        ['name' => 'Gulu', 'type' => 'district'],
        ['name' => 'Nwoya', 'type' => 'district'],
        ['name' => 'Masindi', 'type' => 'district'],
        ['name' => 'Apac', 'type' => 'district'],
        ['name' => 'Buliisa', 'type' => 'district'],
        ['name' => 'Hoima', 'type' => 'district'],
        ['name' => 'Kabarole', 'type' => 'district'],
        ['name' => 'Kapchorwa', 'type' => 'district'],
        ['name' => 'Kaabong', 'type' => 'district'],
        ['name' => 'Abim', 'type' => 'district'],
        ['name' => 'Rakai', 'type' => 'district'],
        ['name' => 'Isingiro', 'type' => 'district'],
        ['name' => 'Kisoro', 'type' => 'district'],
        ['name' => 'Luuka', 'type' => 'district'],
        ['name' => 'Kamuli', 'type' => 'district'],
        ['name' => 'Arua', 'type' => 'district'],
        ['name' => 'Koboko', 'type' => 'district'],
        ['name' => 'Moyo', 'type' => 'district'],
        ['name' => 'Luweero', 'type' => 'district'],
        ['name' => 'Mubende', 'type' => 'district'],
        ['name' => 'Nakasongola', 'type' => 'district'],
        ['name' => 'Bundibugyo', 'type' => 'district'],
        ['name' => 'Kyankwanzi', 'type' => 'district'],
        ['name' => 'Kole', 'type' => 'district'],
        ['name' => 'Maracha', 'type' => 'district'],
        ['name' => 'Kiboga', 'type' => 'district'],
        ['name' => 'Kyenjojo', 'type' => 'district']
      ];

      District::query()->insert($districts);
    }
}