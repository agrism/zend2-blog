<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Admin\Form\CategoryAddForm;
use Application\Controller\BaseAdminController as BaseController;
use Blog\Entity\Categories;
use Zend\View\Model\ViewModel;

class CategoryController extends BaseController
{

    public function indexAction()
    {
        $query = $this->getEntityManager()->createQuery('SELECT u FROM Blog\Entity\Categories u ORDER BY u.id DESC');

        $rows = $query->getResult();

        return [
            'categories' => $rows
        ];
    }

    public function addAction()
    {
        $form = new CategoryAddForm();
        $status = $message = '';
        $em = $this->getEntityManager();
        $request = $this->getRequest();

        if ($request->isPost()) {

            $form->setData($request->getPost());
            if ($form->isValid()) {

                $category = new Categories();
                $category->exchangeArray($form->getData());

                $em->persist($category);
                $em->flush();

                $status = 'success';
                $message = 'Category is added';
            } else {
                $status = 'error';
                $message = 'Param error';
            }
        } else {
            return ['form' => $form];
        }

        if ($message) {
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
        }

        return $this->redirect()->toRoute('admin/category');
    }

    public function editAction()
    {
        $form = new CategoryAddForm();
        $status = $message = '';
        $em = $this->getEntityManager();
        $request = $this->getRequest();

        $id = (int)$this->params()->fromRoute('id', 0);

        $category = $em->find(Categories::class, $id);

        if (empty($category)) {
            $message = 'Category not found';
            $status = 'error';
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
            return $this->redirect()->toRoute('admin/category');
        }

        $form->bind($category);

        $request = $this->getRequest();

        if ($request->isPost()) {
            $data = $request->getPost();
            $form->setData($data);

            if ($form->isValid()) {
                $em->persist($category);
                $em->flush();

                $status = 'success';
                $message = 'Category updated';
            } else {
                $status = 'error';
                $message = 'Params error';
                foreach ($form->getInputFilter()->getInvalidInput() as $errors) {
                    foreach ($errors->getMessages() as $error) {
                        $message .= ' ' . $error;
                    }
                }
            }
        } else {
            return [
                'form' => $form,
                'id' => $id,
            ];
        }

        if ($message) {
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
        }

        return $this->redirect()->toRoute('admin/category');
    }

    public function deleteAction()
    {
        $em = $this->getEntityManager();
        $id = (int)$this->params()->fromRoute('id', 0);

        $status = 'success';
        $message = 'Category is deleted!';

        try {
            $repository = $em->getRepository(Categories::class);
            $category = $repository->find($id);
            $em->remove($category);
            $em->flush();
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Error on deleting category '.$e->getMessage();
        }

        $this->flashMessenger()->setNamespace($status)->addMessage($message);

        return $this->redirect()->toRoute('admin/category');

    }
}
