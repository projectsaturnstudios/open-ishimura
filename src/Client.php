<?php

declare(strict_types=1);

namespace OpenAI;

use OpenAI\Contracts\Transporter;
use OpenAI\Resources\Completions;
use OpenAI\Resources\Edits;
use OpenAI\Resources\Embeddings;
use OpenAI\Resources\Files;
use OpenAI\Resources\FineTunes;
use OpenAI\Resources\Images;
use OpenAI\Resources\Models;
use OpenAI\Resources\Engines;
use OpenAI\Resources\Moderations;

final class Client
{
    /**
     * Creates a Client instance with the given API token.
     */
    public function __construct(private readonly Transporter $transporter, private readonly array $abilities = [
        'completions' => true,
        'edits' => true,
        'embeddings' => true,
        'files' => true,
        'fine_tunes' => true,
        'images' => true,
        'models' => true,
        'engines' => false,
        'moderations' => true,
    ])
    {
        // ..
    }

    /**
     * Given a prompt, the model will return one or more predicted completions, and can also return the probabilities
     * of alternative tokens at each position.
     *
     * @see https://beta.openai.com/docs/api-reference/completions
     */
    public function completions(): Completions
    {
        if(!$this->abilities['completions']) throw new \DomainException('Completions are not Supported');
        return new Completions($this->transporter);
    }

    /**
     * Get a vector representation of a given input that can be easily consumed by machine learning models and algorithms.
     *
     * @see https://beta.openai.com/docs/api-reference/embeddings
     */
    public function embeddings(): Embeddings
    {
        if(!$this->abilities['embeddings']) throw new \DomainException('Embeddings are not Supported');
        return new Embeddings($this->transporter);
    }

    /**
     * Given a prompt and an instruction, the model will return an edited version of the prompt.
     *
     * @see https://beta.openai.com/docs/api-reference/edits
     */
    public function edits(): Edits
    {
        if(!$this->abilities['edits']) throw new \DomainException('Edits are not Supported');
        return new Edits($this->transporter);
    }

    /**
     * Files are used to upload documents that can be used with features like Fine-tuning.
     *
     * @see https://beta.openai.com/docs/api-reference/files
     */
    public function files(): Files
    {
        if(!$this->abilities['files']) throw new \DomainException('Files are not Supported');
        return new Files($this->transporter);
    }

    /**
     * List and describe the various models available in the API.
     *
     * @see https://beta.openai.com/docs/api-reference/models
     */
    public function models(): Models | Engines
    {
        if($this->abilities['engines']) return $this->engines();
        else {
            if(!$this->abilities['completions']) throw new \DomainException('Completions are not Supported');
            return new Models($this->transporter);
        }

    }

    public function engines(): Models | Engines
    {
        if(!$this->abilities['engines']) throw new \DomainException('GooseAI Engines are not Supported');
        return new Engines($this->transporter);

    }

    /**
     * Manage fine-tuning jobs to tailor a model to your specific training data.
     *
     * @see https://beta.openai.com/docs/api-reference/fine-tunes
     */
    public function fineTunes(): FineTunes
    {
        if(!$this->abilities['fineTunes']) throw new \DomainException('FineTunes are not Supported');
        return new FineTunes($this->transporter);
    }

    /**
     * Given a input text, outputs if the model classifies it as violating OpenAI's content policy.
     *
     * @see https://beta.openai.com/docs/api-reference/moderations
     */
    public function moderations(): Moderations
    {
        if(!$this->abilities['moderations']) throw new \DomainException('Moderations are not Supported');
        return new Moderations($this->transporter);
    }

    /**
     * Given a prompt and/or an input image, the model will generate a new image.
     *
     * @see https://beta.openai.com/docs/api-reference/images
     */
    public function images(): Images
    {
        if(!$this->abilities['images']) throw new \DomainException('Images are not Supported');
        return new Images($this->transporter);
    }
}
