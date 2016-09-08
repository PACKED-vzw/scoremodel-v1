<?php

namespace Packed\Bundle\ScoreModelBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Packed\Bundle\ScoreModelBundle\Entity\Sectie;
use Packed\Bundle\ScoreModelBundle\Form\SectieType;

/**
 * Sectie controller.
 *
 */
class SectieController extends Controller
{
    /**
     * Lists all Sectie entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ScoreModelBundle:Sectie')->findAll();

        return $this->render('ScoreModelBundle:Sectie:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a Sectie entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ScoreModelBundle:Sectie')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sectie entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ScoreModelBundle:Sectie:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to create a new Sectie entity.
     *
     */
    public function newAction()
    {
        $entity = new Sectie();
        $form   = $this->createForm(new SectieType(), $entity);

        return $this->render('ScoreModelBundle:Sectie:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Sectie entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Sectie();
        $form = $this->createForm(new SectieType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ai_beheren_sectieseneisen'));
        }

        return $this->render('ScoreModelBundle:Sectie:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Sectie entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ScoreModelBundle:Sectie')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sectie entity.');
        }

        $editForm = $this->createForm(new SectieType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ScoreModelBundle:Sectie:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Sectie entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ScoreModelBundle:Sectie')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sectie entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SectieType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ai_beheren_sectieseneisen'));
        }

        return $this->render('ScoreModelBundle:Sectie:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Sectie entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ScoreModelBundle:Sectie')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Sectie entity.');
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
