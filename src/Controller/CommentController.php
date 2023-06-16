<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Program;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/comment', name: 'comment_')]
class CommentController extends AbstractController
{

    #[Route('/{comment}/edit', methods: ['GET', 'POST'], name: 'edit')]
    public function editComment(Comment $comment, CommentRepository $commentRepository, Request $request) {

        if ($this->getUser() !== $comment->getAuthor() && !in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            // If not the owner, throws a 403 Access Denied exception
            throw $this->createAccessDeniedException('Only the owner can edit the program!');
        } else {
            $user = $this->getUser();

            $form = $this->createForm(CommentType::class, $comment);
            $form->handleRequest($request);
        
            if ($form->isSubmitted() && $form->isValid()) {
                $comment->setEpisode($comment->getEpisode());
                $comment->setAuthor($user);
                $commentRepository->save($comment, true);

            return $this->redirectToRoute('program_episode_show', [
                'slug'=> $comment->getEpisode()->getSeason()->getProgram()->getSlug(),
                'season' => $comment->getEpisode()->getSeason()->getId(),   
                'episode' => $comment->getEpisode()->getId(),   
            ]);

            }   
        }
            
        return $this->render('program/edit_comment.html.twig', [
            'form' => $form,
            'program' => $comment->getEpisode()->getSeason()->getProgram(), 
            'episode' => $comment->getEpisode(),
            'season' => $comment->getEpisode()->getSeason(), 
            'comment'=> $comment,  
        ]);

}

    #[Route('/{comment}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Comment $comment, CommentRepository $commentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $commentRepository->remove($comment, true);
            $this->addFlash('danger', 'The comment has been deleted');
        
            return $this->redirectToRoute('program_episode_show', [
                'slug'=> $comment->getEpisode()->getSeason()->getProgram()->getSlug(),
                'season' => $comment->getEpisode()->getSeason()->getId(),   
                'episode' => $comment->getEpisode()->getId(),   
            ]);
            
        }

    }

}
