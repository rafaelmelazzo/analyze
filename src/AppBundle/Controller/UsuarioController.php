<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use AppBundle\Service\RandomCpfCnpj;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UsuarioController extends Controller
{

    /**
     * @Route("/usuario/create/{nome}")
     */
    public function createAction($nome)
    {
        if (!$nome) {
            var_dump('Campo nome obrigatório!');
            return new Response();
        }

        $random = new RandomCpfCnpj();

        $usuario = new Usuario();
        $usuario->setNome($nome);
        $usuario->setCpf($random->generateCpf());
        $usuario->setCriadoEm(new \DateTime());

        $em = $this->getDoctrine()->getManager();

        try {
            $em->persist($usuario);
            $em->flush();
        } catch (\Exception $e) {
            var_dump('Ocorreu um erro ao tentar processar sua requisição: ' . $e->getMessage());
            return new Response();
        }

        var_dump("Usuário [$nome] criado com sucesso!");

        return new Response();
    }
}
