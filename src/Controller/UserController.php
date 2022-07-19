<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\Interface\UserInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin")
 */
class UserController extends AbstractController
{
    private UserInterface $iUser;

    public function __construct(UserInterface $iUser)
    {
        $this->iUser = $iUser;
    }

    /**
     * @Route("/users", name="user_list", methods={"GET"})
     *
     * @return Response
     */
    public function listAction(Request $request, PaginatorInterface $paginator): Response
    {

        $users = $paginator->paginate(
            $this->iUser->listUser(),
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('user/list.html.twig', ['users' => $users]);
    }

    /**
     * @Route("/users/create", name="user_create", methods={"GET", "POST"})
     *
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->iUser->createUser($user);

            $this->addFlash('success', "L'utilisateur a bien été ajouté.");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/users/{id}/edit", name="user_edit", methods={"GET", "POST"})
     *
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function editAction(User $user, Request $request): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->iUser->userEdit($user);

            $this->addFlash('success', "L'utilisateur a bien été modifié");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }
}
