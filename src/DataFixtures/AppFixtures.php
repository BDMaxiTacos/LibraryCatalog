<?php

namespace App\DataFixtures;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Category;
use App\Entity\User;
use DateTime;
use Faker;

class AppFixtures extends Fixture
{

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();
        
        $categories = $this->loadCategories($faker, $manager);
        $authors = $this->loadAuthors($faker, $manager);
        $categories = $this->loadBooks($faker, $manager, $categories, $authors);

        //librarian
        $user = new User();

        $user->setUsername('admin');

        $password = 'admin';
        $password = $this->hasher->hashPassword(
            $user,
            $password
        );

        $user->setPassword($password);

        $roles = $user->getRoles();
        array_push($roles, "ROLE_LIBRARIAN");

        $user->setRoles($roles);

        $manager->persist($user);

        //visitor
        $user = new User();

        $user->setUsername('user');

        $password = 'user';
        $password = $this->hasher->hashPassword(
            $user,
            $password
        );

        $user->setPassword($password);

        $manager->persist($user);

        $manager->flush();
    }

    private function loadCategories($faker, $manager){
        $categories = array();
        for($i = 0; $i < 3; $i++){
            $category = new Category();

            $category->setName($faker->word());

            $categories[] = $category;
            $manager->persist($category);
        }

        return $categories;
    }

    private function loadAuthors($faker, $manager){
        $authors = array();
        for($i = 0; $i < 3; $i++){
            $author = new Author();

            $author->setName($faker->lastName());
            $author->setFirstname($faker->firstName());
            $author->setHandle($faker->word());

            $authors[] = $author;
            $manager->persist($author);
        }

        return $authors;
    }

    private function loadBooks($faker, $manager, $categories, $authors){
        $books = array();
        for($i = 0; $i < 15; $i++){
            $book = new Book();

            $book->setTitle($faker->words(4, true));
            $book->setPublicationDate(new DateTime(`-$i weeks`));

            $randAuths = $faker->numberBetween(1,2);
            for($j = 0; $j < $randAuths; $j++){
                $rand = $faker->numberBetween(0,count($authors)-1);
                $book->addAuthor($authors[$rand]);
            }

            $book->setCatchphrase($faker->catchPhrase());
            $book->setSummary($faker->realText(250, 1));

            $rand = $faker->numberBetween(0, count($categories)-1);
            $book->setCategory($categories[$rand]);

            $books[] = $book;
            $manager->persist($book);
        }

        return $books;
    }
}
