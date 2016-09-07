<?php

interface StatementStackable
{
    public function stack($tag = null, $connectionAlias = null);

    public function runStack(Stack $stack);
}
