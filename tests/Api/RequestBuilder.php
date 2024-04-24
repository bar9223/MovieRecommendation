<?php

declare(strict_types=1);

namespace App\Tests\Api;

class RequestBuilder implements RequestBuilderInterface
{
    public function __construct(
        public string $method = '',
        public string $uri = '',
        public string $token = '',
        public array $body = [],
        public bool $logged = false,
        public string $type = '',
        public array $additionalHeaders = []
    ) {
    }

    public function isAnonymous(): self
    {
        $this->logged = false;

        return $this;
    }

    public function isLogged(): self
    {
        $this->logged = true;

        return $this;
    }

    public function isWebUser(): self
    {
        $this->type = ApiWebTestCase::WEB;

        return $this;
    }

    public function setAdditionalHeaders(array $additionalHeaders): self
    {
        $this->additionalHeaders = $additionalHeaders;

        return $this;
    }

    public function setBody(array $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function setUri(string $uri): self
    {
        $this->uri = $uri;

        return $this;
    }
}
