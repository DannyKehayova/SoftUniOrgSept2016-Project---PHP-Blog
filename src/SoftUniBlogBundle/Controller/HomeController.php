<?php

namespace SoftUniBlogBundle\Controller;

use Doctrine\ORM\Mapping\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use SoftUniBlogBundle\Entity\Article;
use SoftUniBlogBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    /**
     * @Route("/", name="blog_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        /** $articles $articles = $this->getDoctrine()->getRepository(Article::class)->findAll(); */
        $articlesSort = $this->getDoctrine()->getRepository(Article::class)->findBy([], ['count' => 'DESC']);
        if (count($articlesSort) <= 4){
            return $this->render('blog/index.html.twig', ['categories' => $categories, 'articles' => $articlesSort]);
        }

        else{
            $countArticles = 0;
            $trimArray = array();
            foreach ($articlesSort as $articl){
                if ($countArticles < 4){
                    $trimArray[$countArticles] = $articl;
                }
                $countArticles++;
            }
            return $this->render('blog/index.html.twig', ['categories' => $categories, 'articles' => $trimArray]);
        }
        /** echo var_dump($articles); */
        /** echo var_dump($articlesSort); */
        return $this->render('blog/index.html.twig', ['categories' => $categories, 'articles' => $articlesSort]);
    }
    /**
     * @Route("/category/{id}", name="category_articles")
     * @param $id
     *
     *@return Response
     */
    public function listArticles($id)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        $articles = $category->getArticles()->toArray();
        return $this->render('article/list.html.twig', ['articles' => $articles, 'category' => $category]);
    }
}
