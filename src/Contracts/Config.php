<?php


namespace Sco\Admin\Contracts;

interface Config
{
    public function getTitle();
    public function getPermissions();
    public function getColumns();
}
