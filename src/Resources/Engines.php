<?php

declare(strict_types=1);

namespace OpenAI\Resources;

use OpenAI\Responses\Models\DeleteResponse;
use OpenAI\Responses\Models\ListResponse;
use OpenAI\Responses\Models\RetrieveResponse;
use OpenAI\ValueObjects\Transporter\Payload;

final class Engines
{
    use Concerns\Transportable;

    /**
     * Lists the currently available engines, and provides basic information about each one such as the owner and availability.
     *
     * @see https://goose.ai/docs/api/engines/list
     */
    public function list(): ListResponse
    {
        $payload = Payload::list('engines');
        /** @var array{object: string, data: array<int, array{id: string, object: string, created: int, owned_by: string, permission: array<int, array{id: string, object: string, created: int, allow_create_engine: bool, allow_sampling: bool, allow_logprobs: bool, allow_search_indices: bool, allow_view: bool, allow_fine_tuning: bool, organization: string, group: ?string, is_blocking: bool}>, root: string, parent: ?string}>} $result */
        $result = $this->transporter->requestObject($payload);

        return ListResponse::from($result);
    }
}
