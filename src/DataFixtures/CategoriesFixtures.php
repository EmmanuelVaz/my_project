<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoriesFixtures extends Fixture
{
    private $counter = 1;

    public function __construct(private SluggerInterface $slugger){}
    public function load(ObjectManager $manager): void
    {
        $parent = $this->createCategory('Informatique', null, 1, $manager);

        $this->createCategory('Ordinateurs portable', $parent, 2, $manager);
        $this->createCategory('Ecran', $parent, 2, $manager);
        $this->createCategory('Souris', $parent, 3, $manager);

        $parent = $this->createCategory('Mode', null, 4, $manager);

        $this->createCategory('Homme', $parent, 5, $manager);
        $this->createCategory('Femme', $parent, 6, $manager);
        $this->createCategory('Enfant', $parent, 6, $manager);

        $manager->flush();
    }

    public function createCategory(string $name, Categories $parent = null, int $categoryOrder ,ObjectManager $manager){
        
        $category = new Categories();
        $category->setName($name);
        $category->setSlug($this->slugger->slug($category->getName())->lower());
        $category->setParent($parent);
        $category->setcategoryOrder($categoryOrder);
        $manager->persist($category);

        $this->addReference('cat-'.$this->counter, $category);
        $this->counter++;

        return $category;
    }
}
