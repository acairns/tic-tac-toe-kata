<?php

namespace Tests\AndrewCairns\Tictactoe;

use PHPUnit\Framework\Exception;
use PHPUnit\Framework\InvalidArgumentException;
use ReflectionException;
use ReflectionObject;

trait CanAssertAttributes
{
    public static function assertAttributeEquals(
        $expected,
        string $actualAttributeName,
        $actualClassOrObject,
        string $message = '',
        float $delta = 0.0,
        int $maxDepth = 10,
        bool $canonicalize = false,
        bool $ignoreCase = false
    ): void {
        static::assertEquals(
            $expected,
            static::readAttribute($actualClassOrObject, $actualAttributeName),
            $message,
            $delta,
            $maxDepth,
            $canonicalize,
            $ignoreCase
        );
    }

    public static function assertAttributeCount(
        int $expectedCount,
        string $haystackAttributeName,
        $haystackClassOrObject,
        string $message = ''
    ): void {
        static::assertCount(
            $expectedCount,
            static::readAttribute($haystackClassOrObject, $haystackAttributeName),
            $message
        );
    }

    /**
     * Returns the value of an object's attribute.
     * This also works for attributes that are declared protected or private.
     *
     * @param object $object
     *
     * @throws Exception
     */
    public static function getObjectAttribute($object, string $attributeName)
    {
        if (!is_object($object)) {
            throw InvalidArgumentException::create(1, 'object');
        }

        if (!self::isValidClassAttributeName($attributeName)) {
            throw InvalidArgumentException::create(2, 'valid attribute name');
        }

        $reflector = new ReflectionObject($object);

        do {
            try {
                $attribute = $reflector->getProperty($attributeName);

                if (!$attribute || $attribute->isPublic()) {
                    return $object->{$attributeName};
                }

                $attribute->setAccessible(true);
                $value = $attribute->getValue($object);
                $attribute->setAccessible(false);

                return $value;
            } catch (ReflectionException) {
            }
        } while ($reflector = $reflector->getParentClass());

        throw new Exception(
            sprintf(
                'Attribute "%s" not found in object.',
                $attributeName
            )
        );
    }

    public static function readAttribute($classOrObject, string $attributeName)
    {
        if (!self::isValidClassAttributeName($attributeName)) {
            throw InvalidArgumentException::create(2, 'valid attribute name');
        }

        if (is_string($classOrObject)) {
            if (!class_exists($classOrObject)) {
                throw InvalidArgumentException::create(
                    1,
                    'class name'
                );
            }

            return static::getStaticAttribute(
                $classOrObject,
                $attributeName
            );
        }

        if (is_object($classOrObject)) {
            return static::getObjectAttribute(
                $classOrObject,
                $attributeName
            );
        }

        throw InvalidArgumentException::create(
            1,
            'class name or object'
        );
    }

    private static function isValidClassAttributeName(string $attributeName): bool
    {
        return (bool)preg_match('/[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*/', $attributeName);
    }
}
