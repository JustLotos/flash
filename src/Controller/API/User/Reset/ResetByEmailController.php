<?php

declare(strict_types=1);

namespace App\Controller\API\User\Reset;

use App\Controller\ControllerHelper;
use App\Domain\User\UseCase\Reset\ByEmail\Confirm\Command as ConfirmCommand;
use App\Domain\User\UseCase\Reset\ByEmail\Confirm\Handler as ConfirmHandler;
use App\Domain\User\UseCase\Reset\ByEmail\Request\Command as RequestCommand;
use App\Domain\User\UseCase\Reset\ByEmail\Request\Handler as RequestHandler;
 use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @Route(value="api/user/reset/email") */
class ResetByEmailController extends AbstractController
{
    use ControllerHelper;

    /** @Route("/request/", name="resetByEmail", methods={"POST"}, options={"no_auth": true}) */
    public function reset(Request $request, RequestHandler $handler): Response
    {
        /** @var RequestCommand $command */
        $command = $this->serializer->deserialize($request, RequestCommand::class);
        $this->validator->validate($command);
        $handler->handle($command);
        return $this->response($this->getSimpleSuccessResponse());
    }


    /** @Route("/form/{token}", name="resetByEmailGetForm", methods={"GET"}, options={"no_auth": true}) */
    public function getForm(string $token): RedirectResponse
    {
        return $this->redirectToRoute('index', [
            'vueRouting' => '',
            'resetByEmailGetForm' => 'request',
            'token' => $token
        ]);
    }

    /** @Route("/confirm/", name="resetByEmailConfirm", methods={"POST"}, options={"no_auth": true}) */
    public function confirm(Request $request, ConfirmHandler $handler): RedirectResponse
    {
        $command = $this->serializer->deserialize($request, ConfirmCommand::class);
        $this->validator->validate($command);
        $handler->handle($command);
        return $this->redirectToRoute('index', ['vueRouting' => '', 'resetByEmail' => 'confirm']);
    }
}
