<?php

namespace App\Tests\Api;

interface RequestBuilderInterface
{
    public function isAnonymous(): self;
    public function isLogged(): self;
    public function setMethod(string $method): self;
    public function setUri(string $uri): self;
    public function setBody(array $body): self;
    public function setType(string $type): self;
    public function isWebUser(): self;
}