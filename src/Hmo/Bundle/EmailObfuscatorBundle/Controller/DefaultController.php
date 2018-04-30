<?php

namespace Hmo\Bundle\EmailObfuscatorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('HmoEmailObfuscatorBundle:Default:index.html.twig');
    }
}
