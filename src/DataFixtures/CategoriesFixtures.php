<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoriesFixtures extends Fixture
{
    Private $counter= 1;

    public function __construct(private SluggerInterface $slugger) {}
   
    public function load(ObjectManager $manager): void
    {   
        $parent = $this->createCategory('Electromenager', null, $manager);
        
        $this->createCategory('Ustensile de cuisine', $parent, $manager);
        $this->createCategory('Ustensile de patisserie', $parent, $manager);
        $this->createCategory('Vaisselle de table', $parent, $manager);

        $parent = $this->createCategory('Mode', null, $manager);

        $this->createCategory('Homme', $parent, $manager);
        $this->createCategory('Femme', $parent, $manager);
        $this->createCategory('Enfant', $parent, $manager);
                
        $manager->flush();
    }


    public function createCategory(string $name, Categories $parent = null, ObjectManager $manager)
    {
        $category = new Categories();
        $category->setName($name);
        $category->setSlug($this->slugger->slug($category->getName())->lower());
        $category->setParent($parent);
        $manager->persist($category);

        $this->addReference('cat-'.$this->counter, $category);
        $this->counter++;

        return $category;
    }
}
