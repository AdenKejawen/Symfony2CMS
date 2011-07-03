<?php

/*
 * This file is part of the Symfony framework.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CMS\Bundle\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CMS\Bundle\BlogBundle\Entity\Post;
use CMS\Bundle\BlogBundle\Entity\PostCategory;
use Symfony\Component\HttpFoundation\Response;
use CMS\Bundle\BlogBundle\Form\PostType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends Controller {
    public function indexAction() {
        return $this->render('CMSBlogBundle:Post:index.html.twig');
    }

    public function createPostAction() {
        $category = new PostCategory();
        $category->setTitle('Test Category');

        $post = new Post();
        $post->setTitle('title');
        $post->setBody('body');

        $post->setCategory($category);

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($category);
        $em->persist($post);
        $em->flush();

        return new Response('Created post id: ' . $post->getId() . ' and category id: ' . $category->getId());
    }

    public function newAction() {
        
        $post = new Post();

        $form = $this->createForm(new PostType(), $post);

        $request = $this->get('request');

        if($request->getMethod() == 'POST') {

            $form->bindRequest($request);

            if($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($post);
                $em->flush();

                return $this->redirect($this->generateUrl('post_edit', array('id' => $post->getId())));
            }
        }

        return $this->render('CMSBlogBundle:Post:edit.html.twig', array('form' => $form->createView(), 'form_path' => $this->generateUrl('post_new')));
        
    }

    public function editAction($id) {

        $em = $this->getDoctrine()->getEntityManager();

        $post = $em->getRepository('CMSBlogBundle:Post')->find($id);
        
        if (!$post) {
            throw new NotFoundHttpException('The post does not exist.');
        }

        $form = $this->createForm(new PostType(), $post);

        $request = $this->get('request');

        if($request->getMethod() == 'POST') {

            $form->bindRequest($request);

            if($form->isValid()) {
                
                $em->flush();
                
            }
        }

        return $this->render('CMSBlogBundle:Post:edit.html.twig', array('form' => $form->createView(), 'form_path' => $this->generateUrl('post_edit', array('id' => $post->getId())), 'item' => $post));
        
    }

}
