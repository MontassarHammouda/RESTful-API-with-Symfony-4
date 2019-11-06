<?php

namespace App\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Get;
use App\Entity\User;
use App\Form\UserType;
use FOS\RestBundle\Controller\Annotations as Rest;
class UserController extends Controller
{

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     
     */
    public function postUsersAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em=$this->getDoctrine()->getManager();

            $em->persist($user);
            $em->flush();
            return $user;
        } else {
            return $form;
        }
    }

    /**
     * 
     * @Rest\View()
     
     */
    public function getUsersAction(Request $request)
    {
        $Users = $this->getDoctrine()
        ->getRepository(User::class)
        ->findAll();

return $Users ;
    }

  
     /**
     * 
     * @Rest\View()
     
     */
    public function getUserAction(int $UserId)
    {
        $Users = $this->getDoctrine()
        ->getRepository(User::class)
        ->find($UserId);
        if (empty($Users)) {
            return new JsonResponse(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        return $Users;
    }
    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     */
    public function deleteUserAction(int $UserId)
    {
      $em=$this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)
        ->find($UserId);
        /* @var $user User */

        if ($user) {
            $em->remove($user);
            $em->flush();
        }
    }
    /**
     * @Rest\View()
       */
      public function patchUserAction($id ,Request $request)
      {
          return $this->updateUser($request, false);
      }
  
  
   /**
       * @Rest\View()
         */
        public function putUserAction($id ,Request $request)
        {return $this->updateUser($request, true);
        }

        private function updateUser(Request $request, $clearMissing)
        {
            $user =  $this->getDoctrine()->getManager()
            ->getRepository(User::class)
            ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire
      /* @var $place Place */
      
      if (empty($user)) {
        return new JsonResponse(['message' => 'user not found'], Response::HTTP_NOT_FOUND);
      }
      
      $form = $this->createForm(UserType::class, $user);
      
      $form->submit($request->request->all(),$clearMissing);
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        // l'entité vient de la base, donc le merge n'est pas nécessaire.
        // il est utilisé juste par soucis de clarté
        $em->merge($user);
        $em->flush();
        return $user;
      } else {
        return $form;
      }
            


        }



}
