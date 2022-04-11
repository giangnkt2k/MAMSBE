<?php

namespace Database\Factories;

use App\Models\Utilities;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UtilitiesFactory extends Factory
{
       /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Utilities::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $datas = [
            [
                'id' => 1,
                'label' => 'Balcony',
                'price' => 1000000,
            ],
            [
                'id' => 2,
                'label' => 'Security',
                'price' => 1100000,
            ],
            [
                'id' => 3,
                'label' => 'Air conditioner',
                'price' => 1000000,
            ],
            [
                'id' => 4,
                'label' => 'Camera',
                'price' => 110000,
            ],
            [
                'id' => 5,
                'label' => 'Loft',
                'price' => 110000,
            ],
            [
                'id' => 6,
                'label' => 'Kitchen',
                'price' => 110000,
            ],
            [
                'id' => 7,
                'label' => 'Bed',
                'price' => 110000,
            ],
            [
                'id' => 8,
                'label' => 'Parking',
                'price' => 110000,
            ],
            [
                'id' => 9,
                'label' => 'Elevator',
                'price' => 1234,
            ],
            [
                'id' => 10,
                'label' => 'TV',
                'price' => 12412,
            ],
            [
                'id' => 11,
                'label' => 'Refrigerator',
                'price' => 123124,
            ],
            [
                'id' => 12,
                'label' => 'Internet',
                'price' => 123414,
            ],
            [
                'id' => 13,
                'label' => 'Water heater',
                'price' => 12314,
            ],
            [
                'id' => 14,
                'label' => 'Wifi',
                'price' => 124132,
            ],
            [
                'id' => 15,
                'label' => 'WC',
                'price' => 1241231,
            ],
            [
                'id' => 16,
                'label' => 'Wardrobe',
                'price' => 12314,
            ],
            [
                'id' => 17,
                'label' => 'Washing machine',
                'price' => 1234132,
            ],

        ];
        return $datas;
    }
}
