<?php


namespace App;


class PantheonGenerator
{
    public function generate(int $min, int $max, NameGenerator $nameGenerator)
    {
        $deityGen = new DeityGenerator();
        $possibleDomains = Domain::loadAll();
        $deityGen->possibleDomains = $possibleDomains;

        $pantheon = new Pantheon();
        $pantheon->deities = [];

        $numberOfDeities = $min;

        if ($max - $min > 0) {
            $numberOfDeities = mt_rand($min, $max);
        }

        if ($numberOfDeities > 1) {
            for ($i = 0; $i < $numberOfDeities; $i++) {
                $deity = $deityGen->generate($nameGenerator);
                $pantheon->deities [] = $deity;
            }
            $pantheon->deities = $this->generateRelationships($pantheon->deities);
        } else {
            $pantheon->deities [] = $deityGen->generate($nameGenerator);
            $pantheon->deities[0]->description = $pantheon->deities[0]->describe();
        }

        return $pantheon;
    }

    private function generateRelationships($deities)
    {
        $result = [];

        $possibleRelationships = [
            'loves',
            'trusts',
            'hates',
            'fears',
            'distrusts',
            'respects',
        ];

        foreach ($deities as $deity) {
            $otherDeities = $deity->removeFrom($deities);
            if (sizeof($otherDeities) > 0) {
                $target = random_item($otherDeities);
                $relationship = random_item($possibleRelationships) . ' ' . $target->name;
                $deity->relationships [] = $relationship;
                $deity->description = $deity->describe();
                $result [] = $deity;
            }
        }

        return $result;
    }
}
