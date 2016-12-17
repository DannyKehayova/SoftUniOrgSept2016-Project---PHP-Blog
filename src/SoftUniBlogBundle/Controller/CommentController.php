<?php

namespace SoftUniBlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SoftUniBlogBundle\Entity\Article;
use SoftUniBlogBundle\Entity\Comment;
use SoftUniBlogBundle\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CommentController extends Controller
{
    /**
     * @param Request $request
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/comment/create/{id}", name="comment_create")
     *
     */
    public function create(Request $request, $id)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $comment->setArticletocomment($article);
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('article_view', ['id' => $article->getId()]);
        }

        return $this->render('comment/create.html.twig', array(
            'article' => $article,
            'form' => $form->createView()
        ));
    }
}
