<?php

declare(strict_types=1);

namespace Rebing\GraphQL\Tests\Objects;

use GraphQL\Error\Error;
use Rebing\GraphQL\Error\ValidationError;

class ErrorFormatter
{
    public function formatError(Error $e): array
    {
        $error = [
            'message' => $e->getMessage(),
        ];

        $locations = $e->getLocations();
        if (! empty($locations)) {
            $error['locations'] = array_map(function ($loc) {
                return $loc->toArray();
            }, $locations);
        }

        $previous = $e->getPrevious();
        if ($previous && $previous instanceof ValidationError) {
            $error['validation'] = $previous->getValidatorMessages();
        }

        return $error;
    }
}
