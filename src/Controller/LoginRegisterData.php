<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Users;
use App\Entity\Products;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\HttpFoundation\Session\Session;       
        
class LoginRegisterData extends AbstractController
{
    /**
     * @Route("/LoginRegisterData", name="catch") methods={"GET","POST"}
     */
    public function index()
    {
        $request = Request::createFromGlobals(); // the envelope, and were looking inside it.

        $type = $request->request->get('type', 'none');
        if($type == 'registerUser')
        {
            
                $name = $request->request->get('un', 'username');
        
                $pass = $request->request->get('pw', 'password');
                $accType = $request->request->get('acc', 'accType');
        
                // to work the objects
                $entityManager = $this->getDoctrine()->getManager();

                // create blank entity of type "Users"
                $register = new Users();
        
                $register->setUsername($name);
                $register->setPassword($pass);
                $register->setAccType($accType);

                $entityManager->persist($register);

                // actually executes the queries (i.e. the INSERT query)
                $entityManager->flush();
        
                $repository = $this->getDoctrine()->getRepository(Users::class);

                $user = $repository->findOneBy(['username' => $name]);
                if($user){
                    return new Response(
                    $user->getAccType()
                    );
                }
       
                return new Response(
                    'test'
                ); 
            
        }
        else if($type == 'loginUser')
        {
                $name = $request->request->get('un', 'this is the default word');
                $pass = $request->request->get('pw', 'password');

            
                $repository = $this->getDoctrine()->getRepository(Users::class);

          
                $user = $repository->findOneBy(['username' => $name , 'password' => $pass]);

                if($user)
                {   
                   
                    return new Response(

                     $user->getAccType()
                    );
                    

                } 

        }

        return new Response(
            
        );
    }
}