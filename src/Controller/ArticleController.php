<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Article::class);
        $article= $repository->findAll();
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
            'article' =>$article
        ]);
    }

    /**
     * @Route("/article/add", name="article-add")
     */
    public function addArticle(Request $request ){
        $form = $this->createForm(ArticleType::class, new Article());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $voiture = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($voiture);
            $em->flush();
            return $this->redirectToRoute('article');
        }else {
            return $this->render('article/addarticle.html.twig', [
                'form' => $form->createView(),'errors'=>$form->getErrors()
            ]);
        }
    }

    /**
     * @Route("/detail/{article}", name="article-detail")
     */
    public function detail(Article $article){
        return $this->render('article/articledetail.html.twig', [
            'controller_name' => 'ArticleController',
            'article' => $article
        ]);

    }

}
