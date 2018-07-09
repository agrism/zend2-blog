<?php

namespace Application\Controller;

use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;

class BaseController extends AbstractActionController
{
    protected $entityManager;



    public function onDispatch(MvcEvent $e)
    {
        $this->setEntityManager($this->getServiceLocator()->get(EntityManager::class));
        return parent::onDispatch($e);
    }

    /**
     * @return mixed
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param mixed $entityManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
