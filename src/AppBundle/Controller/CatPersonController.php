<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrapView;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use AppBundle\Entity\CatPerson;
use AppBundle\Form\CatPersonType;
use AppBundle\Form\CatPersonFilterType;

/**
 * CatPerson controller.
 *
 * @Route("/people")
 */
class CatPersonController extends Controller
{
    /**
     * Ajax.
     *
     * @Route("/ajax/office", name="people_update_office_ajax")
     * @Method("POST")
     */
    public function ajaxOfficeAction(Request $request)
    {
        $id = $request->get('company_select');

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:CatCompanyOffice')->findByCatCompany($id);

        if ($entities) {
            foreach ($entities as $entity) {
                $options[] = [
                    'id'   => $entity->getId(),
                    'name' => $entity->getName(),
                ];
            }
        } else {
            $options[] = [
                'id'   => 0,
                'name' => 'Brak oddziałów',
            ];
        }

        return new JsonResponse(array('options' => $options));
    }

    /**
     * Lists all CatPerson entities.
     *
     * @Route("/", name="people")
     * @Method("GET")
     * @Template("CatPerson/index.html.twig")
     *
     * @param Request $request
     *
     * @return array
     */
    public function indexAction(Request $request)
    {
        list($filterForm, $queryBuilder) = $this->filter($request);

        list($entities, $pagerHtml) = $this->paginator($request, $queryBuilder);

        $deleteForms = [];
        /** @var CatPerson $entity */
        foreach ($entities as $entity) {
            $deleteForms[$entity->getId()] = $this->createDeleteForm($entity->getId())->createView();
        }

        return array(
            'entities'     => $entities,
            'pagerHtml'    => $pagerHtml,
//            'filterForm'   => $filterForm->createView(),
            'delete_forms' => $deleteForms,
        );
    }

    /**
     * Create filter form and process filter request.
     *
     * @param Request $request
     *
     * @return array
     */
    protected function filter(Request & $request)
    {
        $session = $request->getSession();
//        $filterForm   = $this->createForm(CatPersonFilterType::class);

        $em = $this->getDoctrine()->getManager();

        $queryBuilder = $em->getRepository('AppBundle:CatPerson')->createQueryBuilder('e')
            ->addSelect('cc')
            ->addSelect('cco')
            ->addSelect('ccc')
            ->leftJoin('e.catCity', 'cc')
            ->leftJoin('e.catCompanyOffice', 'cco')
            ->leftJoin('cco.catCompany', 'ccc');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('CatPersonControllerFilter');
        }

/*        // Filter action
        if ($request->get('filter_action') == 'filter') {
            // Bind values from the request
            $filterForm->submit($request);

            if ($filterForm->isValid()) {
                // Build the query from the given form object
                $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $queryBuilder);
                // Save filter to session
                $filterData = $filterForm->getData();
                $session->set('CatPersonControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('CatPersonControllerFilter')) {
                $filterData = $session->get('CatPersonControllerFilter');
                $filterForm = $this->createForm(CatPersonFilterType::class, $filterData);
                $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $queryBuilder);
            }
        }*/

        return array(null /*$filterForm*/, $queryBuilder);
    }

    /**
     * Get results from paginator and get paginator view.
     *
     * @param Request $request
     * @param         $queryBuilder
     *
     * @return array
     */
    protected function paginator(Request & $request, $queryBuilder)
    {
        // Paginator
        $adapter    = new DoctrineORMAdapter($queryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(2);
        $currentPage = $request->get('page', 1);
        $pagerfanta->setCurrentPage($currentPage);
        $entities = $pagerfanta->getCurrentPageResults();

        // Paginator - route generator
        $me             = $this;
        $routeGenerator = function ($page) use ($me) {
            return $me->generateUrl('people', array('page' => $page));
        };

        // Paginator - view
        $translator = $this->get('translator');
        $view       = new TwitterBootstrapView();
        $pagerHtml  = $view->render($pagerfanta, $routeGenerator, array(
            'proximity'    => 3,
            'prev_message' => $translator->trans('views.index.pagprev', array(), 'JordiLlonchCrudGeneratorBundle'),
            'next_message' => $translator->trans('views.index.pagnext', array(), 'JordiLlonchCrudGeneratorBundle'),
        ));

        return array($entities, $pagerHtml);
    }

    /**
     * Creates a new CatPerson entity.
     *
     * @Route("/", name="people_create")
     * @Method("POST")
     * @Template("CatPerson/new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new CatPerson();
        $form   = $this->createForm(new CatPersonType(), $entity);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');

            return $this->redirect($this->generateUrl('people_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new CatPerson entity.
     *
     * @Route("/new", name="people_new")
     * @Method("GET")
     * @Template("CatPerson/new.html.twig")
     */
    public function newAction()
    {
        $entity = new CatPerson();
        $form   = $this->createForm(new CatPersonType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a CatPerson entity.
     *
     * @Route("/{id}", name="people_show", requirements={"id" = "\d+"})
     * @Method("GET")
     * @Template("CatPerson/show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:CatPerson')->findWithAllJoins($id);

        if (! $entity) {
            throw $this->createNotFoundException('Unable to find CatPerson entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing CatPerson entity.
     *
     * @Route("/{id}/edit", name="people_edit", requirements={"id" = "\d+"})
     * @Method("GET")
     * @Template("CatPerson/edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var CatPerson $entity */
        $entity = $em->getRepository('AppBundle:CatPerson')->findWithAllJoins($id);

        if (! $entity) {
            throw $this->createNotFoundException('Unable to find CatPerson entity.');
        }

        $editForm   = $this->createForm(new CatPersonType($entity->getCatCompanyOffice()->getCatCompany()), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing CatPerson entity.
     *
     * @Route("/{id}", name="people_update", requirements={"id" = "\d+"})
     * @Method("PUT")
     * @Template("CatPerson/edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:CatPerson')->find($id);

        if (! $entity) {
            throw $this->createNotFoundException('Unable to find CatPerson entity.');
        }

        $editForm = $this->createForm(new CatPersonType(), $entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('people'));
        } else {
            $deleteForm = $this->createDeleteForm($id);

            $this->get('session')->getFlashBag()->add('error', 'flash.update.error');
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a CatPerson entity.
     *
     * @Route("/{id}", name="people_delete", requirements={"id" = "\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->submit($request);

        if ($form->isValid()) {
            $em     = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:CatPerson')->find($id);

            if (! $entity) {
                throw $this->createNotFoundException('Unable to find CatPerson entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.delete.error');
        }

        return $this->redirect($this->generateUrl('people'));
    }

    /**
     * Creates a form to delete a CatPerson entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', HiddenType::class)
            ->getForm();
    }
}
