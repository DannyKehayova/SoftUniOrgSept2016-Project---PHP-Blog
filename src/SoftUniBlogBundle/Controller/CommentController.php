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

        $currentUser = $this->getUser();
        if (!$currentUser || (!$article->isAuthor($currentUser) && !$currentUser->isAdmin())){
            $currentCount = $article->getCount();
            $currentCount--;
            $em = $this->getDoctrine()->getManager();
            $article->setCount($currentCount);
            $em->persist($article);
            $em->flush();
        }

        return $this->render('comment/create.html.twig', array(
            'article' => $article,
            'form' => $form->createView()
        ));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/comment/delete/{id}", name="comment_delete")
     */
    public function deleteComment($id, Request $request)
    {
        $comment = $this->getDoctrine()->getRepository(Comment::class)->find($id);
        if ($comment === null) {
            $this->redirectToRoute("blog_index");
        }
        $currentUser = $this->getUser();
        if (!$currentUser->isAdmin()) {
            return $this->redirectToRoute('blog_index');
        }

        $articleId = $comment->getArticleId();
        $article = $this->getDoctrine()->getRepository(Article::class)->find($articleId);

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comment);
            $em->flush();
            return $this->redirectToRoute('article_view', ['id' => $articleId]);
        }

        return $this->render('comment/delete.html.twig', array(
            'comment' => $comment,
            'article' => $article,
            'form' => $form->createView()
        ));


    }
}
