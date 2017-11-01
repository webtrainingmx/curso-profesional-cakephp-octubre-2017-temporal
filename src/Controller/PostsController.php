<?php

namespace App\Controller;

use App\Controller\AppController;

class PostsController extends AppController
{

    public function __construct($request = null, $response = null,
                                $name = null, $eventManager = null,
                                $components = null)
    {
        parent::__construct($request, $response, $name, $eventManager, $components);

        // Cambiar layout
        $this->viewBuilder()->setLayout('webtraining-zone');
    }

    public function index()
    {
        // ORM: Object Relational Mapping
        $posts = $this->Posts->find();
        $this->set(compact('posts'));
    }

    public function view($slug = null)
    {
        $post = $this->Posts->findBySlug($slug)->firstOrFail();
        $this->set('post', $post);
    }

    public function add()
    {
        $post = $this->Posts->newEntity();

        if ($this->request->is('post')) {
            $post = $this->Posts->patchEntity($post, $this->request->getData());
            $post->user_id = 1;

            if ($this->Posts->save($post)) {
                $this->Flash->success('Post guardado correctamente');

                return $this->redirect(['action' => 'index']);
            }
        }

        // Obtener las categorias
        $categories = $this->Posts->Categories->find('list');

        $this->set('categories', $categories);
        $this->set('post', $post);
    }

    public function edit($slug)
    {
        $post = $this->Posts
            ->findBySlug($slug)
            ->contain('Categories')// Cargar categorias del modelo
            ->firstOrFail();

        if ($this->request->is(['post', 'put'])) {
            $post = $this->Posts->patchEntity($post, $this->request->getData());

            if ($this->Posts->save($post)) {
                $this->Flash->success('Post guardado correctamente');

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error('No se ha podido guardar');
        }

        // Obtener las categorias
        $categories = $this->Posts->Categories->find('list');

        $this->set('categories', $categories);
        $this->set('post', $post);
    }

    public function delete($slug)
    {
        $this->request->allowMethod(['post', 'delete']);

        $post = $this->Posts->findBySlug($slug)->firstOrFail();

        if ($this->Posts->delete($post)) {
            $this->Flash->success('Post eliminado correctamente');

            return $this->redirect(['action' => 'index']);
        }

        $this->Flash->error('No se ha podido eliminar');
    }
}
