<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Place;
use App\Form\PlaceType;
use FOS\RestBundle\Controller\Annotations as Rest;


class PlaceController extends Controller
{
    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     */
    public function postPlaceAction(Request $request)
    {

        $place = new Place();
        $form = $this->createForm(PlaceType::class, $place);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // In case our POST was a success we need to return a 201 HTTP CREATED response

            $em->persist($place);
            $em->flush();

            return $place;
        } else {
            return $form;
        }
    }
    /**
     * 
     * @Rest\View()
     
     */
    public function getPlacesAction(Request $request)
    {
        $places = $this->getDoctrine()
            ->getRepository(Place::class)
            ->findAll();
        /* @var $places Place[] */

        return $places;
    }

    /**
     * @Rest\View()
     */
    public function getPlaceAction(int $placeId)
    {
        $place = $this->getDoctrine()
            ->getRepository(Place::class)
            ->find($placeId);
        /* @var $places Place[] */
        if (empty($place)) {
            return new JsonResponse(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }
        return $place;
    }
    /**
     * @Rest\View()
     */
    public function deletePlaceAction(int $placeId)
    {
        $em = $this->getDoctrine()->getManager();

        $place = $em->getRepository(Place::class)
            ->find($placeId);
        /* @var $place Place */
        if ($place) {
            $em->remove($place);
            $em->flush();
            return new JsonResponse(['message' => '>'.$place->getName()."  Romved"]);
        }
        return new JsonResponse(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
    }


 /**
     * @Rest\View()
       */
    public function putPlaceAction($id ,Request $request)
    {
        return $this->updatePlace($request, true);
    }


 /**
     * @Rest\View()
       */
      public function patchPlaceAction($id ,Request $request)
      {return $this->updatePlace($request, false);
      }
  
      private function updatePlace(Request $request, $clearMissing)
      {
      $place =  $this->getDoctrine()->getManager()
      ->getRepository(Place::class)
      ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire
/* @var $place Place */

if (empty($place)) {
  return new JsonResponse(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
}

$form = $this->createForm(PlaceType::class, $place);

$form->submit($request->request->all(),$clearMissing);
if ($form->isValid()) {
  $em = $this->getDoctrine()->getManager();
  // l'entité vient de la base, donc le merge n'est pas nécessaire.
  // il est utilisé juste par soucis de clarté
  $em->merge($place);
  $em->flush();
  return $place;
} else {
  return $form;
}
      }

}