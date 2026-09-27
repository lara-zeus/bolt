<?php

namespace LaraZeus\Bolt\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

/**
 * The kinds of file a `file upload` field can accept. The extensions behind each
 * kind come from `zeus-bolt.uploadFileTypes`, so developers decide what an image
 * or a document is, while admins only pick between the kinds.
 */
enum FileUploadType: string implements HasIcon, HasLabel
{
    case Image = 'image';
    case Video = 'video';
    case Audio = 'audio';
    case Document = 'document';

    public function getLabel(): string
    {
        return __('zeus-bolt::forms.fields.options.file_types.' . $this->value);
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Image => 'tabler-photo',
            self::Video => 'tabler-video',
            self::Audio => 'tabler-music',
            self::Document => 'tabler-file-text',
        };
    }

    /**
     * The extensions configured for this kind, lowercased and without a leading dot.
     *
     * @return array<int, string>
     */
    public function extensions(): array
    {
        $extensions = config('zeus-bolt.uploadFileTypes.' . $this->value);

        if (! is_array($extensions)) {
            return [];
        }

        return array_values(array_unique(array_map(
            fn (string $extension): string => strtolower(ltrim($extension, '.')),
            $extensions
        )));
    }

    /**
     * The kinds that have at least one extension configured.
     *
     * @return array<int, self>
     */
    public static function available(): array
    {
        return array_values(array_filter(self::cases(), fn (self $type): bool => filled($type->extensions())));
    }

    /**
     * The extensions of every given kind combined.
     *
     * @param  array<int, self>  $types
     * @return array<int, string>
     */
    public static function extensionsFor(array $types): array
    {
        return array_values(array_unique(array_merge(
            [],
            ...array_map(fn (self $type): array => $type->extensions(), $types)
        )));
    }
}
