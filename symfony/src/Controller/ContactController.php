<?php


namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class ContactController extends AbstractController
{
    #[Route('/', name: 'app_homepage', methods: ['GET', 'POST'])]
    public function homepage(
        Request $request,
        ContactRepository $contactRepository,
        EntityManagerInterface $entityManager,
        TranslatorInterface $translator
    ): Response {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $contact = $form->getData();

            $entityManager->persist($contact);
            $entityManager->flush();

            $this->addFlash(
                'success',
                $translator->trans('app.ui.contact.saved')
            );

            return $this->redirectToRoute('app_homepage');
        }

        $queryBuilder = $contactRepository->createOrderBySurnameQueryBuilder();
        $adapter = new QueryAdapter($queryBuilder);
        $pager = Pagerfanta::createForCurrentPageWithMaxPerPage(
            $adapter,
            $request->query->get('page', 1),
            9
        );

        return $this->render('contact/list.html.twig', [
            'form' => $form->createView(),
            'pager' => $pager,
        ]);
    }
}
