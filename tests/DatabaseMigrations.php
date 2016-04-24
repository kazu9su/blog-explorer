<?php

trait DatabaseMigrations
{
    /**
     * @before
     */
    public function runDatabaseMigrations()
    {
        $this->artisan('migrate:rollback');

        $this->artisan('migrate');
    }
}