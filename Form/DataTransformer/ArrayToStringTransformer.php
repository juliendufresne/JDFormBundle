<?php

namespace JD\FormBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 *
 */
final class ArrayToStringTransformer implements DataTransformerInterface
{
    /**
     * @var string
     */
    private $delimiter;

    /**
     * @param string $delimiter
     */
    public function __construct($delimiter)
    {
        $this->delimiter = $delimiter;
    }

    /**
     * @param string[]|null $value The value in the original representation
     *
     * @return string The value in the transformed representation
     *
     * @throws TransformationFailedException When the transformation fails.
     */
    public function transform($value)
    {
        if (null === $value) {
            return '';
        }

        if (!is_array($value)) {
            throw new TransformationFailedException('Expected an array.');
        }

        return implode($this->delimiter, $value);
    }

    /**
     * @param string $value The value in the transformed representation
     *
     * @return string[] The value in the original representation
     *
     * @throws TransformationFailedException When the transformation fails.
     */
    public function reverseTransform($value)
    {
        if (null === $value) {
            return [];
        }

        if (!is_string($value)) {
            throw new TransformationFailedException('Expected a string.');
        }

        if (empty($value)) {
            return [];
        }

        return explode($this->delimiter, $value);
    }
}
