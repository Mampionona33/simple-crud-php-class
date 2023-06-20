<?php

abstract class AbstractUserController
{
    abstract protected function getVoter($id): string;
    abstract protected function voterLists(array $columns = [], string $condition = null): string;
}