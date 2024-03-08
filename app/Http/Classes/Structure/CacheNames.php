<?php

namespace App\Http\Classes\Structure;

final class CacheNames
{
    public const CACHE_TIME_HOUR = 3600;
    public const CACHE_TIME_2_HOUR = 7200;
    public const CACHE_TIME = 3000;
    public const CACHE_TIME_15_MIN = 900;
    public const DIC_CACHE_TIME = 3600;
    public const USER_BRANCH_TIME = 300;
    public const STAFF_LDAP_CACHE_TIME = 28800;
    public const REASON_FOR_CLOSING_TASK_CACHE_TIME = 86400; // 1 day
    public const CONTACTS_EMAILS_CACHE = '_contacts_emails_cache_';
    public const CONTACTS_PHONES_CACHE = '_contacts_phones_cache_';

}
