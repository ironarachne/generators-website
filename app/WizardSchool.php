<?php


namespace App;


class WizardSchool extends OrganizationType
{
    public Character $founder;

    public function __construct(Character $founder)
    {
        $this->name = 'wizard school';
        $this->max_size = 500;
        $this->min_size = 50;
        $this->possible_traits = [
            'aloof',
            'ambitious',
            'august',
            'closeted',
            'eldritch',
            'esoteric',
            'guarded',
            'knowledgeable',
            'powerful',
            'reckless',
            'regimented',
            'wise',
        ];
        $this->founder = $founder;
        $this->member_professions = Profession::load('wizard');

        $headmasterTitle = new Title('Headmaster', 'Headmaster', '', '', 'wizard school', 2);
        $instructorTitle = new Title('Instructor', 'Instructor', '', '', 'wizard school', 1);
        $studentTitle = new Title('Student', 'Student', '', '', 'wizard school', 0);

        $this->leadership_type = new LeadershipType('headmastership', 1, 1, $headmasterTitle);
        $this->ranks = [
            new OrganizationRank('Headmaster', $headmasterTitle, 1, ['adult', 'elderly'], true),
            new OrganizationRank('Instructor', $instructorTitle, 0),
            new OrganizationRank('Student', $studentTitle, 0, ['child', 'teenager']),
        ];
    }

    public function generateName(): string
    {
        $schools = [
            'School',
            'Academy',
            'Institute',
            'College',
        ];

        $school = random_item($schools);

        $qualifiers = [
            'Wizardry',
            'Arcane Sciences',
            'Arcane Studies',
            'Arcane Matters',
            'Arcane Endeavours',
            'Eldritch Sciences',
            'Eldritch Studies',
            'Wizarding Arts',
            'Wizardry and Magic',
            'Sorcerous Endeavours',
            'Mystical Arts',
            'Mystical Studies',
        ];

        $qualifier = random_item($qualifiers);

        $conjunction = random_item(['for', 'of']);

        $patterns = [
            "{$this->founder->last_name}'s $school $conjunction $qualifier",
            "{$this->founder->last_name} $school $conjunction $qualifier",
            "$school $conjunction $qualifier",
        ];

        return random_item($patterns);
    }
}
