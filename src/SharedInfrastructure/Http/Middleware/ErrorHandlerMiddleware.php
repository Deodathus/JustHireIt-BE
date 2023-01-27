<?php

declare(strict_types=1);

namespace App\SharedInfrastructure\Http\Middleware;

use App\Modules\Authentication\Application\Exception\LoginIsAlreadyTaken;
use App\Modules\Authentication\Application\Exception\UserSignUpException;
use App\Modules\Billing\Application\Exception\InvitationCreatorMustBePartOfTeam;
use App\Modules\Billing\Application\Exception\InvitationIsNotActive;
use App\Modules\Billing\Application\Exception\TeamDoesNotExist;
use App\Modules\Candidate\Application\Exception\SkillNameTakenException;
use App\Modules\Job\Application\Exception\ApplicantAlreadyAppliedOnThisJobPost;
use App\Modules\Job\Application\Exception\JobCategoryDoesNotExist;
use App\Modules\Job\Application\Exception\JobCategoryNameAlreadyTaken;
use App\Modules\Job\Application\Exception\JobPostIsNotApplicable;
use App\Modules\Job\Application\Exception\JobPostRequirementDoesNotExist;
use App\SharedInfrastructure\Http\Response\ValidationErrorResponse;
use Assert\LazyAssertionException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

final class ErrorHandlerMiddleware implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof LazyAssertionException) {
            $event->setResponse(
                new JsonResponse(
                    [
                        'errors' => ValidationErrorResponse::getResponseContent(...$exception->getErrorExceptions())
                    ],
                    Response::HTTP_BAD_REQUEST,
                )
            );
        } else if ($exception instanceof HandlerFailedException) {
            $exception = $exception->getPrevious();
            $statusCode = match ($exception::class) {
                JobCategoryDoesNotExist::class,
                TeamDoesNotExist::class,
                JobPostRequirementDoesNotExist::class => Response::HTTP_NOT_FOUND,
                UserSignUpException::class,
                SkillNameTakenException::class,
                ApplicantAlreadyAppliedOnThisJobPost::class,
                InvitationCreatorMustBePartOfTeam::class,
                LoginIsAlreadyTaken::class,
                JobCategoryNameAlreadyTaken::class,
                JobPostIsNotApplicable::class => Response::HTTP_CONFLICT,
                InvitationIsNotActive::class => Response::HTTP_GONE,
                BadRequestHttpException::class => Response::HTTP_BAD_REQUEST,
                default => Response::HTTP_INTERNAL_SERVER_ERROR,
            };

            $event->setResponse(
                new JsonResponse(
                    [
                        'errors' => [
                            $exception->getMessage()
                        ],
                    ],
                    $statusCode
                )
            );
        } else if ($exception instanceof BadRequestHttpException) {
            $event->setResponse(
                new JsonResponse(
                    [
                        'errors' => [
                            $exception->getMessage()
                        ],
                    ],
                    Response::HTTP_BAD_REQUEST
                )
            );
        } else {
            $event->setResponse(
                new JsonResponse(
                    [
                        'errors' => [
                            $exception->getMessage()
                        ],
                    ],
                    Response::HTTP_INTERNAL_SERVER_ERROR
                )
            );
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
