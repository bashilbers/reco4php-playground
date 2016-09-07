<?php

interface TransactionalClient
{
    public function transaction($connectionAlias = null);
}
