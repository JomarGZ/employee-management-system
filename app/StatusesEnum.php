<?php

namespace App;

enum StatusesEnum: string
{
    case ONBOARDING = 'onboarding';
    case INACTIVE = 'inactive';
    case ACTIVE = 'active';
    case ON_LEAVE = 'on leave';
}
