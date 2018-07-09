<?php

namespace Blog\Controller;

use Application\Controller\BaseController;
use Blog\Entity\Articles;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;

use Zend\Paginator\Paginator;

class IndexController extends BaseController
{
    public function indexAction()
    {

        $query = $this->getEntityManager()->createQueryBuilder();
        $query
            ->add('select', 'a')
            ->add('from', 'Blog\Entity\Articles a')
            ->add('where', 'a.isPublic=1')
            ->add('orderBy', 'a.id ASC');

        $adapter = new DoctrinePaginator(new ORMPaginator($query));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(1);
        $paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));

        return ['articles' => $paginator];
    }

    public function articleAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        $em = $this->getEntityManager();

        $article = $em->find(Articles::class, $id);

        if (empty($article)) {
            return $this->notFoundAction();
        }

        return ['article' => $article];
    }
}
