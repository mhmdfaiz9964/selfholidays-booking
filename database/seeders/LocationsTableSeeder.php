<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = [
            [1, 6, 'Ampara', 'අම්පාර', 'அம்பாறை'],
            [2, 8, 'Anuradhapura', 'අනුරාධපුරය', 'அனுராதபுரம்'],
            [3, 7, 'Badulla', 'බදුල්ල', 'பதுளை'],
            [4, 6, 'Batticaloa', 'මඩකලපුව', 'மட்டக்களப்பு'],
            [5, 1, 'Colombo', 'කොළඹ', 'கொழும்பு'],
            [6, 3, 'Galle', 'ගාල්ල', 'காலி'],
            [7, 1, 'Gampaha', 'ගම්පහ', 'கம்பஹா'],
            [8, 3, 'Hambantota', 'හම්බන්තොට', 'அம்பாந்தோட்டை'],
            [9, 9, 'Jaffna', 'යාපනය', 'யாழ்ப்பாணம்'],
            [10, 1, 'Kalutara', 'කළුතර', 'களுத்துறை'],
            [11, 2, 'Kandy', 'මහනුවර', 'கண்டி'],
            [12, 5, 'Kegalle', 'කෑගල්ල', 'கேகாலை'],
            [13, 9, 'Kilinochchi', 'කිලිනොච්චිය', 'கிளிநொச்சி'],
            [14, 4, 'Kurunegala', 'කුරුණෑගල', 'குருணாகல்'],
            [15, 9, 'Mannar', 'මන්නාරම', 'மன்னார்'],
            [16, 2, 'Matale', 'මාතලේ', 'மாத்தளை'],
            [17, 3, 'Matara', 'මාතර', 'மாத்தறை'],
            [18, 7, 'Monaragala', 'මොණරාගල', 'மொணராகலை'],
            [19, 9, 'Mullaitivu', 'මුලතිව්', 'முல்லைத்தீவு'],
            [20, 2, 'Nuwara Eliya', 'නුවර එළිය', 'நுவரேலியா'],
            [21, 8, 'Polonnaruwa', 'පොළොන්නරුව', 'பொலன்னறுவை'],
            [22, 4, 'Puttalam', 'පුත්තලම', 'புத்தளம்'],
            [23, 5, 'Ratnapura', 'රත්නපුර', 'இரத்தினபுரி'],
            [24, 6, 'Trincomalee', 'ත්‍රිකුණාමලය', 'திருகோணமலை'],
            [25, 9, 'Vavuniya', 'වව්නියාව', 'வவுனியா'],
        ];

        foreach ($locations as $location) {
            Location::create([
                'province_id' => $location[1],
                'district_id' => $location[0],
                'name' => $location[2],
                'sinhala_name' => $location[3],
                'tamil_name' => $location[4],
            ]);
        }
    }
}
