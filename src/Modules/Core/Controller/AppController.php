<?php

declare(strict_types=1);

namespace App\Modules\Core\Controller;

use App\Component\Controller\ControllerInterface;
use App\Utils\Helper\Captcha;
use App\Utils\Response\ApiResponse;
use App\Utils\Response\ApiResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Main controller of application
 * Class AppController.
 */
final class AppController extends AbstractController implements ControllerInterface
{
    use ApiResponseTrait;

    /**
     * Logout, is here because route have to be registered.
     */
    public function getCaptcha(): ApiResponse
    {
        return $this->createApiResponse(Captcha::generate($this->getParameter('kernel.project_dir') . '/public'));
    }

    /**
     * Main route which displays nothing.
     */
    public function getIndex(): Response
    {
        return $this->render('app/index.html.twig');
    }
}
