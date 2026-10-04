<?php

declare(strict_types=1);

namespace Synchra\WebSocket;

/**
 * What happened to the resource an event carries.
 */
enum EventAction: string
{
    case New = 'new';
    case Updated = 'updated';
    case Deleted = 'deleted';
}
