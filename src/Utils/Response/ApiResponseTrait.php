<?php

declare(strict_types=1);

namespace App\Utils\Response;

use App\Utils\Enum\ResponseEnum;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Service\Attribute\Required;

trait ApiResponseTrait
{
    private SerializerInterface $serializer;

    public function createApiResponse(mixed $data = null, bool $status = true, int $httpCode = 200, array $context = []): ApiResponse
    {
        return $this->getApiResponse(['API'], $data, $status, $httpCode, $context);
    }

    public function getApiResponse(array $groups, mixed $data = null, bool $status = true, int $httpCode = 200, array $context = []): ApiResponse
    {
        $result = [
            ResponseEnum::RESPONSE_KEY_STATUS => $status,
        ];

        $result[ResponseEnum::RESPONSE_KEY_DATA] = $data;

        $result = $this->serializer->serialize($result, 'json', array_merge_recursive(['groups' => $groups], $context));

        return new ApiResponse($result, $httpCode);
    }

    #[Required]
    public function setSerializer(SerializerInterface $serializer): void
    {
        $this->serializer = $serializer;
    }
}
