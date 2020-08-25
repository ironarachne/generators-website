<?php


namespace App;


class AgeCategory
{
    public string $name;
    public int $age_max;
    public int $age_min;
    public string $size_category;
    public int $height_base_female;
    public int $height_base_male;
    public string $height_range_dice;
    public int $weight_base_female;
    public int $weight_base_male;
    public string $weight_range_dice;
    public int $commonality;

    public function randomAge()
    {
        return mt_rand($this->age_min, $this->age_max);
    }

    public function randomHeight($gender)
    {
        $dice = new Dice($this->height_range_dice);
        $height = $dice->roll();

        if ($gender == 'male') {
            $height += $this->height_base_male;
        } else {
            $height += $this->height_base_female;
        }

        return $height;
    }

    public function randomWeight($gender)
    {
        $dice = new Dice($this->weight_range_dice);
        $weight = $dice->roll();

        if ($gender == 'male') {
            $weight += $this->weight_base_male;
        } else {
            $weight += $this->weight_base_female;
        }

        return $weight;
    }

    public static function fromJSON(string $json): AgeCategory
    {
        $data = json_decode($json);

        $object = new AgeCategory();

        foreach ($data as $key => $value) {
            $object->{$key} = $value;
        }

        return $object;
    }

    public static function fromObject(\stdClass $data): AgeCategory
    {
        $object = new AgeCategory();

        foreach ($data as $key => $value) {
            $object->{$key} = $value;
        }

        return $object;
    }
}
