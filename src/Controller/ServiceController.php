<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use DateTimeImmutable;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

/**
 * @Route("/service")
 */
class ServiceController extends AbstractController
{
//* @Security("is_granted('IS_AUTHENTICATED_FULLY')")
    /**
     * @Route("/", name="app_service_index", methods={"GET"})
     */
    public function index(ServiceRepository $serviceRepository): Response
    {
        return $this->render('service/index.html.twig', [
//            'services' => $serviceRepository->findAll(),
//            'services' => $serviceRepository->findBy(['typeId' => 'max()', 'version' => 'max()']),
            'services' => $serviceRepository->getActualServices(),
        ]);
    }

    /**
     * @Route("/new", name="app_service_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ServiceRepository $serviceRepository): Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->getUser();
            $vendor = $user->getVendor();

            $service->setServiceId(Uuid::v4());
            $service->setVendorId($vendor->getVendorId());
            $service->setTypeId($serviceRepository->getLatestTypeId() + 1);
            $service->setVersion(new \DateTimeImmutable());

            $serviceRepository->add($service, true);

            return $this->redirectToRoute('app_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service/new.html.twig', [
            'service' => $service,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_service_show", methods={"GET"})
     */
    public function show(Service $service): Response
    {
        return $this->render('service/show.html.twig', [
            'service' => $service,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_service_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Service $service, ServiceRepository $serviceRepository): Response
    {
        $editedService = clone $service;

        $form = $this->createForm(ServiceType::class, $editedService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $editedService->setServiceId(Uuid::v4());
            $editedService->setVersion(new \DateTimeImmutable());

            $serviceRepository->add($editedService, true);

            return $this->redirectToRoute('app_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service/edit.html.twig', [
            'service' => $editedService,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_service_delete", methods={"POST"})
     */
    public function delete(Request $request, Service $service, ServiceRepository $serviceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$service->getServiceId(), $request->request->get('_token'))) {
//            $serviceRepository->remove($service, true);
            $service->setDeletedAt(new \DateTimeImmutable());
            $serviceRepository->add($service, true);
        }

        return $this->redirectToRoute('app_service_index', [], Response::HTTP_SEE_OTHER);
    }
}
