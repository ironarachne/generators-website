<?php


namespace App;


class Culture
{
    public string $name;
    public string $adjective;
    public Language $language;
    public GeographicRegion $geography;
    public Music $music;
    public ClothingStyle $clothing;
    public Cuisine $cuisine;
    public AlcoholicDrink $drink;
    public Religion $religion;

    public function __construct(string $name, string $adjective, Language $language, GeographicRegion $geography,
                                Music $music, ClothingStyle $clothing, Cuisine $cuisine, AlcoholicDrink $drink, Religion $religion)
    {
        $this->name = $name;
        $this->adjective = $adjective;
        $this->language = $language;
        $this->geography = $geography;
        $this->music = $music;
        $this->clothing = $clothing;
        $this->cuisine = $cuisine;
        $this->drink = $drink;
        $this->religion = $religion;
    }

    public static function fromJSON(string $json): Culture
    {
        $object = json_decode($json);

        $name = $object->name;
        $adjective = $object->adjective;
        $language = Language::fromObject($object->language);
        $geography = GeographicRegion::fromObject($object->geography);
        $music = Music::fromObject($object->music);
        $clothing = ClothingStyle::fromObject($object->clothing);
        $cuisine = Cuisine::fromObject($object->cuisine);
        $drink = AlcoholicDrink::fromObject($object->drink);
        $religion = Religion::fromObject($object->religion);

        return new Culture($name, $adjective, $language, $geography, $music, $clothing, $cuisine, $drink, $religion);
    }

}
