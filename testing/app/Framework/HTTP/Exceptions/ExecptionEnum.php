<?php

namespace Showcase\Framework\HTTP\Exceptions{

    abstract class ExecptionEnum
    {
        const DEFAULT = 0;
        const CUSTOM = 1;
        const MIGRATION_NOT_FOUND = 2;
        const MODEL_NOT_FOUND = 2;
        const NO_PROPERTY_FOUND = 3;
        const NULL_VALUE = 4;
        const ERROR_DATABASE_CONNECTION = 5;
        const DATABASE_QUERY_ERROR = 6;
        const FILE_NOT_FOUND = 7;
    }
}
