<?php

namespace Admin\Filter;

use Zend\InputFilter\InputFilter;


class ArticleAddInputFilter extends InputFilter
{
    public function __construct()
    {
        $this->add([
            'name' => 'title',
            'required' => 'required',
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 3,
                        'max' => 100,
                    ]
                ]
            ],
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ]
        ]);

        $this->add([
            'name' => 'shortArticle',
            'required' => false,
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'max' => 800
                    ]
                ]
            ],
            'filters' =>[
                ['name' => 'StringTrim']
            ]
        ]);

        $this->add([
            'name' => 'article',
            'required' => true,
            'filters' =>[
                ['name' => 'StringTrim']
            ]
        ]);

        $this->add([
            'name' => 'isPublished',
            'required' => false
        ]);

        $this->add([
            'name' => 'category',
            'required' => true
        ]);
    }
}