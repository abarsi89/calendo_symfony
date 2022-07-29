<?php

namespace App\Controller;

use App\Entity\VendorAddress;
use App\Form\VendorAddressType;
use App\Repository\VendorAddressRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

/**
 * @Route("/vendor/address")
 */
class VendorAddressController extends AbstractController
{
    /**
     * @Route("/", name="app_vendor_address_index", methods={"GET"})
     */
    public function index(VendorAddressRepository $vendorAddressRepository): Response
    {
        return $this->render('vendor_address/index.html.twig', [
            'vendor_addresses' => $vendorAddressRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_vendor_address_new", methods={"GET", "POST"})
     */
    public function new(Request $request, VendorAddressRepository $vendorAddressRepository): Response
    {
        $vendorAddress = new VendorAddress();
        $vendorAddress->setVendorAddressId(Uuid::v4());
        $form = $this->createForm(VendorAddressType::class, $vendorAddress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vendorAddressRepository->add($vendorAddress, true);

            return $this->redirectToRoute('app_vendor_address_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vendor_address/new.html.twig', [
            'vendor_address' => $vendorAddress,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{vendorAddressId}", name="app_vendor_address_show", methods={"GET"})
     */
    public function show(VendorAddress $vendorAddress): Response
    {
        return $this->render('vendor_address/show.html.twig', [
            'vendor_address' => $vendorAddress,
        ]);
    }

    /**
     * @Route("/{vendorAddressId}/edit", name="app_vendor_address_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, VendorAddress $vendorAddress, VendorAddressRepository $vendorAddressRepository): Response
    {
        $form = $this->createForm(VendorAddressType::class, $vendorAddress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vendorAddressRepository->add($vendorAddress, true);

            return $this->redirectToRoute('app_vendor_address_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vendor_address/edit.html.twig', [
            'vendor_address' => $vendorAddress,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{vendorAddressId}", name="app_vendor_address_delete", methods={"POST"})
     */
    public function delete(Request $request, VendorAddress $vendorAddress, VendorAddressRepository $vendorAddressRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vendorAddress->getVendorAddressId(), $request->request->get('_token'))) {
            $vendorAddressRepository->remove($vendorAddress, true);
        }

        return $this->redirectToRoute('app_vendor_address_index', [], Response::HTTP_SEE_OTHER);
    }
}
