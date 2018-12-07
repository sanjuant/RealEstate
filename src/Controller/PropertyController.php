<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\ContactType;
use App\Form\PropertySearchType;
use App\Notification\ContactNotification;
use App\Repository\PropertyRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
	/**
	 * @var PropertyRepository
	 */
	private $repository;

	public function __construct(PropertyRepository $repository)
	{
		$this->repository = $repository;
	}

	/**
	 * @Route("biens", name="property.index")
	 * @param PaginatorInterface $paginator
	 * @param Request $request
	 * @return Response
	 */
	public function index(PaginatorInterface $paginator, Request $request): Response
	{
		$search = new PropertySearch();
		$form = $this->createForm(PropertySearchType::class, $search);
		$form->handleRequest($request);

		return $this->render('property/index.html.twig', [
			'current_menu' => 'properties',
			'properties' => $this->repository->paginateAllVisible($search, $request->query->getInt('page', 1)),
			'form' => $form->createView()
		]);
	}

	/**
	 * @Route("biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
	 * @param Property $property
	 * @param string $slug
	 * @param Request $request
	 * @param ContactNotification $notification
	 * @return Response
	 * @throws \Twig_Error_Loader
	 * @throws \Twig_Error_Runtime
	 * @throws \Twig_Error_Syntax
	 */
	public function show(Property $property, string $slug, Request $request, ContactNotification $notification): Response
	{
		$pSlug = $property->getSlug();
		$pId = $property->getId();

		if ($pSlug !== $slug) {
			return $this->redirectToRoute('property.show', [
				'id' => $pId,
				'slug' => $pSlug
			], 301);
		}

		$contact = new Contact();
		$contact->setProperty($property);
		$form = $this->createForm(ContactType::class, $contact);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$notification->notify($contact);
			$this->addFlash('success', 'Votre email a bien été envoyé');
			return $this->redirectToRoute('property.show', [
				'id' => $pId,
				'slug' => $pSlug
			]);
		}

		return $this->render('property/show.html.twig', [
			'current_menu' => 'properties',
			'property' => $property,
			'form' => $form->createView()
		]);
	}
}