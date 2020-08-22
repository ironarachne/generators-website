<?php


namespace App;


use Exception;

class OrganizationGenerator
{
    public function generate(NameGenerator $nameGenerator, string $type = 'random')
    {
        $organization = new Organization();

        if ($type == 'random') {
            $organization->type = $this->randomType();
        } elseif ($type == 'adventuring company') {
            $organization->type = new AdventuringCompany();
        } elseif ($type == 'artisan guild') {
            $profession = random_item(Profession::load('crafter'));
            $organization->type = new ArtisanGuild($profession);
        } elseif ($type == 'holy order') {
            $organization->type = new HolyOrder();
        } elseif ($type == 'mercenary company') {
            $organization->type = new MercenaryCompany();
        } elseif ($type == 'wizard school') {
            $charGen = new CharacterGenerator();
            $nameGenerator = NameGenerator::defaultFantasy();
            $species = random_item(Species::load('race'));
            $founder = $charGen->generate($nameGenerator, $species, ['elderly']);
            $founder->profession = Profession::load('wizard');
            $founderTitle = new Title('Archmage', 'Archmage', '', '', 'wizard school', 5);
            $founder->titles [] = $founderTitle;
            if ($founder->primary_title == '') {
                $founder->primary_title = $founderTitle->getPrefix($founder->gender);
            }
            return new WizardSchool($founder);
        } else {
            throw new Exception('tried to get nonexistent organization type');
        }

        $organization->number_of_members = mt_rand($organization->type->min_size, $organization->type->max_size);

        $organization->size = $organization->getSizeClass();
        $organization->name = $organization->type->generateName();
        $organization->primary_trait = $this->randomTrait($organization->type->possible_traits);
        $organization->leaders = [];
        $organization->leaders = $this->generateLeaders($nameGenerator, $organization);
        $organization->notable_members = [];
        $organization->notable_members = $this->generateNotableMembers($nameGenerator, $organization);
        $organization->description = $organization->describe();

        return $organization;
    }

    private function generateLeaders(NameGenerator $nameGenerator, Organization $organization): array
    {
        $leaders = [];

        $leaderTitle = $organization->type->leadership_type->title;
        $leaderAgeCategories = $organization->getLeaderAgeCategories();
        $minLeaders = $organization->type->leadership_type->min_leaders;
        $maxLeaders = $organization->type->leadership_type->max_leaders;
        $numberOfLeaders = mt_rand($minLeaders, $maxLeaders);

        $charGen = new CharacterGenerator();
        $species = Species::randomRace();

        for ($i = 0; $i < $numberOfLeaders; $i++) {
            $leader = $charGen->generate($nameGenerator, $species, $leaderAgeCategories);
            $leader->profession = $organization->randomProfession();
            $leader->primary_title = $leaderTitle->getPrefix($leader->gender);
            $leader->titles = [$leaderTitle];

            $leaders [] = $leader;
        }

        return $leaders;
    }

    private function generateNotableMembers(NameGenerator $nameGenerator, Organization $organization): array
    {
        $members = [];

        $numberOfMembers = mt_rand(1, 4);

        $charGen = new CharacterGenerator();

        for ($i = 0; $i < $numberOfMembers; $i++) {
            $species = Species::randomRace();
            $rank = $organization->getRandomMemberRank();
            $member = $charGen->generate($nameGenerator, $species, $rank->possible_age_categories);
            $member->profession = $organization->randomProfession();
            $title = $rank->title;
            $member->titles = [$title];
            $member->primary_title = $title->getPrefix($member->gender);
            $members [] = $member;
        }

        return $members;
    }

    private function randomTrait(array $traits): string
    {
        return random_item($traits);
    }

    private function randomType(): OrganizationType
    {
        $types = [
            'adventuring company',
            'artisan guild',
            'holy order',
            'mercenary company',
            'wizard school',
        ];

        $type = random_item($types);

        if ($type == 'adventuring company') {
            return new AdventuringCompany();
        } else if ($type == 'artisan guild') {
            $profession = random_item(Profession::load('crafter'));
            return new ArtisanGuild($profession);
        } else if ($type == 'holy order') {
            return new HolyOrder();
        } else if ($type == 'mercenary company') {
            return new MercenaryCompany();
        } else if ($type == 'wizard school') {
            $charGen = new CharacterGenerator();
            $nameGenerator = NameGenerator::defaultFantasy();
            $species = random_item(Species::load('race'));
            $founder = $charGen->generate($nameGenerator, $species, ['elderly']);
            return new WizardSchool($founder);
        }
    }
}
