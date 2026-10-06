<?php

namespace App\Enums;

/**
 * BikeType Enum
 * Represents available bike types
 */
class BikeType
{
    public const MOUNTAIN = 'mountain';
    public const ROAD = 'road';
    public const CRUISER = 'cruiser';
    public const HYBRID = 'hybrid';
    public const BMX = 'bmx';
    public const ELECTRIC = 'electric';

    private static array $types = [
        self::MOUNTAIN,
        self::ROAD,
        self::CRUISER,
        self::HYBRID,
        self::BMX,
        self::ELECTRIC,
    ];

    /**
     * Get all bike types
     */
    public static function all(): array
    {
        return self::$types;
    }

    /**
     * Check if type is valid
     */
    public static function isValid(string $type): bool
    {
        return in_array($type, self::$types, true);
    }

    /**
     * Get friendly name for bike type
     */
    public static function getName(string $type): string
    {
        return match ($type) {
            self::MOUNTAIN => 'Mountain Bike',
            self::ROAD => 'Road Bike',
            self::CRUISER => 'Cruiser',
            self::HYBRID => 'Hybrid',
            self::BMX => 'BMX',
            self::ELECTRIC => 'Electric',
            default => 'Unknown',
        };
    }
}
