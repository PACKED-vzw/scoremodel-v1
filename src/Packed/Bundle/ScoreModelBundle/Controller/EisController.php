<?php

namespace Packed\Bundle\ScoreModelBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Packed\Bundle\ScoreModelBundle\Entity\Eis;
use Packed\Bundle\ScoreModelBundle\Form\EisType;

/**
 * Eis controller.
 *
 */
class EisController extends Controller
{
    /**
     * Lists all Eis entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ScoreModelBundle:Eis')->findAll();

        return $this->render('ScoreModelBundle:Eis:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a Eis entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ScoreModelBundle:Eis')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Eis entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ScoreModelBundle:Eis:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to create a new Eis entity.
     *
     */
    public function newAction()
    {
        $entity = new Eis();
        $form   = $this->createForm(new EisType(), $entity);

        $secties = $this
            ->get('doctrine')
            ->getEntityManager()
            ->createQuery('SELECT s FROM ScoreModelBundle:Sectie s ORDER BY s.volgorde ASC')
            ->getResult();


        return $this->render('ScoreModelBundle:Eis:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),

        ));
    }

    /**
     * Creates a new Eis entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Eis();
        $form = $this->createForm(new EisType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ai_beheren_sectieseneisen'));
        }

        return $this->render('ScoreModelBundle:Eis:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Eis entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ScoreModelBundle:Eis')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Eis entity.');
        }

        $editForm = $this->createForm(new EisType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ScoreModelBundle:Eis:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Eis entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ScoreModelBundle:Eis')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Eis entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new EisType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ai_beheren_sectieseneisen'));
        }

        return $this->render('ScoreModelBundle:Eis:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Eis entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ScoreModelBundle:Eis')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Eis entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('ai_beheren_sectieseneisen'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
