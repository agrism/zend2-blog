<?php
/**
 * Created by PhpStorm.
 * User: Agris
 * Date: 01.07.2018
 * Time: 0:10
 */

namespace Admin\Form;


use Admin\Filter\ArticleAddInputFilter;
use Blog\Entity\Categories;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Form\Element\ObjectSelect;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Form;

class ArticleAddForm extends Form implements ObjectManagerAwareInterface
{

    protected $objectManager;

    /**
     * ArticleAddForm constructor.
     * @param $objectManager
     */
    public function __construct($objectManager)
    {
        parent::__construct(ArticleAddForm::class);
        $this->setObjectManager($objectManager);
        $this->createElements();
    }


    public function setObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function getObjectManager()
    {
        return $this->objectManager;
    }


    public function createElements()
    {
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'bs-example form-horizontal');

        $this->setInputFilter(new ArticleAddInputFilter());

        $this->add([
            'type' => ObjectSelect::class,
            'name' => 'category',
            'options' => [
                'label' => 'Category',
                'empty_option' => 'Choose category...',
                'object_manager' => $this->getObjectManager(),
                'target_class' => Categories::class,
                'property' => 'categoryName'
            ],
            'attributes' => [
                'class' => 'form-control',
                'required' => 'required',
            ]
        ]);

        $this->add([
            'name' => 'title',
            'type' => 'Text',
            'options' => [
                'min' => 3,
                'max' => 100,
                'label' => 'Title'
            ],
            'attributes' => [
                'class' => 'form-control',
                'required' => 'required'
            ]
        ]);

        $this->add([
            'name' => 'shortArticle',
            'type' => 'Text',
            'options' =>[
                'label' => 'Entry of article',
            ],
            'attributes' => [
                'class' => 'form-control ckeditor'
            ]
        ]);

        $this->add([
            'name' => 'article',
            'type' => 'Textarea',
            'options' =>[
                'label' => 'Article'
            ],
            'attributes' =>[
                'class' => 'form-control ckeditor',
                'required' => 'required'
            ]
        ]);

        $this->add([
            'name' => 'isPublic',
            'type' => 'Checkbox',
            'options' => [
                'label' => 'Published',
                'use_hidden_Element' => true,
                'check_value' =>1,
                'unchecked_value' => 0
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => [
                'value' => 'Save',
                'id' => 'btn_submit',
                'class' => 'btn btn-primary'
            ]
        ]);
    }
}