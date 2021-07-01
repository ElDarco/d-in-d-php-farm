<?php

declare(strict_types=1);

namespace CodeTry\MockServerSDK;

use CodeTry\MockServerSDK\Dto\Request\AddNSettingsRequest;
use CodeTry\MockServerSDK\Dto\Request\CreateNSpaceRequest;
use CodeTry\MockServerSDK\Dto\Response\AddNSettingsResponse;
use CodeTry\MockServerSDK\Dto\Response\CreateNSpaceResponse;

interface ClientInterface
{
    public function createNSpace(CreateNSpaceRequest $checkFineRequest): CreateNSpaceResponse;
    public function addNSettingsToNSpace(AddNSettingsRequest $addNSettingsRequest): AddNSettingsResponse;
}
