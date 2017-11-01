<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Utility\Text;
use Cake\Validation\Validator;

class PostsTable extends Table
{
    public function beforeSave($event, $entity, $options)
    {
        if ($entity->isNew() && !$entity->slug) {
            $slug = Text::slug($entity->title);

            $entity->slug = substr($slug, 0, 191);
        }
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmpty('title', 'Título es requerido')
//            ->minLength('title', 10)
            ->add('title', [
                'length' => [
                    'rule' => ['minLength', 10],
                    'message' => 'Título debe al menos tener 10 chars',
                ]
            ])
            ->maxLength('title', 255)
            ->notEmpty('body')
            ->minLength('body', 10);

        return $validator;
    }

    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
        $this->belongsToMany('Categories');
    }
}