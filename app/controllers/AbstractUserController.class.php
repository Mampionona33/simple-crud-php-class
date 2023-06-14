<?php

abstract class AbstractUserController
{
    abstract protected function getVoter($id): string;
    abstract protected function getVoters(array $columns = [], string $condition = null): string;
}