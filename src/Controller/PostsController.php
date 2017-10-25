<?php

namespace App\Controller;

use App\Controller\AppController;

class PostsController extends AppController
{
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

        $this->set('post', $post);
    }

    public function edit($slug)
    {
        $post = $this->Posts->findBySlug($slug)->firstOrFail();

        if ($this->request->is(['post', 'put'])) {
            $post = $this->Posts->patchEntity($post, $this->request->getData());

            if ($this->Posts->save($post)) {
                $this->Flash->success('Post guardado correctamente');

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error('No se ha podido guardar');
        }

        $this->set('post', $post);
    }

    public function delete($slug) {
        $this->request->allowMethod(['post', 'delete']);

        $post = $this->Posts->findBySlug($slug)->firstOrFail();

        if($this->Posts->delete($post)) {
            $this->Flash->success('Post eliminado correctamente');

            return $this->redirect(['action' => 'index']);
        }

        $this->Flash->error('No se ha podido eliminar');
    }
}
