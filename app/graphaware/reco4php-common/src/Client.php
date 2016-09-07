<?php

interface Client
{
    public function run($query, $parameters = null, $tag = null, $connectionAlias = null);

    public function runWrite($query, $parameters = null, $tag = null);

    public function sendWriteQuery($query, $parameters = null, $tag = null);

    public function getConnectionManager();

    public function getEventDispatcher();
}
