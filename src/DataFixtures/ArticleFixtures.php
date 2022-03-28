<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $article = new Article();
            $article->setTitle("Titre de l'article $i")
                ->setParagraphe("<p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora, consectetur suscipit consequatur minima id itaque rem ratione sequi voluptatum perspiciatis accusamus quidem iusto odit nam. Minima nostrum ratione numquam, sed sequi officia ab aspernatur saepe voluptates. Nemo architecto accusantium modi neque error eum a quis iusto maiores sequi, eveniet laborum aperiam qui natus ullam sed facilis quos ducimus inventore saepe culpa explicabo! Ab nemo, assumenda voluptas quasi iste unde odio blanditiis animi sed repudiandae quos quod accusamus placeat amet dolorem sapiente sequi neque eaque, fuga quas nesciunt. Officia, magnam? Dolores, quis vitae asperiores quidem a aliquam quisquam earum corrupti odit. $i</p>")
                ->setPictureArticle("https://picsum.photos/1150/180")
                ->setCreatedAt(new \DateTime());
            $manager->persist($article);
        }
        $manager->flush();
    }
}
