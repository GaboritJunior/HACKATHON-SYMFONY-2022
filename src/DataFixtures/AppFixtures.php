<?php

namespace App\DataFixtures;

use App\Entity\Character;
use App\Entity\Equipment;
use App\Entity\EquipmentType;
use App\Entity\Faction;
use App\Entity\Guild;
use App\Entity\Rarity;
use App\Entity\Speciality;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Faker\Factory::create('fr_FR');

        // Creation de 10 factions
        $factions = Array();
        for ($i = 0; $i < 10; $i++) {
            $factions[$i] = new Faction();
            $factions[$i]->setName($faker->country);

            $manager->persist($factions[$i]);
        }

        // Creation de 10 classes
        $classes = Array();
        for ($i = 0; $i < 10; $i++) {
            $classes[$i] = new Speciality();
            $classes[$i]->setName($faker->word);

            $manager->persist($classes[$i]);
        }

        // Creation de 30 utilisateurs
        $users = Array();
        for($i = 0; $i < 30; $i++) {
            $users[$i] = new Utilisateur();
            $users[$i]->setEmail($faker->email);
            $users[$i]->setPassword('admin');

            $manager->persist($users[$i]);
        }

        // Creation de 30 Personnages
        $persos = Array();
        for ($i = 0; $i < 30; $i++) {
            $persos[$i] = new Character();
            $persos[$i]->setUsername($faker->userName);
            $persos[$i]->setMoney($faker->numberBetween(0,10000));
            $persos[$i]->setUser($users[rand(0,count($users)-1)]);
            $persos[$i]->setSpeciality($classes[rand(0,count($classes)-1)]);
            $persos[$i]->setFaction($factions[rand(0,count($factions)-1)]);
            // $persos[$i]->setGuild(rand(1, 20));
            $manager->persist($persos[$i]);
        }

        // Creation de 20 Guildes
        $guilds = Array();
        for ($i = 0; $i < 5; $i++) {
            $guilds[$i] = new Guild();
            $guilds[$i]->setName($faker->name);
            $guilds[$i]->setCreator($persos[$i]);

            $manager->persist($guilds[$i]);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
