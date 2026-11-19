
<?php

namespace App\Enums;

enum ConversationStatus: string
{
    case Pending = 'pending';
    case Active = 'active';
    case Resolved = 'resolved';
}
