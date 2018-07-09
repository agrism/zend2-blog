<?php
/**
 * Created by PhpStorm.
 * User: Agris
 * Date: 30.06.2018
 * Time: 19:31
 */

namespace Admin\Controller;


use Admin\Form\ArticleAddForm;
use Application\Controller\BaseController;
use Blog\Entity\Articles;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Zend\Paginator\Paginator;


class ArticleController extends BaseController
{
    public function indexAction()
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select('a')
            ->from(Articles::class, 'a')
            ->orderBy('a.id', 'DESC');

        $adapter = new DoctrineAdapter(new ORMPaginator($query));

        $paginator = new Paginator($adapter);

        $paginator->setDefaultItemCountPerPage(10);
        $paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));

        return [
            'articles' => $paginator
        ];
    }

    public function addAction()
    {
        $em = $this->getEntityManager();
        $form = new ArticleAddForm($em);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $message = $status = '';
            $data = $request->getPost();

            $article = new Articles();
            $form->setHydrator(new DoctrineHydrator($em, Articles::class));
            $form->bind($article);
            $form->setData($data);

            if ($form->isValid()) {
                $em->persist($article);
                $em->flush();

                $status = 'success';
                $message = 'Article is added';

            } else {
                $status = 'error';
                $message = 'Param error';

                foreach ($form->getINputFilter()->getInvalidInput() as $errors) {
                    foreach ($errors->getMessage() as $error) {
                        $message .= $error;
                    }
                }
            }
        } else {
            return [
                'form' => $form
            ];
        }

        if ($message) {
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
        }

        return $this->redirect()->toRoute('admin/article');

    }

    public function editAction()
    {
        $message = $status = '';
        $em = $this->getEntityManager();
        $form = new ArticleAddForm($em);

        $id = (int)$this->params()->fromRoute('id', 0);
        $article = $em->find(Articles::class, $id);

        if (empty($article)) {
            $message = 'Article not found';
            $status = 'error';
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
            return $this->redirect()->toRoute('admin/article');
        }

        $form->setHydrator(new DoctrineHydrator($em, Articles::class));
        $form->bind($article);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();
            $form->setData($data);
            if ($form->isValid()) {
                $em->persist($article);
                $em->flush();

                $status = 'success';
                $message = 'Article is updated';
            } else {
                $status = 'error';
                $message = 'Param error';
                foreach ($form->getInputFilter()->getInvalidInput() as $errors) {
                    foreach ($errors as $error) {
                        $message .= $error;
                    }
                }
            }

        } else {
            return [
                'form' => $form,
                'id' => $id
            ];
        }

        $this->flashMessenger()->setNamespace($status)->addMessage($message);
        return $this->redirect()->toRoute('admin/article');
    }

    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        $em = $this->getEntityManager();

        $status = 'success';
        $message = 'Article is deleted';

        try {
            $repository = $em->getRepository(Articles::class);
            $article = $repository->find($id);
            $em->remove($article);
            $em->flush();

        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Error on deleting: ' . $e->getMessage();
        }

        $this->flashMessenger()->setNamespace($status)->addMessage($message);

        return $this->redirect()->toRoute('admin/article');
    }
}