<?php

namespace App\Controller;

use App\Entity\Membre;
use Doctrine\ORM\EntityManager;
use PhpParser\Builder\Function_;
use App\HttpClient\ApiHttpClient;
use Doctrine\ORM\Query\Expr\Func;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    #[Route('/users', name: 'users_list')]
    public function index(ApiHttpClient $apiHttpClient): Response
    {
        $users = $apiHttpClient->getUsers();
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/users/add-membre/', name: 'membre_add', methods: 'POST')]
    public function addMembre(EntityManagerInterface $entityManager, Request $request, Membre $membre = null)
    {
        $membre = new Membre();

        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $last = filter_input(INPUT_POST, 'last', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $first = filter_input(INPUT_POST, 'first', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $picture = filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $streetnumber = filter_input(INPUT_POST, 'streetnumber', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $streetname = filter_input(INPUT_POST, 'streetname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $postcode = filter_input(INPUT_POST, 'postcode', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if($title && $first && $last && $email && $phone && $picture && $streetname && $streetnumber && $postcode && $city && $country)
        {
            $membre->setTitle($title);
            $membre->setLast($last);
            $membre->setFirst($first);
            $membre->setEmail($email);
            $membre->setPhone($phone);
            $membre->setPicture($picture);
            $membre->setStreetnumber($streetnumber);
            $membre->setStreetname($streetname);
            $membre->setPostcode($postcode);
            $membre->setCity($city);
            $membre->setCountry($country);

            $entityManager->persist($membre);
            $entityManager->flush();

            return $this->redirectToRoute('users_list');
        } else {
            return $this->redirectToRoute('users_list');
        }
    }
}
