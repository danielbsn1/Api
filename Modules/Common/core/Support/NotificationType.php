<?php

declare(strict_types=1);

namespace Modules\Common\Core\Support;

enum NotificationType: string
{
    case RELEASE_NOTES = 'release-notes';
  

    public static function all(): array
    {
        return [
            self::RELEASE_NOTES,
          
        ];
    }

    public static function toArray(): array
    {
        return array_column(NotificationType::cases(), 'value');
    }

    public function description(): string
    {
        return match ($this) {
            self::RELEASE_NOTES => 'Notificação de novas notas de versão',
         
        };
    }
}